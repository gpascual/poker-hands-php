<?php

namespace PokerHands;

class Card
{
    public function __construct(public readonly Figure $figure, public readonly Suit $suit)
    {
    }
}
