<?php

namespace App\Controller;

use App\Service\UserQuestionChoiceService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Configuration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserQuestionChoiceController
{
    private $userQuestionChoiceService;

    public function __construct(UserQuestionChoiceService $userQuestionChoiceService)
    {
        /** @var \App\Service\UserQuestionChoiceService questionService */
        $this->userQuestionChoiceService = $userQuestionChoiceService;
    }

    /**
     * Custom route to do Get operation over QuestionChoice entity with all nested relations
     * It uses ParamConverter usage to reduce the responsability of the controller
     *
     * @Configuration\Route(
     *     name="api_choices_grouped_by_id_question",
     *     path="/api/admin/choices_grouped_by_id_question/{idQuestion}.{_format}",
     *     methods={"GET"}
     * )
     */
    public function GetAllChoicesGroupedByIdQuestion(Request $request)
    {
        $result = $this->userQuestionChoiceService->GetChoicesGroupedByIdQuestion($request->get('idQuestion'));

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }
}