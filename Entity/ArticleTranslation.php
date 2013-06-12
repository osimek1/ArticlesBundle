<?php

namespace Osimek1\ArticlesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Osimek1\ArticlesBundle\Model\BaseArticle;

/**
 * Article translation class
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 * @ORM\Entity()
 * @ORM\Table()
 */
class ArticleTranslation extends BaseArticle
{
	/**
	 * @var integer
	 * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	protected $id;
	
	/**
	 * @var string
	 * @ORM\Column(type="string", length=5)
	 */
	protected $locale;
	
	public function getLocale()
	{
		return $this->locale;
	}
	
	public function setLocale($locale)
	{
		$this->locale = $locale;
	}
}