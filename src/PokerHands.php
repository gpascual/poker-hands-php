<?php

namespace PokerHands;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\partial;
use function Lambdish\Phunctional\sort;
use function PokerHands\Functional\composeComparators;

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
                    $this->compareRanksAt(HandRank::ThreeOfAKind, 0),
                    $this->compareRankFiguresAt(HandRank::ThreeOfAKind, 0)
                ),
                composeComparators(
                    $this->compareRanksAt(HandRank::TwoPairs, 0),
                    $this->compareRankFiguresAt(HandRank::TwoPairs, 0)
                ),
                composeComparators(
                    $this->compareRanksAt(HandRank::Pair, 0),
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
        return $this->composeWinningPlayerResponse(
            $this->winningHand->playerName,
            $this->winningRank,
            $this->winningFigures
        );
    }

    public function registerWinner(Hand $winningHand, HandRank $winningRank, array $winningFigures): void
    {
        $this->winningHand = $winningHand;
        $this->winningRank = $winningRank;
        $this->winningFigures = $winningFigures;
    }

    private function compareRanksAt(HandRank $handRank, int $position): callable
    {
        return captureComparisonResult(
            function (Hand $handA, Hand $handB) use ($handRank, $position) {
                $figureA = $handA->figureAt($handRank, $position);
                $figureB = $handB->figureAt($handRank, $position);

                if ($figureA && null === $figureB) {
                    return -1;
                }

                if ($figureB && null === $figureA) {
                    return 1;
                }

                return 0;
            },
            partial($this->captureHandComparisonResult(...), $handRank, $position)
        );
    }

    private function compareRankFiguresAt(HandRank $handRank, int $position): callable
    {
        return captureComparisonResult(
            function (Hand $handA, Hand $handB) use ($handRank, $position) {
                if (HandRank::TwoPairs === $handRank) {
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
                }

                $figureB = $handB->figureAt($handRank, $position);
                $figureA = $handA->figureAt($handRank, $position);
                return $figureB->value <=> $figureA->value;
            },
            partial($this->captureHandComparisonResult(...), $handRank, $position)
        );
    }

    public function composeWinningPlayerResponse(string $player, HandRank $highestRank, array $highestFigures): string
    {

        return "$player wins. - with {$this->cardRank($highestRank)}: {$this->cardFigure($highestFigures)}";
    }

    public function cardRank(HandRank $handRank): string
    {
        return match ($handRank) {
            HandRank::ThreeOfAKind => 'three of a kind',
            HandRank::TwoPairs => 'two pairs',
            HandRank::Pair => 'pair',
            default => "high card"
        };
    }

    private function cardFigure(array $figures): string
    {
        return implode(
            ' over ',
            map(
                fn(Figure $figure) => match ($figure) {
                    Figure::Jack => 'Jack',
                    Figure::Queen => 'Queen',
                    Figure::King => 'King',
                    Figure::Ace => 'Ace',
                    default => $figure->value
                },
                $figures
            )
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

        if ($handRank === HandRank::TwoPairs) {
            $this->registerWinner($higherHand, $handRank, $higherHand->rankFigures($handRank));
            return;
        }

        $this->registerWinner($higherHand, $handRank, [$higherHand->figureAt($handRank, $position)]);
    }
}
