<?php

namespace PokerHands\Rules\HandComparison;

use PokerHands\Hand;
use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function Lambdish\Phunctional\partial;
use function PokerHands\Functional\captureComparisonResult;

function compareRanksAt(WinnerRegistry $winnerRegistry, HandRank $handRank): callable
{
    return captureComparisonResult(
        function (Hand $handA, Hand $handB) use ($handRank) {
            $figureA = $handA->figureAt($handRank, 0);
            $figureB = $handB->figureAt($handRank, 0);

            if ($figureA && null === $figureB) {
                return -1;
            }

            if ($figureB && null === $figureA) {
                return 1;
            }

            return 0;
        },
        partial($winnerRegistry->captureHandComparisonResult(...), $handRank, 0)
    );
}
