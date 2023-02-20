<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class UserController extends AbstractController
{
    /**
     * This function displays all users
     *
     * @param UserRepository $repository
     * @return Response
     */
    #[Route('/users', name: 'user.index', methods: ['GET'])]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->render('pages/user/index.html.twig', [
            'users' =>  $users
        ]);
    }

    
     /**
    * This function creates a user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/user/new', 'user.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager

    ) : Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre user a bien été créé'
            );

            return $this->redirectToRoute('recipe.index');
        }
return $this->render('pages/user/new.html.twig', [
    'form' => $form->createView()
]);
    }

    /**
     * This function edits the user
     * @param Request $request
     * @param User $user
     * @return Response
     */



     #[Route('user/edition/{id}', 'user.edit', methods: ['GET', 'POST'])]
     public function edit(
 
        User $user,
         EntityManagerInterface $manager,
         Request $request
     ) : Response {
 
         $form = $this->createForm(UserType::class, $user);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $user = $form->getData();
 
             $manager->persist($user);
             $manager->flush();
 
             $this->addFlash(
                 'success',
                 'Votre user a été modifié avec succès !'
             );
 
             return $this->redirectToRoute('user.index');
         }
 
 
         return $this->render('pages/user/edit.html.twig', [
             'form' => $form->createView()
         ]);
     }
    /**
     * This controller allows us to delete a user
     *
     * @param EntityManagerInterface $manager
     * @param User $user
     * @return Response
     */
    #[Route('/user/suppression/{id}', 'user.delete', methods: ['GET'])]

    public function delete(
        EntityManagerInterface $manager,
        User $user
    ): Response {
       
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre user a été supprimé avec succès !'
        );

        return $this->redirectToRoute('user.index');
    }



}
