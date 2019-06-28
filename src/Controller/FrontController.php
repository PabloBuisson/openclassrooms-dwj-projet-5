<?php

namespace App\Controller;

use App\Entity\Card;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CardRepository;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CardRepository $repo)
    {
        $limit = 5; // limit of daily cards, defined by user
        // $UserLimit = $repoU->find($id user)
        // $limit = $UserLimit->getLimit()

        $cards = $repo->findDailyCards(new \DateTime(), $limit);

        return $this->render('front/home.html.twig', [
            'cards' => $cards,
            'isFirst' => true
        ]);
    }

    /**
     * @Route("/presentation", name="presentation")
     */
    public function presentation()
    {
        return $this->render('front/presentation.html.twig', [
            'variable' => 'variable',
        ]);
    }
}
