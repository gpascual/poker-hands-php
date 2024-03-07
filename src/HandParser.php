<?php

namespace PokerHands;

use function Lambdish\Phunctional\map;

class HandParser
{
    /**
     * @param string $input
     * @return Hand[]
     */
    public function parseHandsInput(string $input): array
    {
        $separatedHandInputs = explode('  ', $input);

        $hands = [];
        foreach ($separatedHandInputs as $handInput) {
            [$player, $cardsInput] = explode(': ', $handInput);
            $hands[$player] = new Hand(
                ...map(
                    fn(string $cardString) => ([
                        match ($cardString[0]) {
                            'J' => 10,
                            'Q' => 11,
                            'K' => 12,
                            'A' => 13,
                            default => (int)$cardString[0]
                        },
                        $cardString[1]
                    ]),
                    explode(' ', $cardsInput)
                )
            );
        }

        return $hands;
    }
}
