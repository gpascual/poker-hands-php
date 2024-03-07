<?php

use PokerHands\Card;
use PokerHands\Figure;
use PokerHands\Hand;
use PokerHands\HandParser;
use PokerHands\Suit;

describe(
    'HandParsing',
    function () {
        it(
            'should return a proper representation of input hands',
            function () {
                $handParser = new HandParser();

                $result = $handParser->parseHandsInput(
                    'Black: 2H 3D 5S 9C KD  White: 2C 3H 4S 8C AH'
                );

                expect($result)->toEqual([
                    'Black' => new Hand(
                        new Card(Figure::from(2), Suit::from('H')),
                        new Card(Figure::from(3), Suit::from('D')),
                        new Card(Figure::from(5), Suit::from('S')),
                        new Card(Figure::from(9), Suit::from('C')),
                        new Card(Figure::from(12), Suit::from('D')),
                    ),
                    'White' => new Hand(
                        new Card(Figure::from(2), Suit::from('C')),
                        new Card(Figure::from(3), Suit::from('H')),
                        new Card(Figure::from(4), Suit::from('S')),
                        new Card(Figure::from(8), Suit::from('C')),
                        new Card(Figure::from(13), Suit::from('H')),
                    )
                ]);
            }
        );
    }
);
