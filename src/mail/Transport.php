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

use Swift_Events_EventListener;
use Swift_Transport;

abstract class Transport implements Swift_Transport
{
    public function isStarted(): bool
    {
        return true;
    }

    public function start(): bool
    {
        return true;
    }

    public function stop(): bool
    {
        return true;
    }

    public function ping(): bool
    {
        return true;
    }

    public function registerPlugin(Swift_Events_EventListener $plugin) { }
}
