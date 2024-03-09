<?php

namespace PokerHands;

use PokerHands\Rules\RulingsFactory;
use PokerHands\UserInterface\HandParser;
use PokerHands\UserInterface\WinnerResponse;

use function Lambdish\Phunctional\sort;

class PokerHands
{
    public function whoWins(string $line): string
    {
        $winnerRegistry = new WinnerRegistry();
        $rulings = RulingsFactory::createDefault($winnerRegistry);

        sort(
            $rulings->handRanksComparator(),
            (new HandParser($rulings))->parseHandsInput($line)
        );

        return new WinnerResponse($winnerRegistry);
    }
}
