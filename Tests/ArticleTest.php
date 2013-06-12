<?php
namespace Osimek1\ArticlesBundle\Tests;

use Osimek1\ArticlesBundle\Entity\Article;
use Osimek1\ArticlesBundle\Entity\ArticleTranslation;

class ArticleCase extends \PHPUnit_Framework_TestCase
{
    public function testArticlesSettersAndGettersWithoutDatabase()
    {
        $parent = new Article();
        $childrens = array();
        $childCount = 2;

        $parentValues = array(
            'title'=>'Parent tytuł',
            'shortDesc'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Suspendisse cursus, elit at rhoncus placerat, arcu dui cursus tortor,
            eu lacinia orci nunc et odio. Nunc tincidunt metus nisl.
            Quisque nec suscipit nibh. Cras imperdiet sit amet odio ac euismod sed.',
            'content'=>file_get_contents(__DIR__.'/Addons/content.txt')
        );
        
        $childrensValues = array(
            'title'=>'Parent tytuł',
            'shortDesc'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Suspendisse cursus, elit at rhoncus placerat, arcu dui cursus tortor,
            eu lacinia orci nunc et odio. Nunc tincidunt metus nisl.
            Quisque nec suscipit nibh. Cras imperdiet sit amet odio ac euismod sed.',
            'content'=>file_get_contents(__DIR__.'/Addons/content.txt')
        );

        $parent->setTitle($parentValues['title']);
        $parent->setShortDesc($parentValues['shortDesc']);
        $parent->setArticleContent($parentValues['content']);

        $this->assertEquals($parent->getTitle(), $parentValues['title']);
        $this->assertEquals($parent->getShortDesc(), $parentValues['shortDesc']);
        $this->assertEquals($parent->getArticleContent(), $parentValues['content']);

        for ($i = 0; $i < $childCount; $i = $i +1) {
            $childrens[$i] = new Article();
            $childrens[$i]->setTitle($childrensValues['title']);
            $childrens[$i]->setShortDesc($childrensValues['shortDesc']);
            $childrens[$i]->setArticleContent($childrensValues['content']);
            $childrens[$i]->setParent($parent);
        }

        for ($i = 0; $i < $childCount; $i = $i +1) {
            $this->assertEquals($childrens[$i]->getTitle(), $childrensValues['title']);
            $this->assertEquals($childrens[$i]->getShortDesc(), $childrensValues['shortDesc']);
            $this->assertEquals($childrens[$i]->getArticleContent(), $childrensValues['content']);
            $this->assertEquals($childrens[$i]->getParent(), $parent);
        }
    }

    public function testArticlesSettersAndGettersWithDatabase()
    {
    }

    public function testSlugArticle()
    {
    }

    public function testNestedSet()
    {
    }
}
