<?php
namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Tournoi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AccueilController extends Controller{
	/**
     * @Route("/accueil", name="accueil")
     */
	public function accueilAction(Request $request){
		

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('login');
        }

        //all tournament for queries
        $repository = $this->getDoctrine()->getRepository('AppBundle:Tournoi');

        date_default_timezone_set('Europe/Paris');
        $criteria = new \Doctrine\Common\Collections\Criteria();
        $criteria->where($criteria->expr()->gt('date', new \Datetime() ));
        $result = $repository->matching($criteria);

        $tournois =  array();
        foreach ($result as &$value) {
           if($value->getIduser()->contains($this->getUser())){
             array_push($tournois,$value);
           }
        }
		

        
		return $this->render('registration/accueil.html.twig',
			array( 'tournois'=>$tournois)
			);
	}
}