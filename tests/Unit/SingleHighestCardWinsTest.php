<?php

describe(
    'given hands with single cards only',
    function () {
        it(
            'should declare winner the hand with highest card',
            function ($expectedResult, $inputHands) {
                $result = $this->pokerHands->whoWins($inputHands);

                expect($result)->toBe($expectedResult);
            }
        )->with([
            [
                'White wins. - with high card: Ace',
                'Black: 2H 3D 5S 9C KD  White: 2C 3H 4S 8C AH',
            ],
            [
                'Black wins. - with high card: King',
                'Black: 2H 3D 5S 9C KD  White: 2C 3H 4S 8C QH',
            ]
        ]);
    }
);
