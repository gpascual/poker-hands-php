<?php

namespace PokerHands;

class WinnerRegistry
{
    private ?Hand $winningHand = null;
    private HandRank $winningRank = HandRank::Card;
    private array $winningFigures = [];

    public function registerWinner(Hand $winningHand, HandRank $winningRank, array $winningFigures): void
    {
        $this->winningHand = $winningHand;
        $this->winningRank = $winningRank;
        $this->winningFigures = $winningFigures;
    }

    public function getWinningHand(): ?Hand
    {
        return $this->winningHand;
    }

    public function getWinningRank(): HandRank
    {
        return $this->winningRank;
    }

    public function getWinningFigures(): array
    {
        return $this->winningFigures;
    }

    public function captureHandComparisonResult(
        HandRank $handRank,
        int $position,
        Hand $higherHand,
        Hand $lowerHand,
        bool $handsAreTie
    ): void {
        if ($handsAreTie) {
            return;
        }

        if (
            in_array(
                $handRank,
                [HandRank::TwoPairs, HandRank::Straight, HandRank::FullHouse, HandRank::StraightFlush],
                true
            )
        ) {
            $this->registerWinner($higherHand, $handRank, $higherHand->rankFigures($handRank));
            return;
        }

        $this->registerWinner($higherHand, $handRank, [$higherHand->figureAt($handRank, $position)]);
    }
}
