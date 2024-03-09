<?php
namespace PokerHands\Rules\HandComparison;

use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function PokerHands\Functional\composeComparators;

function fourOfAKindComparator(WinnerRegistry $winnerRegistry): callable
{
    return composeComparators(
        compareRanksAt($winnerRegistry, HandRank::FourOfAKind),
        compareRankFiguresAt($winnerRegistry, HandRank::FourOfAKind, 0)
    );
}
