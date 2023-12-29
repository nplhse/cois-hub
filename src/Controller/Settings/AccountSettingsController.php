<?php

namespace App\Controller\Settings;

use App\Command\User\ToogleUserIsPublicCommand;
use App\DataTransferObjects\AccountSettingsTypeDTO;
use App\Entity\User;
use App\Form\AccountSettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class AccountSettingsController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/settings', name: 'app_settings_account')]
    public function index(Request $request): Response
    {
        $accountSettingsTypeDto = new AccountSettingsTypeDTO();
        $form = $this->createForm(AccountSettingsType::class, $accountSettingsTypeDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            if ($accountSettingsTypeDto->getIsPublic() !== $user->isPublic()) {
                $command = new ToogleUserIsPublicCommand($user->getId(), $accountSettingsTypeDto->getIsPublic());
                $this->messageBus->dispatch($command);
            }
        }

        return $this->render('settings/index.html.twig', [
            'settingsForm' => $form->createView(),
        ]);
    }
}
