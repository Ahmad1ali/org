<?php

namespace App\Controller;

use App\Entity\Story;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
//    #[Route(path: '/redirect', name: 'app_redirect')]
//    public function redirectAction( Security $security ): Response
//    {
//       if ($security->isGranted('ROLE_ADMIN')) {
//           return $this->redirectToRoute('app_admin');
//       }
//       if ($security->isGranted('ROLE_MEMBER')) {
//           return $this->redirectToRoute('app_member');
//       }
//       return $this->redirectToRoute('app_default');
//
//
//    }


    #[Route(path: '/admin', name: 'app_admin')]
    public function Admin( EntityManagerInterface $entityManager ): Response
    {
          $getStory = $entityManager->getRepository(Story::class)->findAll();

        return $this->render('security/admin.html.twig', [
//            $Welcome ="welcom Admin",
//            'admin' => $Welcome,
            'storys' => $getStory,
        ]);
    }

    #[Route(path: '/member', name: 'app_member')]
    public function member( EntityManagerInterface $entityManager ): Response
    {

        $name = $this->getUser();
        $showStory = $entityManager->getRepository(Story::class)->findBy(['user'=>$name]);


        return $this->render('security/member.html.twig', [
              'user'=>$name,
              'storys' => $showStory,
        ]);
    }



    #[Route(path: '/delete/{id}', name: 'app_delete')]
    public function delete( EntityManagerInterface $entityManager ,int $id ): Response
    {
//        $delete = $entityManager->getRepository(Story::class)->find($id);
        // from inside a controller
        $getStory = $entityManager->getRepository(Story::class);
        $delete = $getStory->find($id);
        $entityManager->remove($delete);
        $entityManager->flush();

        return $this->render('security/admin.html.twig', [

//            'storys' => $getStory,
        ]);
    }

//    #[Route(path: '/member/', name: 'app_member')]
//    public function member( EntityManagerInterface $entityManager ): Response
//    {
//
//        return $this->render('security/member.html.twig', [
//
//
//
//        ]);
//    }
//    #[Route(path: '/member/id', name: 'app_member')]
//    public function showMember( EntityManagerInterface $entityManager ,int $id ): Response
//    {
//        $member = $entityManager->getRepository(Story::class)->findBy(['id'=>$id]);
//
//        return $this->render('security/member.html.twig', [
//            'member' => $member,
//
//
//
//        ]);
//    }






    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
