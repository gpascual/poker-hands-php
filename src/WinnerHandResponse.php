<?php

namespace PokerHands;

use function Lambdish\Phunctional\map;

class WinnerHandResponse
{
    private Hand $winningHand;
    private HandRank $winningRank;
    private array $winningFigures;

    public function __construct(Hand $winningHand, HandRank $highestRank, array $highestFigures)
    {
        $this->winningHand = $winningHand;
        $this->winningRank = $highestRank;
        $this->winningFigures = $highestFigures;
    }

    public function __toString(): string
    {
        $playerName = $this->winningHand->playerName;
        $cardRank = $this->composeCardRank($this->winningRank);
        $cardFigures = $this->composeFigures($this->winningFigures);
        return "{$playerName} wins. - with {$cardRank}: {$cardFigures}";
    }

    private function composeFigures(array $figures): string
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

    private function composeCardRank(HandRank $handRank): string
    {
        return match ($handRank) {
            HandRank::ThreeOfAKind => 'three of a kind',
            HandRank::TwoPairs => 'two pairs',
            HandRank::Pair => 'pair',
            default => "high card"
        };
    }
}
