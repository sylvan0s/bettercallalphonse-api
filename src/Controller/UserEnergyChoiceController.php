<?php
/**
 * Created by PhpStorm.
 * User: Zakariae
 * Date: 08/07/2018
 * Time: 17:32
 */

namespace App\Controller;

use App\Service\UserEnergyChoiceService;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Configuration;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserEnergyChoiceController
{
    private $userEnergyChoiceService;
    private $container;

    public function __construct(
        UserEnergyChoiceService $userEnergyChoiceService,
        ContainerInterface $container
    )
    {
        /** @var \App\Service\UserEnergyChoiceService userEnergyChoiceService */
        $this->userEnergyChoiceService = $userEnergyChoiceService;
        $this->container = $container;
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

    /**
     *
     * @Configuration\Route(
     *     name="api_energy_user_has_voted",
     *     path="/api/energy_user_has_voted.{_format}",
     *     methods={"GET"}
     * )
     */
    public function getUserHasVotedToday(Request $request)
    {
        $result = $this->userEnergyChoiceService->getUserHasVotedToday();

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }

    /**
     *
     * @Configuration\Route(
     *     name="api_energy_user_get_energies",
     *     path="/api/energy_user_get_energies.{_format}",
     *     methods={"GET"}
     * )
     */
    public function getUserEnergy(Request $request)
    {
        $result = $this->userEnergyChoiceService->getUserEnergy();

        return new JsonResponse($result, JsonResponse::HTTP_OK);
    }
}
