<?php
namespace AppBundle\Controller;

use AppBundle\Form\registerform;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class registercontroller extends Controller{
	/**
     * @Route("/register", name="user_registration")
     */
	public function registerAction(Request $request){
		$user = new User;
		$form = $this->createForm(registerform::class, $user);

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('accueil');
        }


		// 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if username/mail already in use
            $repository = $this->getDoctrine()->getRepository('AppBundle:User');

            $resultpseudo = $repository->findOneByPseudo($user->getPseudo());
            $resultmail = $repository->findOneByMail($user->getMail());

            if($resultpseudo){
                return $this->render('registration/register.html.twig',
                array('form' => $form->createView(), 'error' => 'Pseudo deja pris')
                );
            }
            if ($resultmail){
                return $this->render('registration/register.html.twig',
                array('form' => $form->createView(), 'error' => 'Mail deja pris')
                );
            }


            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('login');


        }
		return $this->render('registration/register.html.twig',
			array('form' => $form->createView(), 'error' => '')
			);
	}
}