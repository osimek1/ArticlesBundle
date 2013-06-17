<?php
namespace Osimek1\ArticlesBundle\Model;

use Osimek1\ArticlesBundle\Entity\Article;
use Osimek1\ArticlesBundle\Entity\ArticleTranslation;

class ArticleManager
{
    protected $em;
    protected $languages;
    protected $container;
    protected $repo;
    public function __construct($em, $languages, $container)
    {
        $this->em = $em;
        $this->languages = $languages;
        $this->container = $container;
        $this->repo = $this->em->getRepository('Osimek1ArticlesBundle:Article');
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
        
        $article = $this->translateArticle($article);
        
        return $article;
    }
    
    
    public function getOneArticleBy(array $criteria, array $orderBy = null, $locale = null)
    {
        if(!isset($locale)){
            $locale = $this->getCurrentLocale();
        }
        $qb = $this->em->getRepository('Osimek1ArticlesBundle:Article')->createQueryBuilder('a');
        $qb->innerJoin('a.translations', 't')
            ->where('t.locale = :locale')
            ->setParameter('locale', $locale);
            
        foreach ($criteria as $key => $value) {
            $qb->andWhere("a.$key = $value");
        }
        
        $art = $qb->getQuery()->getSingleResult();
        
        $art = $this->translateArticle($art, $locale);
        
        return $art;
    }
    
    protected function translateArticle($article, $locale=null)
    {
        if(!isset($locale)){
            $locale = $this->getCurrentLocale();            
        }
        
        if (isset($article)){
            $article->translate($locale);
        }
        
        return $article;
    }
    
    protected function getCurrentLocale()
    {
        $locale = $this->container->get('session')->get('_locale');
        $locale = isset($locale) ? $locale : "en";
        
        return $locale;
    }
    
    public function getArticlesBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $locale=null)
    {
        if(!isset($locale)){
            $locale = $this->getCurrentLocale();            
        }
        $qb = $this->em->getRepository('Osimek1ArticlesBundle:Article')->createQueryBuilder('a');
        $qb->innerJoin('a.translations', 't')
            ->where('t.locale = :locale')
            ->setParameter('locale', $locale);

        $articles = $qb->getQuery()->getResults();
        foreach ($articles as $key => $article) {
            $articles[$key] = $this->translateArticle($article);
        }
                                
        return $articles;
    }
    
    public function save(ArticleInterface $article)
    {
        $this->em->persist($article);
        $this->em->flush();
    }
    
	public function getArticleByTranslationSlug($slug, $createNewIfNotFound = false)
	{
		$qb = $this->em->getRepository('Osimek1ArticlesBundle:Article')->createQueryBuilder('a');
		$qb->innerJoin('a.translations', 't')
			->where('t.slug = :slug')
			->setParameter('slug', $slug);
        $article = $qb->getQuery()->getSingleResult();
        if ($createNewIfNotFound && ! $article instanceof Osimek1\ArticlesBundle\Entity\Article) {
            $article = $this->createArticle();
        }
        
        $article = $this->translateArticle($article);
        
		return $article;
	}
    
    public function getArticleById($id, $createNewIfNotFound = false)
    {
        $article = $this->em
                ->getRepository('Osimek1ArticlesBundle:Article')
                ->createQueryBuilder('a')
                ->innerJoin('a.translations', 't')
                ->where('t.locale = :locale')
                ->andWhere('a.id = :id')
                ->setParameter('locale', $this->getCurrentLocale())
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();
        if ($createNewIfNotFound && ! $article instanceof Osimek1\ArticlesBundle\Entity\Article) {
            $article = $this->createArticle();
        }
        
        $article = $this->translateArticle($article);
         
        return $article;
    }
    
    public function removeArticle(Article $article)
    {
//        $this->em->remove($article);
        $art = $this->repo->findOneBy(array('id'=>$article->getId()));
        $this->repo->removeFromTree($art);
        $this->em->clear();
    }
    
    public function removeArticleById($id)
    {
        $this->em->remove($this->getArticleById($id));
        $this->em->clear();
        $this->em->flush();
        
    }
    
    public function getAllChildrens($article)
    {
        $qb = $this->em->getRepository('Osimek1ArticlesBundle:Article')->createQueryBuilder('a');
        $qb->where('a.left > :left')
            ->andWhere('a.right < :right')
            ->andWhere('a.root = :root')
            ->orderBy('a.left', 'ASC')
            ->setParameter('left', $article->getLeft())
            ->setParameter('right', $article->getRight())
            ->setParameter('root', $article->getRoot());
            
        $articles = $qb->getQuery()->getResults();
        foreach ($articles as $key => $article) {
            $articles[$key] = $this->translateArticle($article);
        }
        return $articles;
    }        
}
