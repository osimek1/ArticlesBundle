<?php
namespace Osimek1\ArticlesBundle\Tests;

use Osimek1\ArticlesBundle\Entity\Article;
use Osimek1\ArticlesBundle\Entity\ArticleTranslation;
use Osimek1\ArticlesBundle\Model\ArticleManager;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleManagerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var Osimek1\ArticlesBundle\Model\ArticleManager
     */
    private $manager;

    /**
     * @var array
     */
    private $languages;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
            
        $this->languages = array('en'=>'English', 'pl'=>'Polski');
        $this->manager = new ArticleManager($this->em, $this->languages, static::$kernel->getContainer());
        parent::setUp();
    }

    public function testCreateArticle()
    {
        $article = $this->createArticle();

        $this->manager->save($article);

        $articleFromDB = $this->manager->getArticleByTranslationSlug($article->getTranslation('pl')->getSlug());
        $this->assertTrue(is_object($articleFromDB));

        foreach ($this->languages as $key => $value) {
            $translation = $articleFromDB->getTranslation($key);
            $this->assertTrue(is_object($translation));
            $this->assertTrue($translation->getTitle() === $value);
        }

        $translation = $articleFromDB->getTranslation('unknown');
        $this->assertTrue(is_object($translation));

    }

    protected function generateRandomPolishText($textLength)
    {
        $alphabet = 'aąbcćde ęfghijkl łmnoóprs śtuvwxyźż AĄBCĆDE ĘFGHIJKL ŁMNOÓPRS ŚTUVWXYŹ 1234567890';
        $maxRand = strlen($alphabet) - 1;
        $text = '';
        for ($i=0; $i<$textLength; $i++) {
            $text = $text . mb_substr($alphabet, rand(0, $maxRand), 1, 'UTF-8');
        }
        return $alphabet;
    }

    protected function createArticle($shortDescLength = 255, $contentLength = 500)
    {
        $article = $this->manager->createArticle();

        foreach ($this->languages as $key => $value) {
            $translation = $article->getTranslation($key);
            $translation->setTitle($value);
            $translation->setShortDesc($this->generateRandomPolishText($shortDescLength));
            $translation->setArticleContent($this->generateRandomPolishText($contentLength));
        }
        return $article;
    }

    public function testSimpleDelete()
    {
        $article = $this->createArticle();
        $this->manager->save($article);
        $this->manager->removeArticleById($article->getId());

        $article = $this->createArticle();
        $this->manager->save($article);
        $this->manager->removeArticle($article);
    }

    public function testLanguages()
    {
        $client = static::createClient();

        $article = $this->createArticle();
        $this->manager->save($article);
        $article = $this->manager->getArticleById($article->getId());

        $this->assertTrue($article->getTranslation('en')->getTitle()==="English");
        $this->assertTrue($article->getTranslation('en')->getTitle()===$article->getTitle());
    }


    public function testDelete()
    {
        $article = $this->createArticle();
        $this->manager->save($article);
        $this->manager->removeArticleById($article->getId());

        $parent = $this->createArticle();
        $root = $parent;
        $this->manager->save($parent);
        $childrens = array();
        $childCount = 10;
        $child = null;
        for ($i=0; $i<$childCount; $i++) {
            $child = $this->createArticle();
            $child->setParent($parent);
            if ($i%2 === 0 && $i !== 0) {
                $parent = $child;
            }
            $childrens[] = $child;
        }

        foreach ($childrens as $value) {
            $this->manager->save($value);
        }
        $this->manager->removeArticle($parent);
        for ($i=0; $i<$childCount; $i++) {
            if ($i%2 === 0) {
                $this->manager->removeArticle($childrens[$i]);
            }
        }
    }

    public function testNestedSetOfArticles()
    {
        $parent = $this->createArticle();
        $root = $parent;
        $this->manager->save($parent);
        $childrens = array();
        $childCount = 10;
        $child = null;
        for ($i=0; $i<$childCount; $i++) {
            $child = $this->createArticle();
            $child->setParent($parent);
            if ($i%2 === 0 && $i !== 0) {
                $parent = $child;
            }
            $childrens[] = $child;
        }

        foreach ($childrens as $value) {
            $this->manager->save($value);
        }

        $rootId = $root->getId();
        $root = $this->manager->getArticleById($rootId);

        $rootChildrens = $this->manager->getAllChildrens($root);
        $this->assertTrue(count($rootChildrens) === $childCount);

        $parent = $root;
        for ($i=0; $i<$childCount; $i++) {
            $this->assertTrue($rootChildrens[$i]->getRoot() === $rootId);
            $this->assertTrue($rootChildrens[$i]->getParent()->getId() === $parent->getId());
            if ($i%2 === 0 && $i !== 0) {
                $parent = $rootChildrens[$i];
            }
        }
    }

    public function testNestedSetLefts()
    {
        $qb = $this->em->getRepository('Osimek1ArticlesBundle:Article')->createQueryBuilder('a');
        $qb->select('a.left, a.right, a.root, a.id')->orderBy('a.root, a.left', 'ASC');
        $results = $qb->getQuery()->getResult();
        $resultsCount = count($results);

        $roots = array();
        $rootId = null;
        for ($i=0; $i<$resultsCount; $i = $i+1) {
            $rootId = $results[$i]['root'];
            if (!isset($roots[$rootId])) {
                $roots[$rootId] = array('left'=>array(),'right'=>array(), 'allNumbers'=>array());
            }
            $this->assertTrue(!isset($roots[$rootId]['left'][$results[$i]['left']]));
            $roots[$rootId]['left'][$results[$i]['left']] = 1;
            $this->assertTrue(!isset($roots[$rootId]['right'][$results[$i]['right']]));
            $roots[$rootId]['right'][$results[$i]['right']] = 1;
            $roots[$rootId]['allNumbers'][$results[$i]['left']] = 1;
            $roots[$rootId]['allNumbers'][$results[$i]['right']] = 1;
        }

        foreach ($roots as $key => $value) {
            ksort($roots[$key]['allNumbers']);
            $i = 1;
            foreach ($roots[$key]['allNumbers'] as $key => $value) {
                $this->assertTrue($i == $key);
                $i = $i + 1;
            }
        }
    }
}
