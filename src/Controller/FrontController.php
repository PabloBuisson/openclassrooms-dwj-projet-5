<?php

namespace App\Controller;

use App\Entity\Card;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CardRepository;
use App\Repository\UserRepository;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CardRepository $repoCard, UserRepository $repoUser)
    {
        $cards = null;

        if ($this->getUser()) // if the user is connected
        {
            // current user id
            $user = $this->getUser()->getId();

            // object of the current user
            $userCard = $repoUser->find($user);

            // limit of daily cards, defined by user
            $limit = $userCard->getDailyLimit();

            // limit of daily cards - amount of cards already done
         /* $revision = $repoRevision->find($user);
            $done = $revision->count();
            $number = ($limit - $done); */

            $cards = $repoCard->findDailyCards(new \DateTime(), $limit, $user);
        }

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
