<?php

namespace App\Controller\Admin\Area\DispatchArea;

use App\Entity\DispatchArea;
use App\Message\Command\Area\DispatchArea\DeleteDispatchArea;
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
class DispatchAreaDeleteController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/dispatch/{id}', name: 'app_admin_area_dispatch_delete', methods: ['POST'])]
    public function __invoke(Request $request, DispatchArea $dispatchArea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dispatchArea->getId(), $request->request->get('_token'))) {
            $command = new DeleteDispatchArea($dispatchArea->getId());

            try {
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.area_dispatch_deleted'));
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_dispatch_deletion_failed'));
            }
        }

        return $this->redirectToRoute('app_admin_area_dispatch_index', [], Response::HTTP_SEE_OTHER);
    }
}
