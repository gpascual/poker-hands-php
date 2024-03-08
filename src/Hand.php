<?php

namespace PokerHands;

use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\filter;

class Hand
{
    private array $cards;

    /**
     * @param array $cards
     */
    public function __construct(public readonly string $playerName, ...$cards)
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

    public function pairAt(int $position): ?Card
    {
        $groupedCards = reduce(
            function (array $groups, Card $card) {
                $groups[$card->figure->value][] = $card;
                return $groups;
            },
            $this->cards,
            []
        );

        krsort($groupedCards);

        $pairs = array_values(filter(
            fn(array $group) => 2 === count($group),
            $groupedCards
        ));

        return current($pairs[$position] ?? []) ?: null;
    }
}
