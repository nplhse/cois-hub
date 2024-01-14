<?php

namespace App\Controller\Admin\Area\SupplyArea;

use App\Command\Area\DeleteSupplyAreaCommand;
use App\Entity\SupplyArea;
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
class SupplyAreaDeleteController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/supply/{id}', name: 'app_admin_area_supply_delete', methods: ['POST'])]
    public function __invoke(Request $request, SupplyArea $supplyArea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplyArea->getId(), $request->request->get('_token'))) {
            $command = new DeleteSupplyAreaCommand($supplyArea->getId());

            try {
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.area_supply_deletion_success'));
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_supply_deletion_failed'));
            }
        }

        return $this->redirectToRoute('app_admin_area_supply_index', [], Response::HTTP_SEE_OTHER);
    }
}
