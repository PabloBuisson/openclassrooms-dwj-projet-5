<?php

namespace App\Controller;

use App\Entity\Card;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use App\Repository\DailyCountRepository;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CardRepository $repoCard, UserRepository $repoUser, DailyCountRepository $repoCount)
    {
        $cards = null;
        $count = null;
        $due = null;

        if ($this->getUser()) // if the user is connected
        {
            // current user id
            $user = $this->getUser()->getId();

            // object of the current user
            $userParam = $repoUser->find($user);

            // limit of daily cards, defined by user
            $userLimit = $userParam->getDailyLimit();

            // cards due = (limit of daily cards - amount of cards already done today)
            $userCount = $repoCount->findOneBy([
                'user' => $user
            ]);
            $count = $userCount->getCount();
            $limit = ($userLimit - $count);

            // dd($limit);

            $cards = $repoCard->findDailyCards(new \DateTime(), $limit, $user);

            $due = count($cards);
        }

        return $this->render('front/home.html.twig', [
            'cards' => $cards,
            'isFirst' => true,
            'count' => $count,
            'due' => $due
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
