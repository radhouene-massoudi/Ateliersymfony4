<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club")
     */
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    /**
     * @Route("/listclub", name="club")
     */
    public function listClub()
    {
        $clubs = $this->getDoctrine()->getRepository(Club::class)->findAll();
        return $this->render('club/list.html.twig', array("clubs" => $clubs));
    }

    /**
     * @Route("/deleteclub/{id}", name="deleteClub")
     */
    public function deleteClub($id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("club");
    }

    /**
     * @Route("/showclub/{id}", name="showClub")
     */
    public function showClub($id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        return $this->render('club/show.html.twig', array("club" => $club));
    }

    /**
     * @Route("/addclub", name="addClub")
     */
    public function addClub(Request $request)
    {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('club');
        }
        return $this->render("club/add.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/updateclub/{id}", name="updateClub")
     */
    public function updateClub(Request $request,$id)
    {
        $club = $this->getDoctrine()->getRepository(Club::class)->find($id);
        $form = $this->createForm(ClubType::class, $club);
        $form->add('modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('club');
        }
        return $this->render("club/update.html.twig",array('form'=>$form->createView()));
    }
}
