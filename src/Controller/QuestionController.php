<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Question;

class QuestionController extends Controller
{
    /**
     * @Route("/question", name="question")
     */
    public function index()
    {
        /* return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]); */

        $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();

        return new Response($questions, Response::HTTP_OK, array('content-type' => 'application/json'));
    }
}
