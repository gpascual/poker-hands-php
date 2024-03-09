<?php

namespace PokerHands\Rules\HandComparison;

use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function PokerHands\Functional\composeComparators;

function twoPairsHandComparator(WinnerRegistry $winnerRegistry): callable
{
    return composeComparators(
        compareRanksAt($winnerRegistry, HandRank::TwoPairs),
        compareRankFiguresAt($winnerRegistry, HandRank::TwoPairs, 0)
    );
}
