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
            static fn(Card $cardA, Card $cardB) => $cardB->figure->value - $cardA->figure->value
        );


        $this->cardsByRank = $this->computeCardHandRanks(...$cards);
    }

    public function figureAt(HandRank $handRank, int $position): ?Figure
    {
        return current(
            map(
                fn(Card $card) => $card->figure,
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
        $ranks[HandRank::Card] = map(fn(Card $card) => [$card], $cards);
        $pairs = array_values(filter(
            fn(array $group) => 2 === count($group),
            $groupedCards
        ));
        $ranks[HandRank::Pair] = $pairs;
        if (2 === count($pairs)) {
            $ranks[HandRank::TwoPairs] = $pairs;
        }
        $ranks[HandRank::ThreeOfAKind] = array_values(filter(
            fn(array $group) => 3 === count($group),
            $groupedCards
        ));

        $straight = reduce(
            function (array $partialStraight, Card $card) {
                if (empty($partialStraight)) {
                    $partialStraight[] = $card;
                    return $partialStraight;
                }

                if (end($partialStraight)->figure->value === ($card->figure->value + 1)) {
                    $partialStraight[] = $card;
                    return $partialStraight;
                }

                return $partialStraight;
            },
            $cards,
            []
        );

        if (5 === count($straight)) {
            $ranks[HandRank::Straight] = [$straight];
        }

        $isFlush = 1 === count(
            array_unique(
                map(fn(Card $card) => $card->suit->value, $cards)
            )
        );

        if ($isFlush) {
            $ranks[HandRank::Flush] = [$cards];
        }

        if (!empty($ranks[HandRank::ThreeOfAKind]) && !empty($ranks[HandRank::Pair])) {
            $ranks[HandRank::FullHouse] = [
               $ranks[HandRank::ThreeOfAKind][0],
               $ranks[HandRank::Pair][0],
            ];
        }

        return $ranks;
    }

    /**
     * @return Figure[]
     */
    public function rankFigures(HandRank $handRank): array
    {
        if (empty($this->cardsByRank[$handRank])) {
            return [];
        }

        if ($handRank === HandRank::Straight) {
            $cards = current($this->cardsByRank[$handRank]);
            $cards = [$cards[0], $cards[4]];
            return map(fn($card) => $card->figure, $cards);
        }

        return map(
            fn($card) => $card->figure,
            map(fn($cards) => current($cards), $this->cardsByRank[$handRank])
        );
    }

    /**
     * @return Card[]
     */
    public function rankCardsAt(HandRank $handRank, int $position): array
    {
        if (empty($this->cardsByRank[$handRank])) {
            return [];
        }

        return $this->cardsByRank[$handRank][$position];
    }
}
