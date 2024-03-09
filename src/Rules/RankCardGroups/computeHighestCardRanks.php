<?php

namespace PokerHands\Rules\RankCardGroups;

use PokerHands\Card;

use function Lambdish\Phunctional\map;

function computeHighestCardRanks(array $cards): array
{
    return map(fn(Card $card) => [$card], $cards);
}
