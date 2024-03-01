<?php

namespace PokerHands;

use function Lambdish\Phunctional\map;

class HandParser
{
    public function parseHandsInput(string $string)
    {
        $separatedHandInputs = explode('  ', $string);

        foreach ($separatedHandInputs as $handInput) {
            [$player, $cardsInput] = explode(': ', $handInput);
            $hands[$player] = map(
                fn(string $cardString) => ([
                    match ($cardString[0]) {
                        'J' => 10,
                        'Q' => 11,
                        'K' => 12,
                        'A' => 13,
                        default => (int) $cardString[0]
                    },
                    $cardString[1]
                ]),
                explode(' ', $cardsInput)
            );
        }

        return $hands;
    }
}