<?php

namespace App\Controller;

use App\Dto\StayDataTransferObject;
use App\Entity\Country;
use App\Form\CalculatorFormType;
use App\Repository\CountryRepository;
use App\Service\CalculatorService\CalculatorService;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    public function __construct(
        private CalculatorService $calculatorService,
        private CountryRepository $countryRepository
    )
    {
    }

    #[Route(path: '/', name: 'index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CalculatorFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $nationality = $form->get('nationality')->getData();
            $entry = $form->get('entry')->getData();
            $exit = $form->get('exit')->getData();
            $stay = $this->calculatorService->calculate($entry, $exit);
            $country = $this->countryRepository->findOneBy([
                'code' => $nationality
            ]);

            if (!$country instanceof Country) {
                $form->get('nationality')->addError(new FormError('unable to find country'));
            }

            if ($stay->getEntry()->isAfter(Carbon::now())) {
                $form->get('entry')->addError(new FormError('Entry can not be after today'));
            }

            if ($stay->getExit()->isBefore($stay->getEntry())) {
                $form->get('exit')->addError(new FormError('Exit can not be before entry'));
            }

            if ($stay->getIsDurationOverNinetyDays()) {
                $this->addFlash('error', 'over-ninety-day-stay');
            }

            return $this->renderForm('app/index.html.twig', [
                'form' => $form,
                'stay' => $stay,
                'country' => $country
            ]);
        }

        return $this->renderForm('app/index.html.twig', [
            'form' => $form,
            'stay' => null,
            'country' => null
        ]);
    }

    #[Route(path: '/rules/stay-rules', name: 'shengen_stay_rules')]
    public function stayDurationRules(): Response
    {
        return $this->render('/rules/stay-duration-modal.html.twig');
    }

    #[Route(path: '/rules/overstay-consequences', name: 'shengean_visa_overstay_consequences')]
    public function shengeanVisaOverstayConsequences(): Response
    {
        return $this->render('/rules/shengean-visa-overstay-consequences-modal.html.twig');
    }

}