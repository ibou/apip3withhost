<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

#[AsController]
class HomepageController extends AbstractController
{
    public function __construct(private RouterInterface $router)
    {
    }

    #[Route('/', name: 'app_homepage')]
    #[Route('/auth-via-steam', name: 'app_login')]
    public function __invoke(): Response
    {
        return $this->render('homepage/index.html.twig', [
            'frontRoutes' => $this->findFrontRoutes(),
        ]);
    }

    private function findFrontRoutes(): array
    {
        $found = [];
        $routes = $this->router->getRouteCollection();
        foreach ($routes as $name => $route) {
            if (str_starts_with($name, 'app')) {
                $found[$route->getPath()] = $name;
            }
        }

        return $found;
    }
}
