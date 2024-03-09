<?php

namespace PokerHands\Rules\RankCardGroups;

function computeFullHouseCardRanks(array $cards): array
{
    $threeOfAKindRanks = computeThreeOfAKindCardRanks($cards);
    $pairsRanks = computePairCardRanks($cards);
    if (!empty($threeOfAKindRanks) && !empty($pairsRanks)) {
        return [
            $threeOfAKindRanks[0],
            $pairsRanks[0],
        ];
    }
    return [];
}
