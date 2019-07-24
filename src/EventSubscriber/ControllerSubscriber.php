<?php
namespace App\EventSubscriber;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Repository\UserRepository;

class ControllerSubscriber implements EventSubscriberInterface
{
    private $security;
    private $userRepo;

    public function __construct(Security $security, UserRepository $userRepo)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
        $this->userRepo = $userRepo;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::CONTROLLER => [
                ['processHomepage', 10]
            ],
        ];
    }

    public function processHomepage(ControllerEvent $event)
    {
        // get controller and route name
        $controller = $event->getController();

        // get current user on the page
        $user = $this->security->getUser();

        // check if the user is connected, currently on the homepage and check his last connexion
        if ($user && $controller[1] == 'home') {
            $currentUser = $this->userRepo->find($user);
            // entity LastConnection related to the current user
            $userConnection = $currentUser->getLastConnection();
            dump($userConnection);
            $lastConnection = $userConnection->getLastConnection();
            dump($lastConnection);
            // $lastDay = date_format($lastConnection, 'd-m-Y');
        }
    }
}