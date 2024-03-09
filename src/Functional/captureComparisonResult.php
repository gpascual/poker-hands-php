<?php

namespace PokerHands\Functional;

function captureComparisonResult(callable $comparator, callable $captureCallback): callable
{
    return static function (mixed $elementA, mixed $elementB) use ($comparator, $captureCallback) {
        $comparisonResult = $comparator($elementA, $elementB);

        $captureCallback(
            ...match (true) {
                0 > $comparisonResult => [$elementA, $elementB, false],
                0 < $comparisonResult => [$elementB, $elementA, false],
                default => [$elementA, $elementB, true],
            }
        );

        return $comparisonResult;
    };
}
