<?php

namespace App\Controller\Admin\System\CookieConsent;

use App\Pagination\Paginator;
use App\Repository\CookieConsentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class ListCookieConsentController extends AbstractController
{
    public function __construct(
        private readonly CookieConsentRepository $cookieConsentRepository
    ) {
    }

    #[Route('/admin/system/cookie_consent', name: 'app_admin_system_cookie_consent')]
    public function index(
        #[MapQueryParameter]
        int $page = 1
    ): Response {
        /** @var Paginator $cookieConsents */
        $cookieConsents = $this->cookieConsentRepository->getPaginatedResults($page);

        return $this->render('admin/system/cookie_consent/list.html.twig', [
            'cookieConsents' => $cookieConsents,
        ]);
    }
}
