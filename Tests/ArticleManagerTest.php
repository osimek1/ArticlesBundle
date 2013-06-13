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
	
    public function setUp()
    {
		static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
        parent::setUp();
    }
    
    public function testCreateArticle()
    {
        /** @var Osimek1\ArticlesBundle\Model\ArticleManager **/
        $entityManager = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $languages = array('en'=>'English');   
        $manager = new ArticleManager($this->em, $languages);
        
		$content = '';		
		
        $article = $manager->createArticle();		
        $this->assertTrue(is_object($article));
		
		$translation = $article->getTranslation('en');
		$translation->setTitle("English article");
		
        $translation = $article->getTranslation('pl');
        $translation->setTitle("Artykuł");
		$text = $this->generateRandomPolishText(255);
		$translation->setShortDesc($text);
		
        $manager->save($article);
		
		$articleFromDB = $manager->getArticleByTranslationSlug('artykul');
		$this->assertTrue(is_object($articleFromDB));
    }
	
	protected function generateRandomPolishText($textLength)
	{
		//$alphabet = 'aąbcćdeęfg hijklłmnńoóp qrsśtuvwxyźAĄB CĆDEĘFGHIJKLŁ MNŃOÓPQR SŚTUVWXYŹ12345678';
		$alphabet = 'qwertyuiopasdfghjklzxcvbnm QWERTYUIOPASDFGHJKLMNBVCXZ';
		$maxRand = strlen($alphabet) - 1;
		$text = '';
		for ($i=0; $i<$textLength; $i++){
			$text = $text . substr($alphabet, rand(0,$maxRand), 1);
		}
		return $text;
	}
}
