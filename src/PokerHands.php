<?php

namespace PokerHands;

use function Lambdish\Phunctional\partial;
use function Lambdish\Phunctional\sort;
use function PokerHands\Functional\composeComparators;

class PokerHands
{
    private ?Figure $winningFigure = null;
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
            $this->winningFigure
        );
    }

    public function registerWinner(Hand $winningHand, HandRank $winningRank, Figure $winningFigure): void
    {
        $this->winningHand = $winningHand;
        $this->winningRank = $winningRank;
        $this->winningFigure = $winningFigure;
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
                $figureA = $handB->figureAt($handRank, $position);
                $figureB = $handA->figureAt($handRank, $position);
                return $figureA->value <=> $figureB->value;
            },
            partial($this->captureHandComparisonResult(...), $handRank, $position)
        );
    }

    public function composeWinningPlayerResponse(string $player, HandRank $highestRank, Figure $highestFigure): string
    {

        return "$player wins. - with {$this->cardRank($highestRank)}: {$this->cardFigure($highestFigure)}";
    }

    public function cardRank(HandRank $handRank): string
    {
        return match ($handRank) {
            HandRank::ThreeOfAKind => 'three of a kind',
            HandRank::Pair => 'pair',
            default => "high card"
        };
    }

    private function cardFigure(Figure $figure): string
    {
        return match ($figure) {
            Figure::Jack => 'Jack',
            Figure::Queen => 'Queen',
            Figure::King => 'King',
            Figure::Ace => 'Ace',
            default => $figure->value
        };
    }

    function captureHandComparisonResult(HandRank $handRank, int $position, Hand $higherHand, Hand $lowerHand, bool $handsAreTie): void
    {
        if ($handsAreTie) {
            return;
        }

        $this->registerWinner($higherHand, $handRank, $higherHand->figureAt($handRank, $position));
    }
}
