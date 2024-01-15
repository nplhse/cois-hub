<?php

namespace App\Controller\Admin\Area\SupplyArea;

use App\Entity\SupplyArea;
use App\Form\SupplyAreaType;
use App\Message\Command\Area\SupplyArea\UpdateSupplyArea;
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
class SupplyAreaEditController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/supply/{id}/edit', name: 'app_admin_area_supply_edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, SupplyArea $supplyArea, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupplyAreaType::class, $supplyArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new UpdateSupplyArea(
                $supplyArea->getId(),
                $supplyArea->getName(),
            );

            try {
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.area_supply_updated'));

                return $this->redirectToRoute('app_admin_area_supply_show', ['id' => $supplyArea->getId()], Response::HTTP_SEE_OTHER);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_supply_update_failed'));
            }

            return $this->redirectToRoute('app_admin_area_supply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/supply_area/edit.html.twig', [
            'supply_area' => $supplyArea,
            'form' => $form,
        ]);
    }
}
