<?php

namespace PokerHands\Rules\RankCardGroups;

use PokerHands\Card;

use function Lambdish\Phunctional\group_by;
use function Lambdish\Phunctional\memoize;

function groupCardsByFigure($cards)
{
    return memoize(
        function ($cards) {
            $groups = group_by(
                fn(Card $card) => $card->figure->value,
                $cards
            );
            krsort($groups);
            return $groups;
        },
        $cards
    );
}
