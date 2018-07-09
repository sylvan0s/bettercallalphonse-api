<?php

namespace App\Controller;

use App\Service\QuestionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Configuration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController
{
    private $questionService;

    public function __construct(QuestionService $questionService)
    {
        /** @var \App\Service\QuestionService questionService */
        $this->questionService = $questionService;
    }

    /**
     * Custom route to do Get operation over User entity with all nested relations
     * It uses ParamConverter usage to reduce the responsability of the controller
     *
     * @Configuration\Route(
     *     name="choices_grouped_by_id_question",
     *     path="/api/admin/choices_grouped_by_id_question/{idQuestion}.{_format}",
     *     methods={"GET"}
     * )
     */
    public function GetAllChoicesGroupedByQuestion(Request $request)
    {
        $result = $this->questionService->GetChoicesGroupedByIdQuestion($request->get('idQuestion'));

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }
}