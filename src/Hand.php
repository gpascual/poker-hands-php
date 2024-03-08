<?php

namespace PokerHands;

use SplObjectStorage;
use function Lambdish\Phunctional\filter;
use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reduce;

class Hand
{
    private SplObjectStorage $cardsByRank;

    /**
     * @param array $cards
     */
    public function __construct(public readonly string $playerName, Card ...$cards)
    {
        usort(
            $cards,
            static fn (Card $cardA, Card $cardB) => $cardB->figure->value - $cardA->figure->value
        );


        $this->cardsByRank = $this->computeCardHandRanks(...$cards);
    }

    public function figureAt(HandRank $handRank, int $position): ?Figure
    {
        return current(
            map(
                fn (Card $card) => $card->figure,
                $this->cardsByRank[$handRank][$position] ?? []
            )
        ) ?: null;
    }

    private function computeCardHandRanks(Card ...$cards): SplObjectStorage
    {
        $groupedCards = reduce(
            function (array $groups, Card $card) {
                $groups[$card->figure->value][] = $card;
                return $groups;
            },
            $cards,
            []
        );

        krsort($groupedCards);

        $ranks = new SplObjectStorage();
        $ranks[HandRank::Card] = map(fn (Card $card) => [$card], $cards);
        $ranks[HandRank::Pair] = array_values(filter(
            fn(array $group) => 2 === count($group),
            $groupedCards
        ));

        return $ranks;
    }
}
