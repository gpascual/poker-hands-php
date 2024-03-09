<?php

namespace PokerHands\Rules\HandComparison;

use PokerHands\Hand;
use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function Lambdish\Phunctional\partial;
use function PokerHands\Functional\captureComparisonResult;

function compareRankFiguresAt(WinnerRegistry $winnerRegistry, HandRank $handRank, int $position): callable
{
    return captureComparisonResult(
        match ($handRank) {
            HandRank::TwoPairs, HandRank::FullHouse => function (Hand $handA, Hand $handB) use ($handRank) {
                $figures = array_map(
                    null,
                    $handA->rankFigures($handRank),
                    $handB->rankFigures($handRank)
                );

                foreach ($figures as [$figureA, $figureB]) {
                    if ($figureA->value === $figureB->value) {
                        continue;
                    }

                    return $figureB->value <=> $figureA->value;
                }

                return 0;
            },
            default => function (Hand $handA, Hand $handB) use ($handRank, $position) {
                $figureB = $handB->figureAt($handRank, $position);
                $figureA = $handA->figureAt($handRank, $position);

                if ($figureA && $figureB) {
                    return $figureB->value <=> $figureA->value;
                }

                return 0;
            }
        },
        partial($winnerRegistry->captureHandComparisonResult(...), $handRank, $position)
    );
}
