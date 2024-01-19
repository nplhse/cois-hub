<?php

namespace App\Controller\Admin\Hospital;

use App\Entity\Hospital;
use App\Form\Hospital\HospitalType;
use App\Message\Command\Hospital\UpdateHospital;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_ADMIN')]
class HospitalEditController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/hospital/{id}/edit', name: 'app_admin_hospital_edit', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Hospital $hospital): Response
    {
        $form = $this->createForm(HospitalType::class, $hospital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new UpdateHospital(
                $hospital->getId(),
                $hospital->getName(),
                $hospital->getOwner(),
                $hospital->getBeds(),
                $hospital->getLocation(),
                $hospital->getTier(),
                $hospital->getAddress(),
                $hospital->getState(),
                $hospital->getDispatchArea(),
                $hospital->getSupplyArea()
            );

            try {
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.hospital_updated'));

                return $this->redirectToRoute('app_admin_hospital_show', ['id' => $hospital->getId()], Response::HTTP_SEE_OTHER);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.hospital_update_failed'));
            }

            return $this->redirectToRoute('app_admin_hospital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/hospital/edit.html.twig', [
            'hospital' => $hospital,
            'form' => $form,
        ]);
    }
}
