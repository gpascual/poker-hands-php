<?php

namespace PokerHands\UserInterface;

use PokerHands\Figure;
use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function Lambdish\Phunctional\map;

class WinnerResponse
{
    private WinnerRegistry $winnerRegistry;

    public function __construct(WinnerRegistry $winnerRegistry)
    {
        $this->winnerRegistry = $winnerRegistry;
    }

    public function __toString(): string
    {
        if (null === $this->winnerRegistry->getWinningHand()) {
            return 'Tie.';
        }

        $playerName = $this->winnerRegistry->getWinningHand()->playerName;
        $cardRank = $this->composeCardRank($this->winnerRegistry->getWinningRank());
        $cardFigures = $this->composeReason(
            $this->winnerRegistry->getWinningRank(),
            $this->winnerRegistry->getWinningFigures()
        );
        return "{$playerName} wins. - with {$cardRank}: {$cardFigures}";
    }

    private function composeReason(HandRank $handRank, array $figures): string
    {
        if ($handRank === HandRank::Flush) {
            return current($this->winnerRegistry->getWinningHand()->rankCardsAt($handRank, 0))->suit->name;
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
            HandRank::StraightFlush => 'straight flush',
            HandRank::FourOfAKind => 'four of a kind',
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
