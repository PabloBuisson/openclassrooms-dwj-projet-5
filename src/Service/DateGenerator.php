<?php

namespace App\Service;

use App\Entity\Card;

class DateGenerator
{
    const RESET = 0;
    const HARD = 1.2;
    const MEDIUM = 2.4;
    const EASY = 4;

    public function getDate(Card $card, $answer)
    {
        $step = $card->getStep();

        // connect the value of the answer with the value of the related CONST
        $answerConst = strtoupper($answer);
        $const = constant('self::' . $answerConst);

        $date = $const * $step;
        
        // return a round date, i.e. a number of days
        return round($date); 
    }
}