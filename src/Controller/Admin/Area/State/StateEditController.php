<?php

namespace App\Controller\Admin\Area\State;

use App\Entity\State;
use App\Form\Areas\StateType;
use App\Message\Command\Area\State\UpdateState;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_ADMIN')]
class StateEditController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/state/{id}/edit', name: 'app_admin_area_state_edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, State $state, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new UpdateState(
                $state->getId(),
                $state->getName()
            );

            try {
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.area_state_updated'));

                return $this->redirectToRoute('app_admin_area_state_show', ['id' => $state->getId()], Response::HTTP_SEE_OTHER);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_state_creation_failed'));
            }

            return $this->redirectToRoute('app_admin_area_state_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/state/edit.html.twig', [
            'state' => $state,
            'form' => $form,
        ]);
    }
}
