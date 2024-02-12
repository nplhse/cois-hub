<?php

namespace App\Controller\Data\Hospital;

use App\Entity\Hospital;
use App\Form\Hospital\HospitalType;
use App\Message\Command\Hospital\CreateHospital;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_PARTICIPANT')]
class HospitalNewController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/data/hospital/new', name: 'app_data_hospital_new', methods: ['GET', 'POST'], priority: 100)]
    public function __invoke(Request $request): Response
    {
        $hospital = new Hospital();
        $form = $this->createForm(HospitalType::class, $hospital);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command = new CreateHospital(
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
                $envelope = $this->messageBus->dispatch($command);
                $handledStamp = $envelope->last(HandledStamp::class);

                $hospitalId = $handledStamp->getResult();

                $this->addFlash('success', $this->translator->trans('flash.hospital_created'));

                return $this->redirectToRoute('app_data_hospital_show', ['id' => $hospitalId], Response::HTTP_SEE_OTHER);
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.hospital_creation_failed'));
            }

            return $this->redirectToRoute('app_data_hospital_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('data/hospital/new.html.twig', [
            'hospital' => $hospital,
            'form' => $form,
        ]);
    }
}
