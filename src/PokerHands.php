<?php

namespace PokerHands;

use function Lambdish\Phunctional\partial;
use function Lambdish\Phunctional\sort;
use function PokerHands\Functional\composeComparators;

function ignoreComparatorIf(callable $ignoreConditionCallback, callable $composeComparators): callable
{
    return static fn(...$comparisonItems) => $ignoreConditionCallback(...$comparisonItems)
        ? 0
        : $composeComparators(...$comparisonItems);
}

class PokerHands
{
    private array $winningFigures = [];
    private ?Hand $winningHand = null;
    private ?HandRank $winningRank = null;

    public function whoWins(string $line): string
    {
        sort(
            composeComparators(
                composeComparators(
                    $this->compareRanksAt(HandRank::Flush),
                    ignoreComparatorIf(
                        function (Hand $handA, Hand $handB) {
                            return
                                empty($handA->rankFigures(HandRank::Flush))
                                || empty($handB->rankFigures(HandRank::Flush));
                        },
                        composeComparators(
                            $this->compareRankFiguresAt(HandRank::Card, 0),
                            $this->compareRankFiguresAt(HandRank::Card, 1),
                            $this->compareRankFiguresAt(HandRank::Card, 2),
                            $this->compareRankFiguresAt(HandRank::Card, 3),
                            $this->compareRankFiguresAt(HandRank::Card, 4)
                        )
                    )
                ),
                composeComparators(
                    $this->compareRanksAt(HandRank::Straight),
                    $this->compareRankFiguresAt(HandRank::Straight, 0)
                ),
                composeComparators(
                    $this->compareRanksAt(HandRank::ThreeOfAKind),
                    $this->compareRankFiguresAt(HandRank::ThreeOfAKind, 0)
                ),
                composeComparators(
                    $this->compareRanksAt(HandRank::TwoPairs),
                    $this->compareRankFiguresAt(HandRank::TwoPairs, 0)
                ),
                composeComparators(
                    $this->compareRanksAt(HandRank::Pair),
                    $this->compareRankFiguresAt(HandRank::Pair, 0)
                ),
                $this->compareRankFiguresAt(HandRank::Card, 0),
                $this->compareRankFiguresAt(HandRank::Card, 1),
                $this->compareRankFiguresAt(HandRank::Card, 2),
                $this->compareRankFiguresAt(HandRank::Card, 3),
                $this->compareRankFiguresAt(HandRank::Card, 4)
            ),
            (new HandParser())->parseHandsInput($line)
        );

        if (null === $this->winningHand) {
            return 'Tie.';
        }

        return new WinnerHandResponse($this->winningHand, $this->winningRank, $this->winningFigures);
    }

    public function registerWinner(Hand $winningHand, HandRank $winningRank, array $winningFigures): void
    {
        $this->winningHand = $winningHand;
        $this->winningRank = $winningRank;
        $this->winningFigures = $winningFigures;
    }

    private function compareRanksAt(HandRank $handRank): callable
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
            partial($this->captureHandComparisonResult(...), $handRank, 0)
        );
    }

    private function compareRankFiguresAt(HandRank $handRank, int $position): callable
    {
        return captureComparisonResult(
            match ($handRank) {
                HandRank::TwoPairs => function (Hand $handA, Hand $handB) use ($handRank) {
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
            partial($this->captureHandComparisonResult(...), $handRank, $position)
        );
    }

    private function captureHandComparisonResult(
        HandRank $handRank,
        int $position,
        Hand $higherHand,
        Hand $lowerHand,
        bool $handsAreTie
    ): void {
        if ($handsAreTie) {
            return;
        }

        if (in_array($handRank, [HandRank::TwoPairs, HandRank::Straight], true)) {
            $this->registerWinner($higherHand, $handRank, $higherHand->rankFigures($handRank));
            return;
        }

        $this->registerWinner($higherHand, $handRank, [$higherHand->figureAt($handRank, $position)]);
    }
}
