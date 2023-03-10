<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(private RequestStack $requestStack)
    {
    }
    public function handle(Request $request, AccessDeniedException $accessDeniedException): RedirectResponse
    {
        $request->getSession()->getFlashBag()->add('danger', 'Vous devez être admin.');
        return new RedirectResponse(('/'));
    }
}
