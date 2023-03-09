<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
class UserController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'user.index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

      /**
    * This function creates a user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'user.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager        
        ): Response
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

            return $this->redirectToRoute('user.index');
        }
return $this->render('user/new.html.twig', [
    'form' => $form->createView()
]);
    }
 /**
     * This function shows the user
     * @param User $user
     * @return Response
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'user.show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * This function edits the user
     * @param Request $request
     * @param User $user
     * @return Response
     */
     #[Route('/edit/{id}', 'user.edit', methods: ['GET', 'POST'])]
     #[IsGranted('ROLE_ADMIN')]
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
 
         return $this->render('user/edit.html.twig', [
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
    #[Route('/delete/{id}', 'user.delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
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
