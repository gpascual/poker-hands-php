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
        $cardFigures = $this->composeReason($this->winningRank, $this->winningFigures);
        return "{$playerName} wins. - with {$cardRank}: {$cardFigures}";
    }

    private function composeReason(HandRank $handRank, array $figures): string
    {
        if ($handRank === HandRank::Flush) {
            return current($this->winningHand->rankCardsAt($handRank, 0))->suit->name;
        }

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
            HandRank::FullHouse => 'full house',
            HandRank::Flush => 'flush',
            HandRank::Straight => 'straight',
            HandRank::ThreeOfAKind => 'three of a kind',
            HandRank::TwoPairs => 'two pairs',
            HandRank::Pair => 'pair',
            default => "high card"
        };
    }
}
