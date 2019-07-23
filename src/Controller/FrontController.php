<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepository;
use App\Repository\UserRepository;
use App\Repository\DailyCountRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\DateGenerator;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Card $card = null, CardRepository $repoCard, UserRepository $repoUser, DailyCountRepository $repoCount, Request $request, EntityManagerInterface $manager, DateGenerator $dateGenerator)
    {
        // dull data for anonymous user
        $cards = null;
        $count = null;
        $due = null;

        $form = $this->createForm(CardType::class, $card);

        // if the user is connected
        if ($this->getUser()) {
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

            $cards = $repoCard->findDailyCards(new \DateTime(), $limit, $user);
            $due = count($cards); // number of cards due today

            // the form and how to handle it
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // number of cards reviewed +1
                $userCount->setCount($count + 1);

                // get card posted
                $card = $repoCard->find($request->get('card-id'));

                // set the day of future review
                $date = new \DateTime();
                $answer = $form->getClickedButton()->getName();
                $newDate = $dateGenerator->getDate($card, $answer);
                $card->setDatePublication($date->modify('+' . $newDate . 'day'));

                $manager->persist($card);
                $manager->flush();

                return $this->redirectToRoute('home');
            }   
        }

        return $this->render('front/home.html.twig', [
            'cards' => $cards,
            'isFirst' => true,
            'count' => $count,
            'due' => $due,
            'formCard' => $form->createView()
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
