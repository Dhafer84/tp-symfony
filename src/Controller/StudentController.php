<?php
namespace App\Controller;

use App\Entity\Student;
use App\Form\SearchStudentType;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController {
    /**
     * @Route("/index", name="index_page")
     */

    public function index():Response {
        return new Response("<h1> Symfony </h1> <p>Hello!! </p>");

    }

    #[Route('/msg', name:'msg')]
    public function msg():Response {
        return new Response("Bonjour mes étudiants");
    }
   

    #[Route('/index1/{name}/{age}', name:'Test')]
    public function index1(Request $request, $name, $age):Response {
        //return new Response($request-> attributes->get('_route'));
        return new Response("Bonjour"." " .$name ." ". $age);
       //return $this->redirect('https://www.google.com',200);
    }
    #[Route("/List", name:'student_list')]
    public function List(ManagerRegistry $doctrine ):Response {
        $students= $doctrine->getRepository(Student::class)->findAll();
        return $this->render('student/List.html.twig',['students'=> $students]);
    }
    #[Route("/listO", name: "student_listO")]
    public function listO(ManagerRegistry $doctrine): Response
    {

        $students = $doctrine->getRepository(Student::class)->orderName();
        return $this->render('student/List.html.twig', [
            'students' => $students
        ]);
    }
    #[Route("/listSearch", name: "student_listO")]
    public function listSearch(Request $req, ManagerRegistry $doctrine): Response
    {

        $students = $doctrine->getRepository(Student::class)->orderName();
        $form = $this->createForm(SearchStudentType::class);
        $form->handleRequest($req);
        if($form ->isSubmitted()){
            $name=$form['name']->getData();
            $students = $doctrine->getRepository(Student::class)->searchStudent($name);
        }
        return $this->renderForm('student/listSearch.html.twig', [
            'students' => $students,
            'form' => $form
        ]);
    }
    #[Route("/List2", name:'student_list2')]
    public function List2(StudentRepository $repo ):Response {
        $students= $repo->findAll();
        return $this->render('student/List.html.twig',['students'=> $students]);
    }
    #[Route('/show/{id}', name:'student_detail')]
    public function show(ManagerRegistry $doctrine, int $id):Response {
        $students= $doctrine->getRepository(Student::class)->find($id);
        return $this->render('student/show.html.twig', ['students'=>$students]);
    }
    #[Route('/show1/{id}', name:'student_detail1')]
    public function show1(StudentRepository $repo, int $id):Response {
        $students= $repo->getRepository(Student::class)->find($id);
        return $this->render('student/show.html.twig', ['students'=>$students]);
    }
    #[Route('/show2/{id}', name:'student_detail2')]
    public function show2(Student $students):Response {
        
        return $this->render('student/show.html.twig', ['students'=>$students]);
    }
    #[Route('DeleteStudent/{id}', name:'student_delete')]
    public function delete(Student $students,ManagerRegistry $doctrine ):Response {
        $EntityManager=$doctrine->getManager();
        $EntityManager->remove($students);
        $EntityManager->flush();

        return new Response('Supression Etudiant');
    }
    #[Route('DeleteStudent2/{id}', name:'student_delete2')]
    public function delete2(Student $students,StudentRepository $repo ):Response {
        $repo->remove($students,true);

        return new Response('Supression Etudiant');
    }

    #[Route('/add', name:'student_add')]
    public function add(ManagerRegistry $doctrine):Response {
        $students = new Student();
        $students->setName('dhafer.bouthelja');
        $EntityManager=$doctrine->getManager();
        $EntityManager->persist($students);
        $EntityManager->flush();

        return $this->redirectToRoute('student_list2');
    }

    #[Route('/add2', name:'student_add2')]
    public function add2(StudentRepository $repo):Response {
        $students = new Student();
        $students->setName('dhafer.bouthelja');
        $repo->add($students,true);

        return $this->redirectToRoute('student_list2');
    }

    #[Route('/add3', name:'student_add3')]
    public function add3(Request$request ,StudentRepository $repo):Response {
        $students = new Student();
        // $form=$this->createFormBuilder($students)->add('name', TextType::class)->add('submit',SubmitType::class)->getForm();
        // $form->handleRequest($request);
        $form=$this->createForm(StudentType::class, $students);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $students =$form->getData();
            $repo->add($students,true);
            return $this->redirectToRoute('student_list2');
        }
        return $this->renderForm('student/add.html.twig',['form'=>$form]);

    }

    #[Route('/update/{id}', name:'student_update')]
    public function update(Request $request, ManagerRegistry $doctrine, $id):Response{
    
    $students = $doctrine->getRepository(Student::class)->find($id);

    $form = $this->createForm(StudentType::class, $students);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $students = $form->getData();
        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('student_list2');
    }
    return $this->renderForm('student/add.html.twig', [
        'form' => $form
    ]);

    }
}