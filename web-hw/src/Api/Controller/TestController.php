<?php

declare(strict_types=1);

namespace App\Api\Controller;

use App\Api\Utils\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/test")
 */
class TestController
{
    /**
     * @Route(path="/", methods={"GET"})
     */
    public function index()
    {
        return new Response(
            json_encode([
                'message' => 'Access via JWT tokens is open!!! Hooray!!! ',
            ]),
            Response::HTTP_OK,
            [
                'Content-type' => 'application/json'
            ]
        );
    }

    /**
     * @Route(path="/users", methods={"GET"})
     */
    public function users()
    {
        return new Response(
            json_encode(
                [
                    new class ('Alina', 19.1, 123, 'Saransk') {
                        public $name;
                        public $weight;
                        public $height;
                        public $city;

                        public function __construct($name, $weight, $height, $city)
                        {
                            $this->name = $name;
                            $this->weight = $weight;
                            $this->height = $height;
                            $this->city = $city;
                        }
                    },
                    new class ('Liza', 45, 121331, 'Moscow') {
                        public $name;
                        public $weight;
                        public $height;
                        public $city;

                        public function __construct($name, $weight, $height, $city)
                        {
                            $this->name = $name;
                            $this->weight = $weight;
                            $this->height = $height;
                            $this->city = $city;
                        }
                    }
                ]
            ),
            Response::HTTP_OK,
            [
                'Content-type' => 'application/json'
            ]
        );
    }

    /**
     * @Route(path="/info", methods={"GET"})
     */
    public function info()
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $tokenParts = explode(".", str_replace("BEARER ", "", $token));
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);

        return new Response(
            json_encode(
                [
                    "username" => $jwtPayload->username,
                    "iat" => $jwtPayload->iat,
                    "exp" => $jwtPayload->exp,
                    "roles" => $jwtPayload->roles
                ]
            ),
            Response::HTTP_OK,
            [
                'Content-type' => 'application/json'
            ]
        );
    }
}