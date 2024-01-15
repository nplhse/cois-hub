<?php

namespace App\Controller\Admin\Area\State;

use App\Entity\State;
use App\Form\Areas\StateType;
use App\Message\Command\Area\State\CreateState;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_ADMIN')]
class StateNewController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/state/new', name: 'app_admin_area_state_new', methods: ['GET', 'POST'], priority: 100)]
    public function __invoke(Request $request, EntityManagerInterface $entityManager): Response
    {
        $state = new State();
        $form = $this->createForm(StateType::class, $state);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateState($state->getName());

            try {
                $envelope = $this->messageBus->dispatch($command);
                $handledStamp = $envelope->last(HandledStamp::class);

                /** @var State $state */
                $state = $handledStamp->getResult();

                $this->addFlash('success', $this->translator->trans('flash.area_state_created'));

                return $this->redirectToRoute('app_admin_area_state_show', ['id' => $state->getId()], Response::HTTP_SEE_OTHER);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_state_creation_failed'));
            }

            return $this->redirectToRoute('app_admin_area_state_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/state/new.html.twig', [
            'state' => $state,
            'form' => $form,
        ]);
    }
}
