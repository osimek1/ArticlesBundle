<?php

namespace Osimek1\ArticlesBundle\Model;

class ArticleTranslation extends TranslatableArticle
{
	/**
	 * @var integer
	 */
	protected $id;
	
	/**
	 * @var string
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