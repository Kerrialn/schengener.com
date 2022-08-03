<?php

namespace App\Controller;

use App\Form\LocaleFormType;
use App\Service\Referer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{


    public function __construct(
    )
    {
    }

    #[Route(path: '/locale-switch', name: 'locale_switch')]
    public function switchLocale(Request $request): Response
    {

        $form = $this->createForm(LocaleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locale = $form->get('language')->getData();
            return $this->redirectToRoute('index', array_merge($request->query->all()) );
        }


        return $this->render('locale/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}