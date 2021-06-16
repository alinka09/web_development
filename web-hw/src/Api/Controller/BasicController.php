<?php

declare(strict_types=1);

namespace App\Api\Controller;

use App\Api\Utils\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/")
 */
class BasicController
{
    /**
     * @Route(path="/basic", methods={"GET"})
     * @param Request $request
     * @param AuthService $authService
     * @return Response
     */
    public function basic(Request $request, AuthService $authService)
    {
        $authMetaData = $request->headers->get('Authorization', '');

        if($authMetaData !=='' && $authService->checkCredentials($authMetaData)) {
            return new Response(
                json_encode([
                                'message'=>'Ok, method logic result is here',
                            ]),
                Response::HTTP_OK,
                [
                    'www-Authenticate' => 'Basic realm="Access is open", charset="UTF-8"',
                    'Content-type'=>'application/json'
                ]
            );
        }

        return new Response(
            json_encode([
                            'message'=>'Not Authorized',
                        ]),
            Response::HTTP_UNAUTHORIZED,
            [
                'www-Authenticate' => 'Basic realm="Access to the staging site", charset="UTF-8"',
                'Content-type'=>'application/json'
            ]
        );
    }
}