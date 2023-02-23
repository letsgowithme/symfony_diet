<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
/**
     * This controller shows the page Policy Privacy.
     *
     * @return Response
     */
    #[Route('/mentions', name: 'footer.legal_notice', methods: ['GET'])]
    public function mentions(): Response
    {
    return $this->render('pages/footer/legal_notice.html.twig');
    }

    /**
     * This controller shows the page Policy Privacy.
     *
     * @return Response
     */
    #[Route('/privacy', name: 'footer.privacy_policy', methods: ['GET'])]
    public function politic(): Response
    {
    return $this->render('pages/footer/privacy_policy.html.twig');
    }
  }