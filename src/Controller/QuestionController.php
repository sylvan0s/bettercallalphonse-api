<?php

namespace App\Controller;

// src\App\Action\Bookspecial.php
use App\Entity\Question;
use App\Service\QuestionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Configuration;
use Symfony\Component\HttpFoundation\Request;

class QuestionController
{
    private $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    /**
     * Custom route to do Get operation over Question entity with all nested relations
     * It uses ParamConverter usage to reduce the responsability of the controller
     *
     * @Configuration\Route(
     *     name="question_special1",
     *     path="/api/questions/{id}/list",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Question::class,
     *         "_api_item_operation_name"="special1"
     *     }
     *
     * )
     */
    public function getListQuestion(Question $data) : Question
    {
        return $data;
    }


    /**
     * Custom route to do Post operation over Question entity with all nested relations
     *
     * @Configuration\Route(
     *     name="question_special2",
     *     path="/api/questions/traitement",
     *     methods={"POST"},
     *     defaults={
     *          "_api_item_operation_name"="special2",
     *          "_format"=NULL
     *     }
     * )
     */
    public function traitementQestion(Request $request)
    {
        var_dump($request->get('id')); die;
    }
}