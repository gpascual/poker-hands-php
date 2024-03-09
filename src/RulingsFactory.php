<?php

namespace PokerHands;

use function Lambdish\Phunctional\partial;
use function PokerHands\Functional\captureComparisonResult;
use function PokerHands\Functional\composeComparators;
use function PokerHands\Functional\conditionalComparator;

class RulingsFactory
{
    public static function createDefault(WinnerRegistry $winnerRegistry): Rulings
    {
        $highestCardComparator = composeComparators(
            compareRankFiguresAt($winnerRegistry, HandRank::Card, 0),
            compareRankFiguresAt($winnerRegistry, HandRank::Card, 1),
            compareRankFiguresAt($winnerRegistry, HandRank::Card, 2),
            compareRankFiguresAt($winnerRegistry, HandRank::Card, 3),
            compareRankFiguresAt($winnerRegistry, HandRank::Card, 4)
        );
        $fullHouseComparator = composeComparators(
            compareRanksAt($winnerRegistry, HandRank::FullHouse),
            compareRankFiguresAt($winnerRegistry, HandRank::FullHouse, 0),
            compareRankFiguresAt($winnerRegistry, HandRank::FullHouse, 1),
        );
        $flushComparator = composeComparators(
            compareRanksAt($winnerRegistry, HandRank::Flush),
            conditionalComparator(
                function (Hand $handA, Hand $handB) {
                    return !empty($handA->rankFigures(HandRank::Flush))
                        && !empty($handB->rankFigures(HandRank::Flush));
                },
                $highestCardComparator
            )
        );
        $straightComparator = composeComparators(
            compareRanksAt($winnerRegistry, HandRank::Straight),
            compareRankFiguresAt($winnerRegistry, HandRank::Straight, 0)
        );
        $threeOfAKindComparator = composeComparators(
            compareRanksAt($winnerRegistry, HandRank::ThreeOfAKind),
            compareRankFiguresAt($winnerRegistry, HandRank::ThreeOfAKind, 0)
        );
        $twoPairsComparator = composeComparators(
            compareRanksAt($winnerRegistry, HandRank::TwoPairs),
            compareRankFiguresAt($winnerRegistry, HandRank::TwoPairs, 0)
        );
        $pairComparator = composeComparators(
            compareRanksAt($winnerRegistry, HandRank::Pair),
            compareRankFiguresAt($winnerRegistry, HandRank::Pair, 0)
        );
        return new Rulings(
            [
                $fullHouseComparator,
                $flushComparator,
                $straightComparator,
                $threeOfAKindComparator,
                $twoPairsComparator,
                $pairComparator,
                $highestCardComparator
            ]
        );
    }
}

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
                return $figureB->value <=> $figureA->value;
            }
        },
        partial($winnerRegistry->captureHandComparisonResult(...), $handRank, $position)
    );
}

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
