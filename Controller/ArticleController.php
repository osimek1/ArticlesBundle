<?php
namespace Osimek1\ArticlesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
    
    /**
     * @Method({"GET"})
     */
    public function getArticleRestAction($slug)
    {
        $article = $this->get('osimek1.articles.manager')->getArticleByTranslationSlug($slug, true);
        
        return new JsonResponse(array(
            'title' => $article->getTitle(),
            'shortDesc' => $article->getShortDesc(),
            'slug' => $article->getSlug(),
            'content' => $article->getArticleContent()
        ));
    }
}
