<?php

namespace PokerHands;

enum HandRank
{
    case FourOfAKind;
    case FullHouse;
    case Flush;
    case Straight;
    case ThreeOfAKind;
    case TwoPairs;
    case Pair;
    case Card;
}
