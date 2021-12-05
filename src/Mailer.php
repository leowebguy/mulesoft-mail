<?php
/**
 * Mulesoft mailer adapter for Craft 3
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2021, leowebguy
 * @license    MIT
 */

namespace leowebguy\mulesoftmail;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterComponentTypesEvent;
use craft\helpers\MailerHelper;
use leowebguy\mulesoftmail\models\MailerModel;
use leowebguy\mulesoftmail\mail\MailerAdapter;
use yii\base\Event;

class Mailer extends Plugin
{
    // Static Properties
    // =========================================================================

    public static $plugin;

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        if (!$this->isInstalled) {
            return;
        }

        Event::on(
            MailerHelper::class,
            MailerHelper::EVENT_REGISTER_MAILER_TRANSPORT_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = MailerAdapter::class;
            }
        );

        // log info
        Craft::info(
            Craft::t(
                'mulesoftmail',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Public Methods
    // =========================================================================

    protected function createSettingsModel()
    {
        return new MailerModel();
    }

    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('mulesoftmail/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
