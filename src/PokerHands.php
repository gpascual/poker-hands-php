<?php

namespace PokerHands;

use function Lambdish\Phunctional\map;

class PokerHands
{
    public function whoWins(string $line): string
    {
        $handParser = new HandParser();
        $hands = $handParser->parseHandsInput($line);

        $position = 0;
        $cardComparison = $this->compareCardsAt($hands, $position);

        if (!$cardComparison) {
            $position = 1;
            $cardComparison = $this->compareCardsAt($hands, $position);
        }

        $players = array_keys($hands);
        return match (true) {
            0 > $cardComparison => $this->composeWinningPlayerResponse($players[0], $hands[$players[0]]->cardAt($position)),
            0 < $cardComparison => $this->composeWinningPlayerResponse($players[1], $hands[$players[1]]->cardAt($position)),
            default => ''
        };
    }

    private function cardFigure(Figure $figure): string
    {
        return match ($figure) {
            Figure::Jack => 'Jack',
            Figure::Queen => 'Queen',
            Figure::King => 'King',
            Figure::Ace => 'Ace',
            default => $figure->value
        };
    }

    public function composeWinningPlayerResponse(string $player, Card $highestCard): string
    {
        return "$player wins. - with high card: {$this->cardFigure($highestCard->figure)}";
    }

    /**
     * @param Hand[] $hands
     * @param int $position
     * @return int
     */
    public function compareCardsAt(array $hands, int $position): int
    {
        $cardsAt = array_values(map(
            fn(Hand $hand) => $hand->cardAt($position),
            $hands
        ));

        return $cardsAt[1]->figure->value - $cardsAt[0]->figure->value;
    }
}
