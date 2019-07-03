<?php

namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends BaseAdminController
{
    // launched before the submission of the form that creates a new card
    public function createNewCardEntity()
    {
        $card = new Card();
        $today = new \DateTime();
        $card->setDateCreation(new \DateTime())
             ->setDatePublication($today->setTime (00, 00, 00));

        return $card;
    }

    // launched before the submission of the form that updates a new card
/*     public function updateCardEntity()
    {

    } */
}
