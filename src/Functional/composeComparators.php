<?php

namespace PokerHands\Functional;

function composeComparators(callable ...$comparators): callable
{
    return static function ($itemA, $itemB) use ($comparators) {
        foreach ($comparators as $comparator) {
            $comparison = $comparator($itemA, $itemB);

            if (0 !== $comparison) {
                return $comparison;
            }
        }

        return 0;
    };
}
