<?php

namespace App\Service;

use App\Entity\Card;

class DateGenerator
{
    CONST RESET = 0;
    CONST HARD = 1.2;
    CONST MEDIUM = 2.4;
    CONST EASY = 4;

    public function getDate(Card $card, $answer)
    {
        $step = $card->getStep();

        // connect the value of the answer with the value of the related CONST
        $answerConst = strtoupper($answer);
        $const = constant('self::' . $answerConst);

        $date = $const * $step;
        
        return round($date); 
    }
}