<?php
namespace Osimek1\ArticlesBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller displaying article
 */
class ShowArticleController extends ContainerAware
{
    public function showAction(Request $request)
    {
        
    }
}
