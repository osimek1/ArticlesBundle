<?php

namespace Osimek1\ArticlesBundle\Tests;

require_once dirname(__DIR__).'/../../../../../app/AppKernel.php';

use Osimek1\ArticlesBundle\Entity\Article;
use Osimek1\ArticlesBundle\Entity\ArticleTranslation;
use Osimek1\ArticlesBundle\Model\ArticleManager;


class ArticleManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    
    public function testCreateArticle()
    {
        /** @var Osimek1\ArticlesBundle\Model\ArticleManager **/
        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $languages = array('en'=>'English');   
        $manager = new ArticleManager($entityManager, $languages);
        
        $article = $manager->createArticle();
        $this->assertTrue(is_object($article));
        foreach ($languages as $key=>$value) {            
            $this->assertTrue(is_object($article->getTranslation($key)));
        }
        
        $manager->save($article);
    }
}
