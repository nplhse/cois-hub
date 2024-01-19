<?php

namespace App\Controller\Admin\Hospital;

use App\Entity\Hospital;
use App\Message\Command\Hospital\DeleteHospital;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted('ROLE_ADMIN')]
class HospitalDeleteController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/admin/hospital/{id}', name: 'app_admin_hospital_delete', methods: ['POST'])]
    public function __invoke(Request $request, Hospital $hospital): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hospital->getId(), $request->request->get('_token'))) {
            $command = new DeleteHospital($hospital->getId());

            try {
                $this->messageBus->dispatch($command);

                $this->addFlash('success', $this->translator->trans('flash.hospital_deleted'));
            } catch (HandlerFailedException) {
                $this->addFlash('danger', $this->translator->trans('flash.hospital_deletion_failed'));
            }
        }

        return $this->redirectToRoute('app_admin_hospital_index', [], Response::HTTP_SEE_OTHER);
    }
}
