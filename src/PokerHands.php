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
                $this->comparePairsAt(0),
                $this->compareCardsAt(0),
                $this->compareCardsAt(1),
                $this->compareCardsAt(2),
                $this->compareCardsAt(3),
                $this->compareCardsAt(4)
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

    public function compareCardsAt(int $position): callable
    {
        return function (Hand $handA, Hand $handB) use ($position) {
            $comparison = $handB->figureAt(HandRank::Card, $position)->value <=> $handA->figureAt(HandRank::Card, $position)->value;
            if (0 !== $comparison) {
                $winningHand = match (true) {
                    0 > $comparison => $handA,
                    0 < $comparison => $handB,
                };
                $this->registerWinner($winningHand, $winningHand->figureAt(HandRank::Card, $position));
            }
            return $comparison;
        };
    }

    public function comparePairsAt(int $position): callable
    {
        return function (Hand $handA, Hand $handB) use ($position) {
            $pairA = $handA->figureAt(HandRank::Pair, $position);
            $pairB = $handB->figureAt(HandRank::Pair, $position);

            if ($pairA && null === $pairB) {
                $this->registerWinner($handA, $pairA);
                return -1;
            }

            if ($pairB && null === $pairA) {
                $this->registerWinner($handB, $pairB);
                return 1;
            }

            $comparison = $pairB->value <=> $pairA->value;
            if (0 !== $comparison) {
                $winningHand = match (true) {
                    0 > $comparison => $handA,
                    0 < $comparison => $handB,
                };
                $this->registerWinner($winningHand, $winningHand->figureAt(HandRank::Pair, $position));
            }
            return $comparison;
        };
    }

    public function registerWinner(Hand $winningHand, Figure $winningFigure): void
    {
        $this->winningHand = $winningHand;
        $this->winningFigure = $winningFigure;
    }
}
