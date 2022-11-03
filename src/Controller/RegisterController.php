<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends AbstractController
{
    ## argument indique à Symfony d'injecter le service Doctrine dans la méthode du controller (RegisterController)
    public function __construct(private ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
                
    }


    #[Route('/inscription', name: 'register')]
    public function index(Request $request): Response
    {
        ## (Instancier) Créer un nouvel objet
        $User = new User();

        ## Créer un formulaire avec la classe RegisterType et la classe $User
        $form = $this->createForm(RegisterType::class, $User);

        ## injecter les données soumisent à form 
        $form->handleRequest($request);

        ## Si le formulaire est soumit et valider ...
        if ($form->isSubmitted() && $form->isValid()) {

            ## injecter les données du formulaire à l'objet $user
            $user = $form->getdata();

            ## Récupérer l'objet gestionnaire d'entités de Doctrine
            $doctrine = $this->doctrine->getManager();
            ## Enregistre les données de l'objet $user 
            $doctrine->persist($user);
            ## injecter dans la base de données
            $doctrine->flush();
        }

        return $this->renderForm('register/index.html.twig', [
            'form' => $form,
        ]);
    }

}
