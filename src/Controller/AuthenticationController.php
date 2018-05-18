<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Configuration;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthenticationController
 *
 * @package AppBundle\Controller
 */
class AuthenticationController extends Controller
{
    /**
     * @Configuration\Route(
     *     name="refreshToken",
     *     path="/api/token/refresh",
     *     methods={"POST"}
     * )
     */
    public function refreshTokenAction(Request $request)
    {
        return $this->get('gesdinet.jwtrefreshtoken')->refresh($request);
    }
}