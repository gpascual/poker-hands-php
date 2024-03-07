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

        $cardComparison = $highestCards[1][0] - $highestCards[0][0];

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

    public function composeWinningPlayerResponse(string $player, $highestCard): string
    {
        return "{$player} wins. - with high card: {$this->cardFigure($highestCard[0])}";
    }
}
