<?php

declare(strict_types=1);

namespace App\Core\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    // ...

    /**
     * Load the site definition and redirect to the default page.
     *
     * @Route("/")
     */
    public function indexAction()
    {
        return new Response(
            json_encode([
                'message'=>'HomePage',
            ]),
            Response::HTTP_OK,
            [
                'Content-type'=>'application/json'
            ]
        );
    }
}