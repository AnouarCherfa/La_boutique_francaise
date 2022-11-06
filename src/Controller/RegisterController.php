<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    ## argument indique à Symfony d'injecter le service Doctrine dans la méthode du controller (RegisterController)
    public function __construct(private ManagerRegistry $doctrine)
    {      
    }


    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        
        $User = new User();       
        $form = $this->createForm(RegisterType::class, $User);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $utilisateur = $form->getdata();

            ## Hasher le Password
            $password = $hasher->hashPassword($User, $User->getPassword());
            $User->setPassword($password);

            $doctrine = $this->doctrine->getManager();
            $doctrine->persist($utilisateur);
            $doctrine->flush();
        }

        ## Affiches moi le template register
        return $this->renderForm('register/index.html.twig', [
            'monformulaire' => $form,
        ]);
    }


}
