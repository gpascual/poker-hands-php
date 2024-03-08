<?php

use PokerHands\HandParser;

describe(
    'HandParsing',
    function () {
        it('should return a proper representation of input hands',
        function () {
            $handParser = new HandParser();

            $result = $handParser->parseHandsInput(
                'Black: 2H 3D 5S 9C KD  White: 2C 3H 4S 8C AH'
            );

            expect($result)->toBe([
                'Black' => [
                    [2, 'H'],
                    [3, 'D'],
                    [5, 'S'],
                    [9, 'C'],
                    [12, 'D'],
                ],
                'White' => [
                    [2, 'C'],
                    [3, 'H'],
                    [4, 'S'],
                    [8, 'C'],
                    [13, 'H'],
                ]
            ]);
        });
    }
);
