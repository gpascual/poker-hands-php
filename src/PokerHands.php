<?php

namespace PokerHands;

use function Lambdish\Phunctional\sort;
use function PokerHands\Functional\composeComparators;

class PokerHands
{
    private ?Figure $winningFigure = null;
    private ?Hand $winningHand = null;

    public function whoWins(string $line): string
    {
        sort(
            composeComparators(
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
            $this->winningFigure
        );
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

    public function composeWinningPlayerResponse(string $player, Figure $highestFigure): string
    {
        return "$player wins. - with high card: {$this->cardFigure($highestFigure)}";
    }

    public function registerWinner(Hand $winningHand, Figure $winningFigure): void
    {
        $this->winningHand = $winningHand;
        $this->winningFigure = $winningFigure;
    }

    private function compareRanksAt(HandRank $handRank, int $position): \Closure
    {
        return function (Hand $handA, Hand $handB) use ($handRank, $position) {
            $pairA = $handA->figureAt($handRank, $position);
            $pairB = $handB->figureAt($handRank, $position);

            if ($pairA && null === $pairB) {
                $this->registerWinner($handA, $pairA);
                return -1;
            }

            if ($pairB && null === $pairA) {
                $this->registerWinner($handB, $pairB);
                return 1;
            }

            return 0;
        };
    }

    private function compareRankFiguresAt(HandRank $handRank, int $position): \Closure
    {
        return function (Hand $handA, Hand $handB) use ($handRank, $position) {
            $pairA = $handA->figureAt($handRank, $position);
            $pairB = $handB->figureAt($handRank, $position);

            $comparison = $pairB->value <=> $pairA->value;
            if (0 !== $comparison) {
                $winningHand = match (true) {
                    0 > $comparison => $handA,
                    0 < $comparison => $handB,
                };
                $this->registerWinner($winningHand, $winningHand->figureAt($handRank, $position));
            }
            return $comparison;
        };
    }
}
