<?php

namespace App\Controller\Admin\Area;

use App\Command\Area\CreateSupplyAreaCommand;
use App\Entity\SupplyArea;
use App\Form\SupplyAreaType;
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
class SupplyAreaNewController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/area/supply/new', name: 'app_admin_area_supply_new', methods: ['GET', 'POST'], priority: 100)]
    public function __invoke(Request $request, EntityManagerInterface $entityManager): Response
    {
        $supplyArea = new SupplyArea();
        $form = $this->createForm(SupplyAreaType::class, $supplyArea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateSupplyAreaCommand(
                $supplyArea->getName(),
            );

            try {
                $envelope = $this->messageBus->dispatch($command);
                $handledStamp = $envelope->last(HandledStamp::class);

                /** @var SupplyArea $supplyArea */
                $supplyArea = $handledStamp->getResult();

                $this->addFlash('success', $this->translator->trans('flash.area_supply_created'));

                return $this->redirectToRoute('app_admin_area_supply_show', ['id' => $supplyArea->getId()], Response::HTTP_SEE_OTHER);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.area_supply_creation_failed'));
            }

            return $this->redirectToRoute('app_admin_area_supply_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/area/supply_area/new.html.twig', [
            'supply_area' => $supplyArea,
            'form' => $form,
        ]);
    }
}
