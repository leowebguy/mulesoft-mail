<?php
/**
 * Mulesoft mailer adapter for Craft 3
 *
 * @author     Leo Leoncio
 * @see        https://github.com/leowebguy
 * @copyright  Copyright (c) 2021, leowebguy
 * @license    MIT
 */

namespace leowebguy\mulesoftmail\models;

use craft\base\Model;

/**
 * CurrencyConverterModel.
 */
class MailerModel extends Model
{
    public $mailerAuthEndpoint = '';
    public $mailerId = '';
    public $mailerSecret = '';
    public $mailerSendEndpoint = '';
}
