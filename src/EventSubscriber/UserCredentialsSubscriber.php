<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserCredentialsSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    /** @var array|string[] */
    private array $excludedRoutes = [
        'app_logout',
        'app_verify_email',
        'app_reset_credentials',
    ];

    public function __construct(
        private readonly TokenStorageInterface $security,
        private readonly RouterInterface $router
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public static function getSubscribedEvents(): array
    {
        return [\Symfony\Component\HttpKernel\KernelEvents::REQUEST => 'onKernelRequest'];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $currentRoute = $event->getRequest()->attributes->get('_route');
        $token = $this->security->getToken();

        if (false === $event->isMainRequest()) {
            return;
        }

        if ($event->getRequest()->isXmlHttpRequest()) {
            return;
        }

        if (\in_array($currentRoute, $this->excludedRoutes, true)) {
            return;
        }

        if (null === $token) {
            return;
        }

        $user = $token->getUser();

        if ($user instanceof User && $user->hasCredentialsExpired()) {
            $response = new RedirectResponse($this->router->generate('app_reset_credentials'));
            $event->setResponse($response);
        }
    }
}
