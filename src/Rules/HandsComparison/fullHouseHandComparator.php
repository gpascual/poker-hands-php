<?php

namespace PokerHands\Rules\HandComparison;

use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function PokerHands\Functional\composeComparators;

function fullHouseHandComparator(WinnerRegistry $winnerRegistry): callable
{
    return composeComparators(
        compareRanksAt($winnerRegistry, HandRank::FullHouse),
        compareRankFiguresAt($winnerRegistry, HandRank::FullHouse, 0),
        compareRankFiguresAt($winnerRegistry, HandRank::FullHouse, 1),
    );
}
