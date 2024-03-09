<?php

namespace PokerHands;

use SplObjectStorage;

use function Lambdish\Phunctional\map;

class Hand
{
    public function __construct(public readonly string $playerName, private readonly SplObjectStorage $cardsByRank)
    {
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
