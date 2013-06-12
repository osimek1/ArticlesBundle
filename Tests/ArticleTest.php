<?php
namespace Osimek1\ArticlesBundle\Tests;

use Osimek1\ArticlesBundle\Entity\Article;
use Osimek1\ArticlesBundle\Entity\ArticleTranslation;

class ArticleCase extends \PHPUnit_Framework_TestCase
{
    public function testArticlesSettersAndGettersWithoutDatabase()
    {
		$parent = new Article();
		$childrens = [];
		$childCount = 2;
		
		$parentValues = array(
			'title'=>'Parent tytu³',
			'shortDesc'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse cursus, elit at rhoncus placerat, arcu dui cursus tortor, eu lacinia orci nunc et odio. Nunc tincidunt metus nisl. Quisque nec suscipit nibh. Cras imperdiet sit amet odio ac euismod sed.',
			'content'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis neque at enim sagittis, id laoreet massa tincidunt. Integer eget iaculis nisi. Aenean nec neque id magna ullamcorper fermentum. Integer vehicula scelerisque felis eget aliquet. Cras quis ligula ut diam laoreet sodales eget vitae enim. Phasellus feugiat consequat orci, sed porta dui fringilla ut. Integer aliquam augue in massa lacinia, quis imperdiet eros commodo. Morbi at urna ornare enim convallis laoreet. Etiam in suscipit ante. Suspendisse porttitor, nulla sed elementum suscipit, metus nulla volutpat neque, ut eleifend enim ipsum non orci. Nam odio odio, pretium sit amet mauris et, tempus pellentesque dui.
				Donec id lorem quis ligula malesuada ultrices in id mauris. Nam accumsan libero et mattis posuere. Aliquam tempus risus non erat placerat ultrices. Phasellus orci neque, luctus vel elementum id, vulputate a justo. In a dolor ligula. Ut fermentum ut quam at mattis. Nunc posuere mauris sed tortor adipiscing, non euismod nisl interdum. Praesent urna lacus, blandit adipiscing vestibulum vel, lacinia a arcu. Quisque sed congue dolor, ut tincidunt magna. Cras pellentesque commodo lacus, faucibus semper nunc molestie dictum. Duis laoreet, odio ac sagittis facilisis, odio erat auctor leo, in semper erat enim eget arcu. Praesent placerat feugiat leo, eu molestie lacus accumsan eleifend. In tincidunt elit et diam posuere egestas. Nullam fringilla iaculis est, at venenatis lorem vestibulum a.
				Quisque tincidunt nunc erat, faucibus cursus sem consectetur nec. Vestibulum facilisis urna arcu, eget blandit enim dapibus et. Vestibulum vel eros non massa convallis venenatis a vitae dolor. Pellentesque eu dolor ac nulla laoreet viverra. Quisque sed dignissim lectus. Suspendisse quis placerat massa. Etiam at fermentum erat, sed ullamcorper justo. Maecenas faucibus nulla ultrices semper sollicitudin. Ut porttitor ut erat eget ullamcorper. Proin accumsan mi risus, eu vulputate purus scelerisque ac. Maecenas mollis, ipsum eget commodo pharetra, turpis ipsum sodales mauris, a venenatis augue arcu ut erat. Vivamus at posuere ipsum. Vestibulum sit amet lacinia diam. Morbi et metus vestibulum, commodo eros suscipit, bibendum neque.
				Etiam sapien dolor, condimentum sed feugiat ut, rutrum non est. Nullam viverra vel ante id fringilla. Pellentesque elementum ut libero quis mattis. Duis ullamcorper interdum convallis. Vivamus facilisis turpis massa, quis tempus libero dictum nec. Vestibulum mattis ante justo, eu adipiscing sapien volutpat et. Sed eu ornare nulla, et rhoncus lacus. Nullam molestie imperdiet feugiat. Nulla scelerisque eget diam vitae tempus. Nam in dignissim magna. Phasellus commodo mattis nisl, ornare hendrerit sapien mollis in.
				Vestibulum id velit sagittis quam consequat pretium. Vestibulum velit quam, varius ac facilisis at, elementum eu enim. Duis in condimentum elit. Donec pharetra non dui sed laoreet. Nunc non ipsum eget justo euismod bibendum. Maecenas dapibus elit nec lorem ultrices, id pretium mi blandit. Pellentesque facilisis vel nulla id vulputate. Nullam sagittis dapibus nisl, pulvinar suscipit sem varius et. Duis eu mollis nulla.',
		);
		
		$childrensValues = array(
			'title'=>'Parent tytu³',
			'shortDesc'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse cursus, elit at rhoncus placerat, arcu dui cursus tortor, eu lacinia orci nunc et odio. Nunc tincidunt metus nisl. Quisque nec suscipit nibh. Cras imperdiet sit amet odio ac euismod sed.',
			'content'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis neque at enim sagittis, id laoreet massa tincidunt. Integer eget iaculis nisi. Aenean nec neque id magna ullamcorper fermentum. Integer vehicula scelerisque felis eget aliquet. Cras quis ligula ut diam laoreet sodales eget vitae enim. Phasellus feugiat consequat orci, sed porta dui fringilla ut. Integer aliquam augue in massa lacinia, quis imperdiet eros commodo. Morbi at urna ornare enim convallis laoreet. Etiam in suscipit ante. Suspendisse porttitor, nulla sed elementum suscipit, metus nulla volutpat neque, ut eleifend enim ipsum non orci. Nam odio odio, pretium sit amet mauris et, tempus pellentesque dui.
				Donec id lorem quis ligula malesuada ultrices in id mauris. Nam accumsan libero et mattis posuere. Aliquam tempus risus non erat placerat ultrices. Phasellus orci neque, luctus vel elementum id, vulputate a justo. In a dolor ligula. Ut fermentum ut quam at mattis. Nunc posuere mauris sed tortor adipiscing, non euismod nisl interdum. Praesent urna lacus, blandit adipiscing vestibulum vel, lacinia a arcu. Quisque sed congue dolor, ut tincidunt magna. Cras pellentesque commodo lacus, faucibus semper nunc molestie dictum. Duis laoreet, odio ac sagittis facilisis, odio erat auctor leo, in semper erat enim eget arcu. Praesent placerat feugiat leo, eu molestie lacus accumsan eleifend. In tincidunt elit et diam posuere egestas. Nullam fringilla iaculis est, at venenatis lorem vestibulum a.
				Quisque tincidunt nunc erat, faucibus cursus sem consectetur nec. Vestibulum facilisis urna arcu, eget blandit enim dapibus et. Vestibulum vel eros non massa convallis venenatis a vitae dolor. Pellentesque eu dolor ac nulla laoreet viverra. Quisque sed dignissim lectus. Suspendisse quis placerat massa. Etiam at fermentum erat, sed ullamcorper justo. Maecenas faucibus nulla ultrices semper sollicitudin. Ut porttitor ut erat eget ullamcorper. Proin accumsan mi risus, eu vulputate purus scelerisque ac. Maecenas mollis, ipsum eget commodo pharetra, turpis ipsum sodales mauris, a venenatis augue arcu ut erat. Vivamus at posuere ipsum. Vestibulum sit amet lacinia diam. Morbi et metus vestibulum, commodo eros suscipit, bibendum neque.
				Etiam sapien dolor, condimentum sed feugiat ut, rutrum non est. Nullam viverra vel ante id fringilla. Pellentesque elementum ut libero quis mattis. Duis ullamcorper interdum convallis. Vivamus facilisis turpis massa, quis tempus libero dictum nec. Vestibulum mattis ante justo, eu adipiscing sapien volutpat et. Sed eu ornare nulla, et rhoncus lacus. Nullam molestie imperdiet feugiat. Nulla scelerisque eget diam vitae tempus. Nam in dignissim magna. Phasellus commodo mattis nisl, ornare hendrerit sapien mollis in.
				Vestibulum id velit sagittis quam consequat pretium. Vestibulum velit quam, varius ac facilisis at, elementum eu enim. Duis in condimentum elit. Donec pharetra non dui sed laoreet. Nunc non ipsum eget justo euismod bibendum. Maecenas dapibus elit nec lorem ultrices, id pretium mi blandit. Pellentesque facilisis vel nulla id vulputate. Nullam sagittis dapibus nisl, pulvinar suscipit sem varius et. Duis eu mollis nulla.',
		);
		
		$parent->setTitle($parentValues['title']);
		$parent->setShortDesc($parentValues['shortDesc']);
		$parent->setArticleContent($parentValues['content']);
				
		$this->assertEquals($parent->getTitle(), $parentValues['title']);
		$this->assertEquals($parent->getShortDesc(), $parentValues['shortDesc']);
		$this->assertEquals($parent->getArticleContent(), $parentValues['content']);
		
		for ($i = 0; $i < $childCount; $i = $i +1){
			$childrens[$i] = new Article();
			$childrens[$i]->setTitle($childrensValues['title']);
			$childrens[$i]->setShortDesc($childrensValues['shortDesc']);
			$childrens[$i]->setArticleContent($childrensValues['content']);
			$childrens[$i]->setParent($parent);
		}
		
		for ($i = 0; $i < $childCount; $i = $i +1){
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