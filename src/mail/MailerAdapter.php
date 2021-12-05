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

use craft\mail\transportadapters\BaseTransportAdapter;

class MailerAdapter extends BaseTransportAdapter
{
    // Static Properties
    // =========================================================================

    public static function displayName(): string
    {
        return 'Mulesoft';
    }

    // Public Methods
    // =========================================================================

    public function defineTransport()
    {
        return new MailerTransport();
    }
}
