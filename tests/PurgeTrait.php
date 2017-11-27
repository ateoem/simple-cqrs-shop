<?php

namespace Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;

trait PurgeTrait
{
    public function purge()
    {
        $purger = new ORMPurger($this->em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
    }
}