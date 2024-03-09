<?php

describe('comparing hands', function () {
    describe(
        'given a hand with three of a kind',
        function () {
            it(
                'should declare winner the hand with the highest three of a kind',
                function ($expectedResult, $inputHands) {
                    $result = $this->pokerHands->whoWins($inputHands);

                    expect($result)->toBe($expectedResult);
                }
            )->with([
                [
                    'White wins. - with three of a kind: 8',
                    'Black: 2H 3D 5S 9C AD  White: 2C 8H 8S 8C KH',
                ],
                [
                    'White wins. - with three of a kind: 8',
                    'Black: 2H 3D 9S 9C AD  White: 2C 8H 8S 8C KH',
                ],
                [
                    'Black wins. - with three of a kind: 5',
                    'Black: 2H 5D 5S 5C KD  White: 2C 3H 4S 8C QH',
                ],
                [
                    'Black wins. - with three of a kind: 9',
                    'Black: 2H 3D 9S 9C 9D  White: 2C 8H 8S 8C KH',
                ],
                [
                    'White wins. - with three of a kind: 6',
                    'Black: 2H 3D 5S 5C 5D  White: 6D 6H 6C 9S KH',
                ],
            ]);
        }
    );

    describe(
        'given a hand with a pair',
        function () {
            it(
                'should declare winner the hand with the highest pair',
                function ($expectedResult, $inputHands) {
                    $result = $this->pokerHands->whoWins($inputHands);

                    expect($result)->toBe($expectedResult);
                }
            )->with([
                [
                    'White wins. - with pair: 8',
                    'Black: 2H 3D 5S 9C AD  White: 2C 3H 8S 8C KH',
                ],
                [
                    'Black wins. - with pair: 5',
                    'Black: 2H 3D 5S 5C KD  White: 2C 3H 4S 8C QH',
                ],
                [
                    'Black wins. - with pair: 9',
                    'Black: 2H 3D 5S 9C 9D  White: 2C 3H 8S 8C KH',
                ],
                [
                    'White wins. - with pair: 6',
                    'Black: 2H 3D 5S 5C KD  White: 2D 6H 6C 9S KH',
                ],
            ]);
        }
    );

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
                ],
                [
                    'Black wins. - with high card: 9',
                    'Black: 2H 3D 5S 9C KD  White: 2C 3H 4S 8C KH',
                ],
                [
                    'White wins. - with high card: 6',
                    'Black: 2H 3D 5S 9C KD  White: 2D 3H 6C 9S KH',
                ],
                [
                    'Black wins. - with high card: 4',
                    'Black: 2H 4D 5S 9C KD  White: 2D 3H 5C 9S KH',
                ],
                [
                    'White wins. - with high card: 3',
                    'Black: 2H 4D 5S 9C KD  White: 3D 4H 5C 9S KH',
                ],
                [
                    'Tie.',
                    'Black: 2H 4D 5S 9C KD  White: 2D 4H 5C 9S KH',
                ]
            ]);
        }
    );
});
