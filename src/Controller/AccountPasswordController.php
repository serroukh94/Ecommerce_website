<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    #[Route('/compte/modifier-mon-mot-de-passe', name: 'account_password')]
    public function index(Request $request, userPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);  // nous avons appelé notre formulaire

        $form-> handleRequest($request);

        if ($form -> isSubmitted() && $form->isValid() ) {
            $old_pwd = $form->get('old_password')->getData();   // récuperer l'ancien mot de passe

            if($passwordHasher->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();  // cherche le nouveau mot de passe
                $password = $passwordHasher->hashPassword($user, $new_pwd);

                $user->setpassword($password);

                $entityManager->persist($user);
                $entityManager->flush();

                $notification = "Votre mot de passe a bien été mis à jour.";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon";
            }

        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
