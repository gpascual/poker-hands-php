<?php

describe(
    'PokerHands',
    function () {
        it(
            'should tell which hand wins',
            function () {
                $input = fopen(__DIR__ . '/sampleInput.txt', 'rb');

                $result = [];
                while ($line = fgets($input)) {
                    $result[] = $this->pokerHands->whoWins($line);
                }

                expect(implode("\n", $result))->toBe(file_get_contents(__DIR__ . '/sampleOutput.txt'));
            }
        );
    }
);
