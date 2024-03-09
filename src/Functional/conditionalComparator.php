<?php

namespace PokerHands\Functional;

function conditionalComparator(callable $conditionCallback, callable $composeComparators): callable
{
    return static fn(...$comparisonItems) => $conditionCallback(...$comparisonItems)
        ? $composeComparators(...$comparisonItems)
        : 0;
}
