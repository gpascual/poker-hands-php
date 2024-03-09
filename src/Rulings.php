<?php

namespace PokerHands;

use function PokerHands\Functional\composeComparators;

class Rulings
{
    private array $rankComparators;

    public function __construct(array $rankComparators)
    {
        $this->rankComparators = $rankComparators;
    }

    public function handRanksComparator(): callable
    {
        return composeComparators(...$this->rankComparators);
    }
}
