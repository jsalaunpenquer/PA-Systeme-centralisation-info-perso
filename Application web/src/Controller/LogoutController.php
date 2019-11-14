<?php


namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LogoutController extends AbstractController
{
    public function logout(Request $request, AuthenticationUtils $authenticationUtils){

    }
}