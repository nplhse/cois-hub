<?php

namespace App\Controller\Settings;

use App\DataTransferObjects\AccountSettingsTypeDTO;
use App\Entity\User;
use App\Form\AccountSettingsType;
use App\Message\Command\User\ToogleUserIsPublic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_USER')]
class AccountSettingsController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/settings', name: 'app_settings_account')]
    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $accountSettingsTypeDto = new AccountSettingsTypeDTO();
        $accountSettingsTypeDto->setIsPublic($user->isPublic());

        $form = $this->createForm(AccountSettingsType::class, $accountSettingsTypeDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($accountSettingsTypeDto->getIsPublic() !== $user->isPublic()) {
                $command = new ToogleUserIsPublic($user->getId(), $accountSettingsTypeDto->getIsPublic());
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.settings_updated'));
            }
        }

        return $this->render('settings/account.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
