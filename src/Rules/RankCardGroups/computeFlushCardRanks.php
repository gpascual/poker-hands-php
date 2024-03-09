<?php

namespace PokerHands\Rules\RankCardGroups;

use PokerHands\Card;

use function Lambdish\Phunctional\map;

function computeFlushCardRanks(array $cards): array
{
    $isFlush = 1 === count(
        array_unique(
            map(fn(Card $card) => $card->suit->value, $cards)
        )
    );

    if ($isFlush) {
        return [$cards];
    }
    return [];
}
