<?php

namespace PokerHands\UserInterface;

use PokerHands\Card;
use PokerHands\Figure;
use PokerHands\Hand;
use PokerHands\Rules\Rulings;
use PokerHands\Suit;

use function Lambdish\Phunctional\map;

class HandParser
{
    private Rulings $rulings;

    public function __construct(Rulings $rulings)
    {
        $this->rulings = $rulings;
    }

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
            $hands[] = $this->rulings->createHand(
                $player,
                map(
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
