<?php

namespace PokerHands\Rules;

use PokerHands\HandRank;
use PokerHands\WinnerRegistry;

use function PokerHands\Rules\HandComparison\flushHandComparator;
use function PokerHands\Rules\HandComparison\fourOfAKindComparator;
use function PokerHands\Rules\HandComparison\fullHouseHandComparator;
use function PokerHands\Rules\HandComparison\highestCardHandComparator;
use function PokerHands\Rules\HandComparison\pairHandComparator;
use function PokerHands\Rules\HandComparison\straightHandComparator;
use function PokerHands\Rules\HandComparison\threeOfAKindHandComparator;
use function PokerHands\Rules\HandComparison\twoPairsHandComparator;
use function PokerHands\Rules\RankCardGroups\computeFlushCardRanks;
use function PokerHands\Rules\RankCardGroups\computeFourOfAKindCardRanks;
use function PokerHands\Rules\RankCardGroups\computeFullHouseCardRanks;
use function PokerHands\Rules\RankCardGroups\computeHighestCardRanks;
use function PokerHands\Rules\RankCardGroups\computePairCardRanks;
use function PokerHands\Rules\RankCardGroups\computeStraightCardRanks;
use function PokerHands\Rules\RankCardGroups\computeThreeOfAKindCardRanks;
use function PokerHands\Rules\RankCardGroups\computeTwoPairCardRanks;

class RulingsBuilder
{
    private array $rankComparators;
    private \SplObjectStorage $rankCardGroupBuilders;

    public function __construct()
    {
        $this->rankComparators = [];
        $this->rankCardGroupBuilders = new \SplObjectStorage();
    }

    public function addFourOfAKindRules(WinnerRegistry $winnerRegistry): self
    {
        return $this
            ->addRankComparator(fourOfAKindComparator($winnerRegistry))
            ->addCardsRankGroupBuilder(HandRank::FourOfAKind, computeFourOfAKindCardRanks(...));
    }

    public function addFullHouseRules(WinnerRegistry $winnerRegistry): self
    {
        return $this
            ->addRankComparator(fullHouseHandComparator($winnerRegistry))
            ->addCardsRankGroupBuilder(HandRank::FullHouse, computeFullHouseCardRanks(...));
    }

    public function addFlushRules(WinnerRegistry $winnerRegistry): self
    {
        return $this
            ->addRankComparator(flushHandComparator($winnerRegistry))
            ->addCardsRankGroupBuilder(HandRank::Flush, computeFlushCardRanks(...));
    }

    public function addStraightRules(WinnerRegistry $winnerRegistry): self
    {
        return $this
            ->addRankComparator(straightHandComparator($winnerRegistry))
            ->addCardsRankGroupBuilder(HandRank::Straight, computeStraightCardRanks(...));
    }

    public function addThreeOfAKindRules(WinnerRegistry $winnerRegistry): self
    {
        return $this
            ->addRankComparator(threeOfAKindHandComparator($winnerRegistry))
            ->addCardsRankGroupBuilder(HandRank::ThreeOfAKind, computeThreeOfAKindCardRanks(...));
    }

    public function addTwoPairsRules(WinnerRegistry $winnerRegistry): self
    {
        return $this
            ->addRankComparator(twoPairsHandComparator($winnerRegistry))
            ->addCardsRankGroupBuilder(HandRank::TwoPairs, computeTwoPairCardRanks(...));
    }

    public function addPairRules(WinnerRegistry $winnerRegistry): self
    {
        return $this
            ->addRankComparator(pairHandComparator($winnerRegistry))
            ->addCardsRankGroupBuilder(HandRank::Pair, computePairCardRanks(...));
    }

    public function addHighestCardRules(WinnerRegistry $winnerRegistry): RulingsBuilder
    {
        return $this
            ->addRankComparator(highestCardHandComparator($winnerRegistry))
            ->addCardsRankGroupBuilder(HandRank::Card, computeHighestCardRanks(...));
    }

    public function create(): Rulings
    {
        return new Rulings($this->rankComparators, $this->rankCardGroupBuilders);
    }

    private function addRankComparator(callable $comparator): self
    {
        $this->rankComparators[] = $comparator;
        return $this;
    }

    private function addCardsRankGroupBuilder(HandRank $handRank, callable $rankCardGroupBuilder): self
    {
        $this->rankCardGroupBuilders[$handRank] = $rankCardGroupBuilder;
        return $this;
    }
}
