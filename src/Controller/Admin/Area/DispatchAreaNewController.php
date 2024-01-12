<?php

namespace App\Controller\Admin\Area;

use App\Command\Area\CreateDispatchAreaCommand;
use App\Entity\DispatchArea;
use App\Form\DispatchAreaType;
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
class DispatchAreaNewController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/dispatch/new', name: 'app_admin_area_dispatch_new', methods: ['GET', 'POST'], priority: 100)]
    public function __invoke(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dispatchArea = new DispatchArea();
        $form = $this->createForm(DispatchAreaType::class, $dispatchArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateDispatchAreaCommand(
                $dispatchArea->getName(),
                $dispatchArea->getState(),
                $dispatchArea->getSupplyArea(),
            );

            try {
                $envelope = $this->messageBus->dispatch($command);
                $handledStamp = $envelope->last(HandledStamp::class);

                /** @var DispatchArea $dispatchArea */
                $dispatchArea = $handledStamp->getResult();

                $this->addFlash('success', $this->translator->trans('flash.area_dispatch_created'));

                return $this->redirectToRoute('app_admin_area_dispatch_show', ['id' => $dispatchArea->getId()], Response::HTTP_SEE_OTHER);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_dispatch_creation_failed'));
            }

            return $this->redirectToRoute('app_admin_area_dispatch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/dispatch_area/new.html.twig', [
            'dispatch_area' => $dispatchArea,
            'form' => $form,
        ]);
    }
}
