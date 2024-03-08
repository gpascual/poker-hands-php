<?php

namespace PokerHands;

use function Lambdish\Phunctional\sort as phunctionalSort;
use function PokerHands\Functional\composeComparators;

class PokerHands
{
    private ?Card $winningCard = null;
    private ?Hand $winningHand = null;

    public function whoWins(string $line): string
    {
        phunctionalSort(
            composeComparators(
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
            $this->winningCard
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

    public function composeWinningPlayerResponse(string $player, Card $highestCard): string
    {
        return "{$player} wins. - with high card: {$this->cardFigure($highestCard->figure)}";
    }

    public function compareCardsAt(int $position): callable
    {
        return function (Hand $handA, Hand $handB) use ($position) {
            $comparison = $handB->cardAt($position)->figure->value - $handA->cardAt($position)->figure->value;
            if (0 !== $comparison) {
                $winningHand = match (true) {
                    0 > $comparison => $handA,
                    0 < $comparison => $handB,
                };
                $this->registerWinner($winningHand, $winningHand->cardAt($position));
            }
            return $comparison;
        };
    }

    public function registerWinner(Hand $winningHand, Card $winningCard): void
    {
        $this->winningHand = $winningHand;
        $this->winningCard = $winningCard;
    }
}
