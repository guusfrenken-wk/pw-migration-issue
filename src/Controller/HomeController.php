<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home')]
    public function __invoke(AuthenticationUtils $authenticationUtils): Response
    {

        return $this->json(['message' => 'welcome!']);
    }
}
