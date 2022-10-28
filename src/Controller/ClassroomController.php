<?php

namespace App\Controller;

use App\Entity\Classroom;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route("/ListClass", name:'classroom_list')]
    public function ListClass(ManagerRegistry $doctrine ):Response {
        $classroom= $doctrine->getRepository(Classroom::class)->findAll();
        return $this->render('classroom/List.html.twig',['class'=> $classroom]);
    }
    #[Route('/ListClass/{id}', name:'class_detail2')]
    public function listclass2(Classroom $classroom):Response {
        
        return $this->render('classroom/show.html.twig', ['class'=>$classroom]);
    }
}
