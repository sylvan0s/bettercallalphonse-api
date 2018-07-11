<?php
/**
 * Created by PhpStorm.
 * User: Zakariae
 * Date: 08/07/2018
 * Time: 17:32
 */

namespace App\Controller;

use App\Service\UserEnergyChoiceService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Configuration;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserEnergyChoiceController
{
    public function __construct(UserEnergyChoiceService $userEnergyChoiceService)
    {
        /** @var \App\Service\UserEnergyChoiceService userEnergyChoiceService */
        $this->userEnergyChoiceService = $userEnergyChoiceService;
    }

    /**
     * Custom route to do Get operation over userEnergyChoice entity with all nested relations
     * It uses ParamConverter usage to reduce the responsability of the controller
     *
     * @Configuration\Route(
     *     name="api_admin_energy_avg_Grouped_by_day",
     *     path="/api/admin/energy_avg_Grouped_by_day.{_format}",
     *     methods={"GET"}
     * )
     */
    public function GetEnergyAvgGroupedDayForAdmin(Request $request)
    {
        $result = $this->userEnergyChoiceService->GetEnergyAvgGroupedDayForAdmin();

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     *
     * @Configuration\Route(
     *     name="api_energy_avg_Grouped_by_day",
     *     path="/api/energy_avg_Grouped_by_day.{_format}",
     *     methods={"GET"}
     * )
     */
    public function GetEnergyAvgGroupedDay(Request $request)
    {
        $result = $this->userEnergyChoiceService->GetEnergyAvgGroupedDay();

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

}