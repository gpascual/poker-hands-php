<?php

namespace PokerHands\Rules\HandComparison;

use PokerHands\Hand;
use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function PokerHands\Functional\composeComparators;
use function PokerHands\Functional\conditionalComparator;

function flushHandComparator(WinnerRegistry $winnerRegistry): callable
{
    return composeComparators(
        compareRanksAt($winnerRegistry, HandRank::Flush),
        conditionalComparator(
            function (Hand $handA, Hand $handB) {
                return !empty($handA->rankFigures(HandRank::Flush))
                    && !empty($handB->rankFigures(HandRank::Flush));
            },
            highestCardHandComparator($winnerRegistry)
        )
    );
}
