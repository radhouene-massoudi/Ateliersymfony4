<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\ClassroomType;
use App\Form\SearchStudentByClassType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/classroom", name="classroom")
     */
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    /**
     * @Route("/listClassroom", name="listClassroom")
     */
    public function listClassroom()
    {
        $classrooms = $this->getDoctrine()->getRepository(Classroom::class)->findAll();
        return $this->render('classroom/list.html.twig', array("classrooms" => $classrooms));
    }

    /**
     * @Route("/deleteClassroom/{id}", name="deleteClassroom")
     */
    public function deleteClassroom($id)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($classroom);
        $em->flush();
        return $this->redirectToRoute("listClassroom");
    }

    /**
     * @Route("/addClassroom", name="addClassroom")
     */
    public function addClassroom(Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('listClassroom');
        }
        return $this->render("classroom/add.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/updateClassroom/{id}", name="updateClassroom")
     */
    public function updateClassroom(Request $request,$id)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassRoomType::class, $classroom);
        $form->add('modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listClassroom');
        }
        return $this->render("classroom/update.html.twig",array('form'=>$form->createView()));
    }

    /**
     * @Route("/showClassroom/{id}", name="showClassroom")
     */
    public function showClassroom($id)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $students= $this->getDoctrine()->getRepository(Student::class)->listStudentByClass($classroom->getId());
        return $this->render('classroom/show.html.twig', [
            "classroom" => $classroom,
            "students"=>$students]);
    }


    /**
     * @Route("/showClassroomAVG/{id}", name="showClassroomAVG")
     */
    public function showClassroomAVG($id)
    {   $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $moyenne= $this->getDoctrine()->getRepository(Classroom::class)->findStudentByClassAVG($classroom->getName());
        return $this->render('classroom/showAVG.html.twig', [
            "classroom" => $classroom,
            "moyenne"=>$moyenne]);
    }


}
