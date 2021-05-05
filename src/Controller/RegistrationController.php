<?php

namespace App\Controller;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct()
    {

    }

    /**
     * @Route("/regiser", name="registration")
     *
     * @param Request $request
     */
    public function register(Request $request)
    {
        $username = $request->get(key:'username');
        $email = $request->get(key:'email');
        $password = $request->get(key:'password');
        $firstName = $request->get(key:'firstName');
    }
}
