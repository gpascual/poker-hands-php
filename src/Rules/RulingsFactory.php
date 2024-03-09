<?php

namespace PokerHands\Rules;

use PokerHands\WinnerRegistry;

class RulingsFactory
{
    public static function createDefault(WinnerRegistry $winnerRegistry): Rulings
    {
        return (new RulingsBuilder())
            ->addFullHouseRules($winnerRegistry)
            ->addFlushRules($winnerRegistry)
            ->addStraightRules($winnerRegistry)
            ->addThreeOfAKindRules($winnerRegistry)
            ->addTwoPairsRules($winnerRegistry)
            ->addPairRules($winnerRegistry)
            ->addHighestCardRules($winnerRegistry)
            ->create();
    }
}
