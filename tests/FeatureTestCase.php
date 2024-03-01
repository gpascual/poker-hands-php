<?php

namespace PokerHands\Tests;

use PHPUnit\Framework\TestCase;
use PokerHands\PokerHands;

class FeatureTestCase extends TestCase
{
    protected PokerHands $pokerHands;

    protected function setUp(): void
    {
        $this->pokerHands = new PokerHands();
    }
}