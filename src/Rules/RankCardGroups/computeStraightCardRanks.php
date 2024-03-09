<?php

namespace PokerHands\Rules\RankCardGroups;

use PokerHands\Card;

use function Lambdish\Phunctional\reduce;

function computeStraightCardRanks(array $cards): array
{
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
        return [$straight];
    }

    return [];
}
