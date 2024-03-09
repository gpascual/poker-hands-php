<?php

describe('comparing hands', function () {
    describe(
        'given a hand with straight flush',
        function () {
            it(
                'should declare winner the hand with the highest flush',
                function ($expectedResult, $inputHands) {
                    $result = $this->pokerHands->whoWins($inputHands);

                    expect($result)->toBe($expectedResult);
                }
            )->with([
                'left should win over a four of a kind' => [
                    'Black wins. - with straight flush: 6 over 2',
                    'Black: 2H 3H 5H 4H 6H  White: 7C 4H 7S 7C 7H',
                ],
                'right should win over a four of a kind' => [
                    'White wins. - with straight flush: 9 over 5',
                    'Black: 6C 4H 5S 8C 7H  White: 7S 6S 5S 9S 8S',
                ],
                'left should win over a straight flush with lower figures' => [
                    'Black wins. - with straight flush: 9 over 5',
                    'Black: 7S 6S 5S 9S 8S  White: 2H 3H 5H 4H 6H',
                ],
                'right should win over a straight flush with lower figures' => [
                    'White wins. - with straight flush: 9 over 5',
                    'Black: 2H 3H 5H 4H 6H  White: 7S 6S 5S 9S 8S',
                ],
            ]);
        }
    );

    describe(
        'given a hand with four of a kind',
        function () {
            it(
                'should declare winner the hand with the highest four of a kind',
                function ($expectedResult, $inputHands) {
                    $result = $this->pokerHands->whoWins($inputHands);

                    expect($result)->toBe($expectedResult);
                }
            )->with([
                'left should win over a full house' => [
                    'Black wins. - with four of a kind: 3',
                    'Black: 3S 3D 3C 4D 3H  White: QS QD 2C 2D QH',
                ],
                'right should win over a full house' => [
                    'White wins. - with four of a kind: 4',
                    'Black: QS QD 2C 2D QH  White: 4S 3D 4C 4D 4H',
                ],
                'left should win over four of a kind' => [
                    'Black wins. - with four of a kind: 5',
                    'Black: 5S 5D 5C 4D 5H  White: 3S 3D 3C 4D 3H',
                ],
                'right should win over four of a kind' => [
                    'White wins. - with four of a kind: 5',
                    'Black: 3S 3D 3C 4D 3H  White: 5S 5D 5C 4D 5H',
                ],
            ]);
        }
    );

    describe(
        'given a hand with full house',
        function () {
            it(
                'should declare winner the hand with the highest full house',
                function ($expectedResult, $inputHands) {
                    $result = $this->pokerHands->whoWins($inputHands);

                    expect($result)->toBe($expectedResult);
                }
            )->with([
                'left should win over a flush' => [
                    'Black wins. - with full house: 3 over 4',
                    'Black: 3S 3D 4C 4D 3H  White: 2H 3H 5H 9H JH',
                ],
                'right should win over a flush' => [
                    'White wins. - with full house: Queen over 2',
                    'Black: 2H 3H 5H 9H JH  White: QS QD 2C 2D QH',
                ],
                'left should win over a full house with lower three of a kind' => [
                    'Black wins. - with full house: 9 over 4',
                    'Black: 9S 9D 4C 4D 9H  White: 2C 5H 5D 2D 2H',
                ],
                'right should win over a full house with lower three of a kind' => [
                    'White wins. - with full house: 9 over 4',
                    'Black: 2C 5H 5D 2D 2H  White: 9S 9D 4C 4D 9H',
                ],
                'left should win over a full house with lower pair' => [
                    'Black wins. - with full house: 5 over 4',
                    'Black: 5S 5D 4C 4D 5H  White: 2C 5H 5D 2D 2H',
                ],
                'right should win over a full house with lower pair' => [
                    'White wins. - with full house: 5 over 4',
                    'Black: 2C 5H 5D 2D 2H  White: 5S 5D 4C 4D 5H',
                ],
            ]);
        }
    );

    describe(
        'given a hand with flush',
        function () {
            it(
                'should declare winner the hand with the highest flush',
                function ($expectedResult, $inputHands) {
                    $result = $this->pokerHands->whoWins($inputHands);

                    expect($result)->toBe($expectedResult);
                }
            )->with([
                'left should win over a straight with lower figures' => [
                    'Black wins. - with flush: Hearts',
                    'Black: 2H 3H 5H 9H AH  White: 6C 4H 5S 8C 7H',
                ],
                'right should win over a straight with lower figures' => [
                    'White wins. - with flush: Spades',
                    'Black: 6C 4H 5S 8C 7H  White: 2S 3S 5S 9S AS',
                ],
                'left should win over a flush with lower figures' => [
                    'Black wins. - with high card: Ace',
                    'Black: AD 3D 2D 4D 5D  White: 2H 3H 5H 9H JH',
                ],
                'right should win over a flush with lower figures' => [
                    'White wins. - with high card: Ace',
                    'Black: 2H 3H 5H 9H JH  White: AD 3D 2D 4D 5D',
                ],
            ]);
        }
    );

    describe(
        'given a hand with straight',
        function () {
            it(
                'should declare winner the hand with the highest straight',
                function ($expectedResult, $inputHands) {
                    $result = $this->pokerHands->whoWins($inputHands);

                    expect($result)->toBe($expectedResult);
                }
            )->with([
                'left should win over highest card hands' => [
                    'Black wins. - with straight: 8 over 4',
                    'Black: 6C 4H 5S 8C 7H  White: 2H 3D 5S 9C AD',
                ],
                'right should win over highest card hands' => [
                    'White wins. - with straight: 8 over 4',
                    'Black: 2C 2H 8S 8C KH  White: 6C 4H 5S 8C 7H',
                ],
                'left should win over a pair' => [
                    'Black wins. - with straight: 8 over 4',
                    'Black: 6C 4H 5S 8C 7H  White: 2H 3D 9S 9C AD',
                ],
                'right should win over a pair' => [
                    'White wins. - with straight: 8 over 4',
                    'Black: 2H 3D 9S 9C AD  White: 6C 4H 5S 8C 7H',
                ],
                'left should win over two pairs' => [
                    'Black wins. - with straight: 8 over 4',
                    'Black: 6C 4H 5S 8C 7H  White: 3C 3H 4S 4C QH',
                ],
                'right should win over two pairs' => [
                    'White wins. - with straight: 8 over 4',
                    'Black: 3C 3H 4S 4C QH  White: 6C 4H 5S 8C 7H',
                ],
                'left should win over three of a kind' => [
                    'Black wins. - with straight: 8 over 4',
                    'Black: 6C 4H 5S 8C 7H  White: 2C 9H 9S 9C KH',
                ],
                'right should win over three of a kind' => [
                    'White wins. - with straight: 8 over 4',
                    'Black: 2H 9D 9S 9C QD  White: 6C 4H 5S 8C 7H',
                ],
                'left should win over a straight with lower figures' => [
                    'Black wins. - with straight: 9 over 5',
                    'Black: 8H 9D 5S 7C 6D  White: 6C 4H 5S 8C 7H',
                ],
                'right should win over a straight with lower figures' => [
                    'White wins. - with straight: 9 over 5',
                    'Black: 6C 4H 5S 8C 7H  White: 8H 9D 5S 7C 6D',
                ],
            ]);
        }
    );

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
