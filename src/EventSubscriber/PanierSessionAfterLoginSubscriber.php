<?php

namespace App\EventSubscriber;

use App\Entity\Panier;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class PanierSessionAfterLoginSubscriber implements EventSubscriberInterface
{
    public function __construct(private RequestStack $requestStack, private ManagerRegistry $doctrine)
    {
    }

    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        $session = $this->requestStack->getSession();
        $panier = $session->get('panier');
        $user = $event->getAuthenticationToken()->getUser();

        if ($panier) {
            $panierRepository = $this->doctrine->getManager()->getRepository(Panier::class);
            $panier = $panierRepository->find($panier);

            $panier->setUser($user);
            $this->doctrine->getManager()->flush();
        }
        if ($user->getPanier()->last()) {
            $panier = $user->getPanier()->last()->getId();
            $session->set('panier', $panier);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success' => 'onSecurityAuthenticationSuccess',
        ];
    }
}
