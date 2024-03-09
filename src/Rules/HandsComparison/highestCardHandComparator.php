<?php

namespace PokerHands\Rules\HandComparison;

use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function PokerHands\Functional\composeComparators;

function highestCardHandComparator(WinnerRegistry $winnerRegistry): callable
{
    return composeComparators(
        compareRankFiguresAt($winnerRegistry, HandRank::Card, 0),
        compareRankFiguresAt($winnerRegistry, HandRank::Card, 1),
        compareRankFiguresAt($winnerRegistry, HandRank::Card, 2),
        compareRankFiguresAt($winnerRegistry, HandRank::Card, 3),
        compareRankFiguresAt($winnerRegistry, HandRank::Card, 4)
    );
}
