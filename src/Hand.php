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
            static fn (Card $cardA, Card $cardB) => $cardB->figure->value - $cardA->figure->value
        );

        $this->cards = $cards;
    }

    public function cardAt(int $position): Card
    {
        return $this->cards[$position];
    }
}
