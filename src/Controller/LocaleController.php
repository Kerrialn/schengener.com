<?php

namespace App\Controller;

use App\Form\LocaleFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{

    #[Route(path: '/locale-switch', name: 'locale_switch')]
    public function switchLocale(Request $request): Response
    {
        $form = $this->createForm(LocaleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locale = $form->get('language')->getData();
            return $this->redirectToRoute('index', ['_locale' => $locale]);
        }

        return $this->render('locale/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}