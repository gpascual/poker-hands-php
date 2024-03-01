<?php

namespace PokerHands;

use function Lambdish\Phunctional\map;

class PokerHands
{
    public function whoWins(string $line): string
    {
        $handParser = new HandParser();
        $hands = $handParser->parseHandsInput($line);

        $cardNumbers = map(
            fn($cards) => map(fn($card) => $card[0], $cards),
            $hands
        );

        $highestCards = map(
            fn ($cardNumbers) => max($cardNumbers),
            $cardNumbers
        );

        $players = array_keys($hands);
        $highestCards = array_values($highestCards);

        $cardComparison = $highestCards[1] - $highestCards[0];

        return match (true) {
            0 > $cardComparison => $this->composeWinningPlayerResponse($players[0], $highestCards[0]),
            0 < $cardComparison => $this->composeWinningPlayerResponse($players[1], $highestCards[1]),
            default => ''
        };
    }

    private function cardFigure(int $figure): string
    {
        return match ($figure) {
            10 => 'Jack',
            11 => 'Queen',
            12 => 'King',
            13 => 'Ace',
            default => $figure
        };
    }

    public function composeWinningPlayerResponse(string $player, int $highestFigure): string
    {
        return "{$player} wins. - with high card: {$this->cardFigure($highestFigure)}";
    }
}