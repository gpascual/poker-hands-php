<?php

namespace PokerHands\Rules\RankCardGroups;

use function Lambdish\Phunctional\filter;

function computePairCardRanks(array $cards): array
{
    return array_values(filter(
        fn(array $group) => 2 === count($group),
        groupCardsByFigure($cards)
    ));
}
