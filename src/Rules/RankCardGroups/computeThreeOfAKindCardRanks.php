<?php

namespace PokerHands\Rules\RankCardGroups;

use function Lambdish\Phunctional\filter;

function computeThreeOfAKindCardRanks(array $cards): array
{
    return array_values(filter(
        fn(array $group) => 3 === count($group),
        groupCardsByFigure($cards)
    ));
}
