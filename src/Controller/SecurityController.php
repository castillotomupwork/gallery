<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $utils)
    {
        if (is_object($this->getUser())) {
            return $this->redirectToRoute('gallery');
        }
        
        $error = $utils->getLastAuthenticationError();
        
        $lastUsername = $utils->getLastUsername();
        
        if ($error) {
            $this->addFlash('danger', $error->getMessageKey());
        }
        
        return $this->render('security/login.html.twig', [
            'lastUsername' => $lastUsername
        ]);
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        
    }
}
