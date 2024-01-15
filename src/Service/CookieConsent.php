<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\CookieConsent as CookieConsentEntity;
use App\Enum\CookieConsentOptions;
use App\Form\CookieConsentType;
use App\Repository\CookieConsentRepository;
use Random\RandomException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class CookieConsent
{
    final public const COOKIE_CONSENT = 'COOKIE_CONSENT';

    public function __construct(
        private readonly CookieConsentRepository $repository,
        private readonly FormFactoryInterface $formFactory,
        private readonly Environment $twig,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function render(): string
    {
        $form = $this->createForm();

        return $this->twig->render('includes/cookie_consent.html.twig', [
            'consentForm' => $form->createView(),
        ]);
    }

    public function hasCookieConsent(Request $request): bool
    {
        if (!$request->cookies->has(self::COOKIE_CONSENT)) {
            return false;
        }

        $lookupKey = urldecode($request->cookies->get(self::COOKIE_CONSENT));
        $cookie = $this->repository->findOneBy(['lookupKey' => $lookupKey]);

        return null !== $cookie;
    }

    public function createForm(): \Symfony\Component\Form\FormInterface
    {
        return $this->formFactory->create(CookieConsentType::class, null, [
            'action' => $this->urlGenerator->generate('app_cookie_consent'),
        ]);
    }

    /**
     * @param array<array-key, string|mixed> $formData
     *
     * @throws RandomException
     */
    public function handleFormSubmit(array $formData, Request $request, Response $response): void
    {
        $lookupKey = bin2hex(random_bytes(16));

        if (in_array(CookieConsentOptions::ESSENTIAL->value, $formData['categories'], true)) {
            $this->saveCookie(self::COOKIE_CONSENT, $lookupKey, $response);
            $this->saveConsent($lookupKey, $formData['categories'], $this->anonymizeIp($request->getClientIp()));
        }
    }

    public function saveCookie(string $name, string $value, Response $response): void
    {
        $today = new \DateTimeImmutable();
        $expirationDate = $today->add(new \DateInterval('P1Y'));

        $response->headers->setCookie(
            Cookie::create($name, $value)
                ->withExpires($expirationDate)
        );
    }

    /**
     * @param array<array-key, string> $categories
     */
    public function saveConsent(string $lookupKey, array $categories, string $ipAddress): void
    {
        $consent = new CookieConsentEntity();
        $consent->setLookupKey($lookupKey);
        $consent->setCategories($categories);
        $consent->setIpAddress($ipAddress);
        $consent->setCreatedAt(new \DateTimeImmutable('now'));

        $this->repository->add($consent);
    }

    protected function anonymizeIp(?string $ip): string
    {
        if (null === $ip) {
            return 'Unknown';
        }

        return IpUtils::anonymize($ip);
    }
}
