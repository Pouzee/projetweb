<?php
namespace AppBundle\Controller;

use AppBundle\Form\InscriptionForm;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use AppBundle\Form\CreateTournamentForm;
use AppBundle\Form\CreateEditTournamentForm;
use AppBundle\Entity\Tournoi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class TournamentController extends Controller{
	/**
     * @Route("/tournoi", name="tournament")
     */
	public function affichTournamentAction(){
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('login');
        }
        //all tournament for queries
		$repository = $this->getDoctrine()->getRepository('AppBundle:Tournoi');

        date_default_timezone_set('Europe/Paris');
        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->where($criteria->expr()->gt('date', new \Datetime() ));
        $result = $repository->matching($criteria);

        
		


        
		return $this->render('registration/gettournament.html.twig',
			array('tournament' => $result)
			);
	}

    /**
     * @Route("/tournoi/create", name="tournament_creation")
     */
    public function registerAction(Request $request){
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('login');
        }


        $tournoi = new Tournoi;
        $form = $this->createForm(CreateTournamentForm::class, $tournoi);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tournoi->setIdroot($this->getUser());
            if($tournoi->getMaxuser()<2){
                return $this->render('registration/createtournament.html.twig',
                array('form' => $form->createView(), 'error' => 'Le nombre de participants doit être au moins de deux')
            );
            }
            $diff = $tournoi->getDate()->diff( new \Datetime() );
            if($diff->format('%R%a') >=0){
                return $this->render('registration/createtournament.html.twig',
                array('form' => $form->createView(), 'error' => 'Vous ne pouvez pas creer de tournois pour une date anterieure')
                );
            }

            
            $em = $this->getDoctrine()->getManager();
            $em->persist($tournoi);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('mytournament');


        }
        
        


        
        return $this->render('registration/createtournament.html.twig',
            array('form' => $form->createView(), 'error' => '')
            );
    }


    /**
     * @Route("/tournoi/{id}/edit", name="edit_tournament")
     * 
     */
    public function editTournamentAction($id, Request $request){


        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('login');
        }

        if(!(is_numeric($id))){
            throw $this->createNotFoundException('Id de tournoi Invalide');
        }
        //all tournament for queries
        $repository = $this->getDoctrine()->getRepository('AppBundle:Tournoi');

        $result = $repository->findOneByIdtable($id);

        if(!$result){
            throw $this->createNotFoundException('Tournoi Invalide');
        }
        if($result->getIdroot()!=$this->getUser()){
            return $this->redirectToRoute('tournament_select',array('id' => $id));
        }
       
        $tournoi = new Tournoi;
        $form = $this->createForm(CreateEditTournamentForm::class, $tournoi);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if($tournoi->getMaxuser()<2){
                return $this->render('registration/edittournament.html.twig',
                array('form' => $form->createView(), 'error' => 'Le nombre de participants doit être au moins de deux','nom' => $tournoi->getNom(),
             'maxuser' => $tournoi->getMaxuser(),'description' => $tournoi->getDescription())
            );
            }
            $diff = $tournoi->getDate()->diff( new \Datetime() );
            if($diff->format('%R%a') >=0){
                return $this->render('registration/edittournament.html.twig',
                array('form' => $form->createView(), 'error' => 'Vous ne pouvez pas creer de tournois pour une date anterieure','nom' => $tournoi->getNom(),
             'maxuser' => $tournoi->getMaxuser(),'description' => $tournoi->getDescription())
                );
            }
            
            $result->setNom($tournoi->getNom());
            $result->setDate($tournoi->getDate());
            $result->setMaxuser($tournoi->getMaxuser());
            $result->setDescription($tournoi->getDescription());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('mytournament');
        
        }
        
        
        return $this->render('registration/edittournament.html.twig',
            array('nom' => $result->getNom(),
             'maxuser' => $result->getMaxuser(),'form' => $form->createView(),'description' => $result->getDescription(), 'error' => '')
            );    
    }




    /**
     * @Route("/tournoi/{id}/delete", name="delete_tournament")
     * 
     */
    public function deleteTournamentAction($id, Request $request){


        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('login');
        }

        if(!(is_numeric($id))){
            throw $this->createNotFoundException('Id de tournoi Invalide');
        }
        //all tournament for queries
        $repository = $this->getDoctrine()->getRepository('AppBundle:Tournoi');

        $result = $repository->findOneByIdtable($id);

        if(!$result){
            throw $this->createNotFoundException('Tournoi Invalide');
        }
        if($result->getIdroot()!=$this->getUser()){
            return $this->redirectToRoute('tournament_select',array('id' => $id));
        }
       

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
        
            
            $delete = $repository->findOneByIdtable($id);
            
            $em = $this->getDoctrine()->getManager();
            foreach($delete->getIduser()->toArray() as &$value){

                $delete->removeIduser($value);
            }
            $em->flush();
            $em->remove($delete);
            $em->flush();
            return $this->redirectToRoute('mytournament');
        
        }
        
        
        return $this->render('registration/deletetournament.html.twig',
            array('tournament' => $result, 'form' => $form->createView())
            );    
    }



    /**
     * @Route("/tournoi/mestournois", name="mytournament")
     */
    public function affichMyTournamentAction(){


        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('login');
        }

        //all tournament for queries
        $repository = $this->getDoctrine()->getRepository('AppBundle:Tournoi');

        $result = $repository->findByIdroot($this->getUser());

        
        


        
        return $this->render('registration/getmytournament.html.twig',
            array('tournament' => $result)
            );
    }

    /**
     * @Route("/tournoi/{id}", name="tournament_select")
     */
    public function selectAction($id, Request $request){

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('login');
        }

        
        
        if(!(is_numeric($id))){
            throw $this->createNotFoundException('Id de tournoi Invalide');
        }
        //all tournament for queries
        $repository = $this->getDoctrine()->getRepository('AppBundle:Tournoi');

        $result = $repository->findOneByIdtable($id);

        if(!$result){
            throw $this->createNotFoundException('Tournoi Invalide');
        }

        $participants = $result->getIduser();
        //$inscrit = in_array($this->getUser(),$participants);
        if(!($participants->contains($this->getUser()))){
            $inscrit = false;
        }
        else{
            $inscrit = true;
        }

        $form = $this->createForm(InscriptionForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
        
            
            $em = $this->getDoctrine()->getManager();
            
            //throw $this->createNotFoundException('Tournoi blu');
            if($inscrit == true){
                $result->removeIduser($this->getUser());
            
                
                $em->flush();
                $inscrit = false;

            }
            else{
                if($result->getIduser()->count()>= $result->getMaxuser()){
                    return $this->render('registration/getselectedtournament.html.twig',
                    array('tournament' => $result, 'inscrit' => $inscrit,'form' => $form->createView(), 'diff' => $diff,'error' => 'Capacite sature')
                    );
                }
                $result->addIduser($this->getUser());
                
                
                $em->flush();
                $inscrit = true;
            }
        
        }
        
        $diff = $result->getDate()->diff( new \Datetime() );


        
        return $this->render('registration/getselectedtournament.html.twig',
            array('tournament' => $result, 'inscrit' => $inscrit,'form' => $form->createView(), 'diff' => $diff, 'error'=> '')
            );
    }





    private function createDeleteForm($id){
        return $this->createFormBuilder(array('id'=> $id))
            ->add('id',HiddenType::class)
            ->setMethod('DELETE')
            ->getForm();
    }

    
    
}