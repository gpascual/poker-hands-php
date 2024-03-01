<?php

use PokerHands\PokerHands;

describe(
    'PokerHands',
    function () {
        beforeEach(function () {
            $this->pokerHands = new PokerHands();
        });

        it (
            'should tell which hand wins',
            function () {
                $input = fopen(__DIR__ . '/sampleInput.txt', 'rb');

                while ($line = fgets($input)) {
                    $result[] = $this->pokerHands->whoWins($line);
                }

                expect(implode("\n", $result))->toBe(file_get_contents(__DIR__ . '/sampleOutput.txt'));
            }
        );
    }
);
