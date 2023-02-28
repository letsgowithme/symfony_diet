<?php

namespace App\Controller;

use App\Entity\Allergen;
use App\Form\AllergenType;
use App\Repository\AllergenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class AllergenController extends AbstractController
{
    /**
     * This function displays all allergens
     *
     * @param AllergenRepository $repository
     * @return Response
     */
    #[Route('/allergen', name: 'allergen.index', methods: ['GET'])]
    public function index(AllergenRepository $repository): Response
    {
        $allergens = $repository->findBy(['user' => $this->getUser()]);
        return $this->render('pages/allergen/index.html.twig', [
            'allergens' =>  $allergens
        ]);
    }

    /**
     * This function creates an allergen
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/allergen/creation', 'allergen.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager

    ) : Response
    {
        $allergen = new Allergen();
        $form = $this->createForm(AllergenType::class, $allergen);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $allergen = $form->getData();
            $allergen->setUser($this->getUser());

            $manager->persist($allergen);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre allergène a bien été créé'
            );

            return $this->redirectToRoute('allergen.index');
        }
return $this->render('pages/allergen/new.html.twig', [
    'form' => $form->createView()
]);
    }

    /**
     * This function edits the allergen
     * @param Request $request
     * @param Allergen $allergen
     * @return Response
     */



     #[Route('allergen/edition/{id}', 'allergen.edit', methods: ['GET', 'POST'])]
     public function edit(
 
        Allergen $allergen,
         EntityManagerInterface $manager,
         Request $request
     ) : Response {
 
         $form = $this->createForm(AllergenType::class, $allergen);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $allergen = $form->getData();
 
             $manager->persist($allergen);
             $manager->flush();
 
             $this->addFlash(
                 'success',
                 'Votre allergène a été modifié avec succès !'
             );
 
             return $this->redirectToRoute('allergen.index');
         }
 
 
         return $this->render('pages/allergen/edit.html.twig', [
             'form' => $form->createView()
         ]);
     }
    /**
     * This controller allows us to delete a diet
     *
     * @param EntityManagerInterface $manager
     * @param Allergen $allergen
     * @return Response
     */
    #[Route('/allergen/suppression/{id}', 'allergen.delete', methods: ['GET'])]

    public function delete(
        EntityManagerInterface $manager,
        Allergen $allergen
    ): Response {
       
        $manager->remove($allergen);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre allergène a été supprimé avec succès !'
        );

        return $this->redirectToRoute('allergen.index');
    }



}