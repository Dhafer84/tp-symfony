<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig', [
            'controller_name' => 'Dhafer',
        ]);
    }
   /* #[Route('/{name}', name:'Atelier2')]
    public function showTeacher($name):Response{
        return new Response("Bonjour"." " .$name );
    }*/

    /*#[Route('/redirect', name:'redirect')]
    public function redirect2(Request $request): RedirectResponse{
    return $this->redirectToRoute('StudentController/index1');
    }*/

    #[Route('/show/{name2}', name:'Atelier2')]
    public function showTeacher2($name2):Response{
        $classes=['2cinfo2','2cinfo1','2cinfo3'];
        return $this->render('teacher/showTeacher.html.twig', [
            'name' => $name2,
            'classes'=>$classes,
        ]);
    }
    #[Route('/redirect', name:'redirect')]
    public function redirection():Response{
        $classe='2cinfo2';
        return $this->redirectToRoute('msg');
    }


    /*#[Route('/{name2}', name:'Atelier2')]
    public function showTeacher2($name2):Response{
        return $this->render('teacher/showTeacher.html.twig', [
            'name' => $name2,
        ]);
    }*/
   
   
}
