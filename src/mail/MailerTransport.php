<?php
/**
 * Mulesoft mailer adapter for Craft 3
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2021, leowebguy
 * @license    MIT
 */

namespace leowebguy\mulesoftmail\mail;

use Craft;
use craft\helpers\App;
use craft\helpers\Json;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Swift_Mime_SimpleMessage;

class MailerTransport extends Transport
{
    // Public Methods
    // =========================================================================

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null): int
    {
        try {
            $from = is_array($message->getFrom()) ? key($message->getFrom()) : $message->getFrom();
            $to = is_array($message->getTo()) ? key($message->getTo()) : $message->getTo();
            $subject = $message->getSubject();
            $body = quoted_printable_decode($message->toString());

            if (empty($to)) {
                return 0;
            }

            $settings = Craft::$app->plugins->getPlugin('mulesoftmail')->getSettings();

            $token = $this->_getAuth($settings);

            $client = new Client();
            $mailer = $client->post(App::parseEnv($settings['mailerSendEndpoint']), [
                //'debug' => TRUE,
                'headers' => [
                    'client_id' => App::parseEnv($settings['mailerId']),
                    'client_secret' => App::parseEnv($settings['mailerSecret']),
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'text/plain'
                ],
                'body' => "To: $to\nFrom: $from\nSubject: $subject\n\n$body\n\n"
            ]);

            $result = Json::decodeIfJson($mailer->getBody()->getContents());

            if (strpos($result['Status'], "SUCCESS") !== false) {
                return 1;
            }

            return 0;
        } catch (ClientException $e) {
            Craft::error($e->getMessage(), 'mulesoftmail');
            return 0;
        }
    }

    // Private Methods
    // =========================================================================

    private function _getAuth($settings)
    {
        try {
            $client = new Client();
            $auth = $client->get(App::parseEnv($settings['mailerAuthEndpoint']), [
                //'debug' => TRUE,
                'headers' => [
                    'Accept' => '*/*',
                    'client_id' => App::parseEnv($settings['mailerId']),
                    'client_secret' => App::parseEnv($settings['mailerSecret']),
                    'grant_type' => 'client_credentials',
                    'scope' => 'WRITE'
                ]
            ]);

            $body = Json::decodeIfJson(($auth->getBody()->getContents()));

            return $body['access_token'] ?? '';
        } catch (ClientException $e) {
            Craft::error($e->getMessage(), 'mulesoftmail');
        }
    }
}
