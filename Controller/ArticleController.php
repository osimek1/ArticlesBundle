<?php
namespace Osimek1\ArticlesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controller displaying article
 */
class ArticleController extends Controller
{
    /**
     * @Template()
     */
    public function showAction(Request $request, $slug)
    {
        $article = $this->get('osimek1.articles.manager')->getArticleByTranslationSlug($slug, true);
        
        return compact('article');
    }
}
