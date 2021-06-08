<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 */
class TestController
{
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
                'Content-type'=> 'application/json'
            ]
        );
    }

}