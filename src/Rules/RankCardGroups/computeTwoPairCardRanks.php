<?php

namespace PokerHands\Rules\RankCardGroups;

function computeTwoPairCardRanks(array $cards): array
{
    $pairCardRanks = computePairCardRanks($cards);
    if (2 === count($pairCardRanks)) {
        return $pairCardRanks;
    }
    return [];
}
