<?php

namespace PokerHands\Rules\HandComparison;

use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function PokerHands\Functional\composeComparators;

function threeOfAKindHandComparator(WinnerRegistry $winnerRegistry): callable
{
    return composeComparators(
        compareRanksAt($winnerRegistry, HandRank::ThreeOfAKind),
        compareRankFiguresAt($winnerRegistry, HandRank::ThreeOfAKind, 0)
    );
}
