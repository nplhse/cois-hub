<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Service\CookieConsent;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CookieConsentExtension extends AbstractExtension
{
    public function __construct(
        private readonly CookieConsent $cookieConsentService
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'cookie_consent_render',
                $this->cookieConsentService->render(...),
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'has_cookie_consent',
                $this->cookieConsentService->hasCookieConsent(...),
            ),
        ];
    }
}
