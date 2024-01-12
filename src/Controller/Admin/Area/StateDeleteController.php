<?php

namespace App\Controller\Admin\Area;

use App\Command\Area\DeleteStateCommand;
use App\Entity\State;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_ADMIN')]
class StateDeleteController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/state/{id}', name: 'app_admin_area_state_delete', methods: ['POST'])]
    public function __invoke(Request $request, State $state): Response
    {
        if ($this->isCsrfTokenValid('delete'.$state->getId(), $request->request->get('_token'))) {
            $command = new DeleteStateCommand($state->getId());

            try {
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.area_state_deleted'));
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_state_deletion_failed'));
            }
        }

        return $this->redirectToRoute('app_admin_area_state_index', [], Response::HTTP_SEE_OTHER);
    }
}
