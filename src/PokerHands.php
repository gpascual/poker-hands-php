<?php

namespace PokerHands;

use function Lambdish\Phunctional\map;

class PokerHands
{
    public function whoWins(string $line): string
    {
        $handParser = new HandParser();
        $hands = $handParser->parseHandsInput($line);

        $highestCards = map(
            fn (Hand $hand) => $hand->cardAt(0),
            $hands
        );

        $players = array_keys($hands);
        $highestCards = array_values($highestCards);

        $cardComparison = $highestCards[1]->figure->value - $highestCards[0]->figure->value;

        return match (true) {
            0 > $cardComparison => $this->composeWinningPlayerResponse($players[0], $highestCards[0]),
            0 < $cardComparison => $this->composeWinningPlayerResponse($players[1], $highestCards[1]),
            default => ''
        };
    }

    private function cardFigure(Figure $figure): string
    {
        return match ($figure) {
            Figure::Jack => 'Jack',
            Figure::Queen => 'Queen',
            Figure::King => 'King',
            Figure::Ace => 'Ace',
            default => $figure
        };
    }

    public function composeWinningPlayerResponse(string $player, Card $highestCard): string
    {
        return "$player wins. - with high card: {$this->cardFigure($highestCard->figure)}";
    }
}
