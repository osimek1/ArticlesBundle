<?php

namespace Osimek1\ArticlesBundle\Model;

use Doctrine\Common\Collections\ArrayCollection

/**
 * Abstract class of translatable article
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 */
abstract class TranslatableArticle implements ArticleInterface
{
	/**
	 * @var string
	 */
	protected $title;
	
	/**
	 * @var string
	 */
	protected $shortDesc;
	
	/**
	 * @var string
	 */
	protected $articleContent;
	
	/**
	 * @var ArrayCollection
	 */
	protected $translations;
	
	/**
     * {@inheritDoc}
     */
	public function getTitle()
	{
		$this->title;
	}
	
	/**
     * {@inheritDoc}
     */
	public function setTitle($title)
	{
		$this->title = $title;
		
		return $this;
	}
	
	/**
     * {@inheritDoc}
     */
	public function getShortDesc()
	{
		$this->shortDesc;
	}
	
	/**
     * {@inheritDoc}
     */
	public function setShortDesc($shortDesc)
	{
		$this->shortDesc = $shortDesc;
		
		return $this;
	}
	
	/**
     * {@inheritDoc}
     */
	public function getArticleContent()
	{
		$this->articleContent;
	}
	
	/**
     * {@inheritDoc}
     */
	public function setArticleContent($articleContent)
	{
		$this->articleContent = $articleContent;
		
		return $this;
	}
	
	/**
	 * @return 
	 */
	public function getTranslations()
	{
		return this->translations;
	}
	
	/**
	 * @param ArticleTranslation $tanslation
	 *
	 * @return TranslatableArticle
	 */
	public function addTranslation(ArticleTranslation $tanslation)
	{
		$this->translations[$translation->getLocale()] = $translation;
		
		return $this;
	}
	
	/**
	 * @param string $locale
	 * @return ArticleTranslation
	 */
	public function getAtranslation($locale)
	{
		return $this->translations[$locale];
	}
}
