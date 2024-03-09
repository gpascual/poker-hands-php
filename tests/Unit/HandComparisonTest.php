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
                    'Black: 2H 2D 9S 9C AD  White: 2C 8H 8S 8C KH',
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
        'given a hand with two pairs',
        function () {
            it(
                'should declare winner the hand with the highest two pairs',
                function ($expectedResult, $inputHands) {
                    $result = $this->pokerHands->whoWins($inputHands);

                    expect($result)->toBe($expectedResult);
                }
            )->with([
                'left should win over highest card hands' => [
                    'Black wins. - with two pairs: 8 over 2',
                    'Black: 2C 2H 8S 8C KH  White: 2H 3D 5S 9C AD',
                ],
                'right should win over highest card hands' => [
                    'White wins. - with two pairs: 8 over 2',
                    'Black: 2H 3D 5S 9C AD  White: 2C 2H 8S 8C KH',
                ],
                'left should win over a pair' => [
                    'Black wins. - with two pairs: 8 over 2',
                    'Black: 2C 2H 8S 8C KH  White: 2H 3D 9S 9C AD',
                ],
                'right should win over a pair' => [
                    'White wins. - with two pairs: 8 over 2',
                    'Black: 2H 3D 9S 9C AD  White: 2C 2H 8S 8C KH',
                ],
                'left should win over two pairs with lower 1st pair' => [
                    'Black wins. - with two pairs: 5 over 2',
                    'Black: 2H 2D 5S 5C KD  White: 3C 3H 4S 4C QH',
                ],
                'right should win over two pairs with lower 1st pair' => [
                    'White wins. - with two pairs: 5 over 2',
                    'Black: 3C 3H 4S 4C QH  White: 2H 2D 5S 5C KD',
                ],
                'left should win over two pairs with lower 2nd pair' => [
                    'Black wins. - with two pairs: 9 over 3',
                    'Black: 3H 3D 9S 9C QD  White: 2C 2H 9S 9C KH',
                ],
                'right should win over two pairs with lower 2nd pair' => [
                    'White wins. - with two pairs: 9 over 3',
                    'Black: 2H 2D 9S 9C QD  White: 3C 3H 9S 9C KH',
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
