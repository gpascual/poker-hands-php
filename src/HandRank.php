<?php

namespace PokerHands;

enum HandRank
{
    case Straight;
    case ThreeOfAKind;
    case TwoPairs;
    case Pair;
    case Card;
    case Flush;
    case FullHouse;
}
