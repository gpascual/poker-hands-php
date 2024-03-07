<?php

namespace PokerHands;

class Hand
{
    private array $cards;

    /**
     * @param array $cards
     */
    public function __construct(...$cards)
    {
        usort(
            $cards,
            static fn ($cardA, $cardB) => $cardB[0] - $cardA[0]
        );

        $this->cards = $cards;
    }

    public function cardAt(int $position): array
    {
        return $this->cards[$position];
    }
}
