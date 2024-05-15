<?php

namespace App\Controller;

use App\Entity\Story;
use App\Entity\User;
use App\Form\AddStoryType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
        }
        if($this->isGranted('ROLE_MEMBER')) {
            return $this->redirectToRoute('app_member');
        }

//        else {
//            return $this->redirectToRoute('app_register');
//        }

            return $this->render('main/index.html.twig', [

            ]);

    }
#[Route(path: '/register', name: 'app_register')]
 public function register(Request $request ,EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher ): Response
   {

       $register = new User();
       $register->setRoles(['ROLE_MEMBER']);

       $form = $this->createForm(RegisterType::class, $register);

       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {

           $push = $form->getData();
           $register->setPassword($passwordHasher->hashPassword(
               $register,
               $register->getPassword(),

           ));



           $entityManager->persist($push);
           $entityManager->flush();




           return $this->redirectToRoute('app_login');
       }

       return $this->render('security/register.html.twig', [
           'form' => $form,
       ]);



   }
 #[Route(path: '/addstory', name: 'app_addstory')]
 public function addStory(Request $request, EntityManagerInterface $entityManager  ): Response
 {
     {
         $user = $this->getUser();

         $task = new Story();
         $task->setUser($user);

         $form = $this->createForm(AddStoryType::class, $task);

         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
             // $form->getData() holds the submitted values
             // but, the original `$task` variable has also been updated
             $task = $form->getData();
             $entityManager->persist($task);
             $entityManager->flush();

             // ... perform some action, such as saving the task to the database

             return $this->redirectToRoute('app_member');
         }

         return $this->render('main/story.html.twig', [

             'form' => $form,
         ]);
     }


 }

    #[Route(path: '/update/{id}', name: 'app_updatestory')]
    public function updateStory(Request $request, EntityManagerInterface $entityManager,int $id  ): Response
    {
        {
//            $user = $this->getUser();
             $updateStory = $entityManager->getRepository(Story::class)->find($id);
//            $task = new Story();
//            $task->setUser($user);

            $form = $this->createForm(AddStoryType::class, $updateStory);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $task = $form->getData();
                $entityManager->persist($task);
                $entityManager->flush();

                // ... perform some action, such as saving the task to the database

                return $this->redirectToRoute('app_member');
            }

            return $this->render('main/update.html.twig', [

                'form' => $form,
            ]);
        }


    }
}
