<?php

namespace PokerHands;

use function PokerHands\Functional\composeComparators;

class PokerHands
{
    private int $position;

    public function whoWins(string $line): string
    {
        $handParser = new HandParser();
        $hands = $handParser->parseHandsInput($line);

        $comparator = composeComparators(
            $this->compareCardsAt(0),
            $this->compareCardsAt(1),
            $this->compareCardsAt(2),
            $this->compareCardsAt(3),
            $this->compareCardsAt(4)
        );

        $cardComparison = $comparator(...array_values($hands));

        $players = array_keys($hands);
        return match (true) {
            0 > $cardComparison => $this->composeWinningPlayerResponse(
                $players[0],
                $hands[$players[0]]->cardAt($this->position)
            ),
            0 < $cardComparison => $this->composeWinningPlayerResponse(
                $players[1],
                $hands[$players[1]]->cardAt($this->position)
            ),
            default => 'Tie.'
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

    public function composeWinningPlayerResponse(string $player, Card $highestCard): string
    {
        return "$player wins. - with high card: {$this->cardFigure($highestCard->figure)}";
    }

    public function compareCardsAt(int $position): callable
    {
        return function (Hand $handA, Hand $handB) use ($position) {
            $comparison = $handB->cardAt($position)->figure->value - $handA->cardAt($position)->figure->value;
            if (0 !== $comparison) {
                $this->position = $position;
            }
            return $comparison;
        };
    }
}
