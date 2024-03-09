<?php

namespace PokerHands\Rules\RankCardGroups;

use function Lambdish\Phunctional\filter;

function computeFourOfAKindCardRanks(array $cards): array
{
    return array_values(filter(
        fn(array $group) => 4 === count($group),
        groupCardsByFigure($cards)
    ));
}
