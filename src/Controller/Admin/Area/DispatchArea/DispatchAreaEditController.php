<?php

namespace App\Controller\Admin\Area\DispatchArea;

use App\Entity\DispatchArea;
use App\Form\Areas\DispatchAreaType;
use App\Message\Command\Area\DispatchArea\UpdateDispatchArea;
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
class DispatchAreaEditController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/dispatch/{id}/edit', name: 'app_admin_area_dispatch_edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, DispatchArea $dispatchArea, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DispatchAreaType::class, $dispatchArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new UpdateDispatchArea(
                $dispatchArea->getId(),
                $dispatchArea->getName(),
                $dispatchArea->getState(),
                $dispatchArea->getSupplyArea(),
            );

            try {
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.area_dispatch_updated'));

                return $this->redirectToRoute('app_admin_area_dispatch_show', ['id' => $dispatchArea->getId()], Response::HTTP_SEE_OTHER);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_dispatch_update_failed'));
            }

            return $this->redirectToRoute('app_admin_area_dispatch_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/dispatch_area/edit.html.twig', [
            'dispatch_area' => $dispatchArea,
            'form' => $form,
        ]);
    }
}
