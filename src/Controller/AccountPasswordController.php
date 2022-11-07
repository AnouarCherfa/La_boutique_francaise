<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {      
    }
    #[Route('/compte/modifier-mon-password', name: 'account_password')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);

        $notification = null; 

        ## Ecouter et manipuler la requete entrante
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $old_passeword = $form->get('old_password')->getData();


            if ($hasher->isPasswordValid($user,$old_passeword))
            {

                // Nouveau mot de passe en claire : 

                $new_password_en_clair = $form->get('new_password')->getData();

                // Hash le mot de passe
                $new_password_hash = $hasher->hashPassword($user, $new_password_en_clair);

                // Enregistrer le nouveau mot de password hashé
                $user->setPassword( $new_password_hash );

                $this->doctrine->getManager()->persist($user);
                $this->doctrine->getManager()->flush();
                
                $notification ='Votre mot de passe a bien été mis à jour.';
            }else {
                $notification = 'Votre mot de passe actuel n\'est pas le bon.';
            }


        }

        return $this->renderForm('account/password.html.twig', [
            'form'          => $form,
            'notification'  => $notification
        ]);
    }
}
