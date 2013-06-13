<?php
namespace Osimek1\ArticlesBundle\Model;

use Osimek1\ArticlesBundle\Entity\Article;
use Osimek1\ArticlesBundle\Entity\ArticleTranslation;

class ArticleManager
{
    protected $em;
    protected $languages;
    public function __construct($em, $languages)
    {
        $this->em = $em;
        $this->languages = $languages;
    }  
    
    public function createArticle()
    {
        $article = new Article();
        foreach ($this->languages as $key=>$value) {
            $artTranslation = new ArticleTranslation();
            $artTranslation->setArticle($article);
            $artTranslation->setLocale($key);
            $article->addTranslation($artTranslation);
        }
        
        return $article;
    }
    
    public function save(ArticleInterface $article)
    {
        $this->em->persist($article);
        $this->em->flush();
    }
	
	public function getArticleByTranslationSlug($slug)
	{
		$qb = $this->em->getRepository('Osimek1ArticlesBundle:Article')->createQueryBuilder('a');
		$qb->innerJoin('a.translations', 't')
			->where('t.slug = :slug')
			->setParameter('slug', $slug);
			
		return $qb->getQuery()->getResult();
	}
}
