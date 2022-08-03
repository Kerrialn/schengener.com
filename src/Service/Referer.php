<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class Referer
{
    public function __construct(
        private readonly RequestStack    $requestStack,
        private readonly RouterInterface $router
    )
    {
    }

    public function getReferer(): string
    {
        $request = $this->requestStack->getMainRequest();

        if (null === $request) {
            return '';
        }

        //if you're happy with URI (and most times you are), just return it
        $uri = (string)$request->headers->get('referer');

        //but if you want to return route, here you go
        try {
            $routeMatch = $this->router->match($uri);
        } catch (ResourceNotFoundException $e) {
            return '';
        }

        $route = $routeMatch['_route'];

        return $route;
    }

}