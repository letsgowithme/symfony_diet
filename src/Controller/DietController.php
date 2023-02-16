<?php

namespace App\Controller;

use App\Entity\Diet;
use App\Form\DietType;
use App\Repository\DietRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class DietController extends AbstractController
{
    /**
     * This function displays all diets
     *
     * @param DietRepository $repository
     * @return Response
     */
    #[Route('/diet', name: 'diet.index', methods: ['GET'])]
    public function index(DietRepository $repository): Response
    {
        // $diets = $repository->findBy(['user' => $this->getUser()]);
        $diets = $repository->findAll();
        return $this->render('pages/diet/index.html.twig', [
            'diets' =>  $diets
        ]);
    }

    /**
     * This function creates a diet
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/diet/nouveau', 'diet.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager

    ) : Response
    {
        $diet = new Diet();
        $form = $this->createForm(DietType::class, $diet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $diet = $form->getData();
            $diet->setUser($this->getUser());

            $manager->persist($diet);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre régime a bien été créé'
            );

            return $this->redirectToRoute('diet.index');
        }
return $this->render('pages/diet/new.html.twig', [
    'form' => $form->createView()
]);
    }

    /**
     * This function edits the diet
     * @param Request $request
     * @param Diet $diet
     * @return Response
     */



     #[Route('diet/edition/{id}', 'diet.edit', methods: ['GET', 'POST'])]
     public function edit(
 
         Diet $diet,
         EntityManagerInterface $manager,
         Request $request
     ) : Response {
 
         $form = $this->createForm(DietType::class, $diet);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $diet = $form->getData();
 
             $manager->persist($diet);
             $manager->flush();
 
             $this->addFlash(
                 'success',
                 'Votre régime a été modifié avec succès !'
             );
 
             return $this->redirectToRoute('diet.index');
         }
 
 
         return $this->render('pages/diet/edit.html.twig', [
             'form' => $form->createView()
         ]);
     }
    /**
     * This controller allows us to delete a diet
     *
     * @param EntityManagerInterface $manager
     * @param Diet $diet
     * @return Response
     */
    #[Route('/diet/suppression/{id}', 'diet.delete', methods: ['GET'])]

    public function delete(
        EntityManagerInterface $manager,
        Diet $diet
    ): Response {
       
        $manager->remove($diet);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre régime a été supprimé avec succès !'
        );

        return $this->redirectToRoute('diet.index');
    }

  

}
