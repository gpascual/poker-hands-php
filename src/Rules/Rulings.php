<?php

namespace PokerHands\Rules;

use PokerHands\Card;
use PokerHands\Hand;

use function PokerHands\Functional\composeComparators;

class Rulings
{
    private array $rankComparators;
    private \SplObjectStorage $rankCardGroupBuilders;

    public function __construct(array $rankComparators, \SplObjectStorage $rankCardGroupBuilders)
    {
        $this->rankComparators = $rankComparators;
        $this->rankCardGroupBuilders = $rankCardGroupBuilders;
    }

    public function handRanksComparator(): callable
    {
        return composeComparators(...$this->rankComparators);
    }

    /**
     * @param Card[] $cards
     */
    public function createHand(string $player, array $cards): Hand
    {
        return new Hand(
            $player,
            $this->groupCardsByRank($cards)
        );
    }

    private function groupCardsByRank(array $cards): \SplObjectStorage
    {
        usort(
            $cards,
            fn (Card $cardA, Card $cardB) => $cardB->figure->value <=> $cardA->figure->value
        );

        $groups = new \SplObjectStorage();
        foreach ($this->rankCardGroupBuilders as $handRank) {
            $group = ($this->rankCardGroupBuilders[$handRank])($cards);
            $groups[$handRank] = $group;
        }
        return $groups;
    }
}
