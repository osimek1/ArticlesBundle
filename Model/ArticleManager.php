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
    protected $defaultLocale;


    public function __construct($em, $container, $defaultLocale)
    {
        $this->em = $em;
        $this->container = $container;
        $this->languages = $container->getParameter('osimek1.articles.languages');
        $this->repo = $this->em->getRepository('Osimek1ArticlesBundle:Article');
        $this->defaultLocale = $defaultLocale;
    }


    public function createArticle()
    {
        $article = new Article();
        foreach ($this->languages as $key => $value) {
            $artTranslation = new ArticleTranslation();
            $artTranslation->setArticle($article);
            $artTranslation->setLocale($key);
            $article->addTranslation($artTranslation);
        }
        
        $article = $this->translateArticle($article);
        
        return $article;
    }


    public function getOneArticleBy(
        array $criteria,
        array $orderBy = null,
        $locale = null,
        $repository = 'Osimek1ArticlesBundle:Article'
    ) {
        if (!isset($locale)) {
            $locale = $this->getCurrentLocale();
        }
        
        $qb = $this->em->getRepository($repository)->createQueryBuilder('a');
        $qb->select('a,t')
            ->innerJoin('a.translations', 't')
            ->where('t.locale = :locale')
            ->setParameter('locale', $locale);

        foreach ($criteria as $key => $value) {
            $qb->andWhere("a.$key = $value");
        }

        $art = $qb->getQuery()->getSingleResult();
        $art = $this->translateArticle($art, $locale);

        return $art;
    }


    protected function translateArticle($article, $locale = null)
    {
        if (!isset($locale)) {
            $locale = $this->getCurrentLocale();
        }

        if (isset($article)) {
            $article->translate($locale);
        }

        return $article;
    }


    protected function getCurrentLocale()
    {
        $locale = $this->container->get('session')->get('_locale');
        $locale = isset($locale) ? $locale : $this->defaultLocale;
        if(!array_key_exists($locale, $this->languages)){
            throw new \Exception("No translations found for locale: $locale");
        }
        
        return $locale;
    }


    public function getArticlesBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        $locale = null,
        $repository = 'Osimek1ArticlesBundle:Article'
    ) {
        if (!isset($locale)) {
            $locale = $this->getCurrentLocale();
        }

        $qb = $this->em->getRepository($repository)->createQueryBuilder('a');
        $qb->select('a,t')
            ->innerJoin('a.translations', 't')
            ->where('t.locale = :locale')
            ->setParameter('locale', $locale);

        foreach ($criteria as $key => $value) {
            $qb->andWhere("a.$key = :$key");
            $qb->setParameter("$key", $value);
        }

        foreach ($orderBy as $key => $value) {
            $qb->orderBy("a.$key", $value);
        }

        $articles = $qb->getQuery()->getResult();
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


    public function getArticleByTranslationSlug(
        $slug,
        $createNewIfNotFound = false,
        $repository = 'Osimek1ArticlesBundle:Article'
    ) {
        $qb = $this->em->getRepository($repository)->createQueryBuilder('a');
        $qb->select('a,t')
            ->innerJoin('a.translations', 't')
            ->where('t.slug = :slug')
            ->setParameter('slug', $slug);

        $article = $qb->getQuery()->getSingleResult();
        $locale = null;

        if ($article instanceof \Osimek1\ArticlesBundle\Entity\Article) {
            $locale = $article->getTranslations()->first()->getLocale();
        } elseif ($createNewIfNotFound) {
            $article = $this->createArticle();
        }

        $article = $this->translateArticle($article, $locale);
        
        return $article;
    }


    public function getArticleById(
        $id,
        $createNewIfNotFound = false,
        $repository = 'Osimek1ArticlesBundle:Article'
    ) {
        $article = $this->em
                ->getRepository($repository)
                ->createQueryBuilder('a')
                ->select('a,t')
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


    public function getAllChildrens($article, $repository = 'Osimek1ArticlesBundle:Article')
    {
        $qb = $this->em->getRepository($repository)->createQueryBuilder('a')->select('a,t');
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
