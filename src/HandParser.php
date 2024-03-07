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
                    fn(string $cardString) => new Card(
                        match ($cardString[0]) {
                            'J' => Figure::Jack,
                            'Q' => Figure::Queen,
                            'K' => Figure::King,
                            'A' => Figure::Ace,
                            default => Figure::from($cardString[0])
                        },
                        Suit::from($cardString[1])
                    ),
                    explode(' ', $cardsInput)
                )
            );
        }

        return $hands;
    }
}
