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
		return $article;
	}
    
    public function getArticleById($id, $createNewIfNotFound = false)
    {
        $article = $this->em->getRepository('Osimek1ArticlesBundle:Article')->findOneBy(array('id'=>$id));
        if ($createNewIfNotFound && ! $article instanceof Osimek1\ArticlesBundle\Entity\Article) {
            $article = $this->createArticle();
        } 
        return $article;
    }
    
    public function removeArticle(Article $article)
    {
        $this->em->remove($article);
        $this->em->flush();
    }
    
    public function removeArticleById($id)
    {
        $this->em->remove($this->getArticleById($id));
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
        return $qb->getQuery()->getResult();
    }        
}
