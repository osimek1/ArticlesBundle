<?php

namespace Osimek1\ArticlesBundle\Model;

/**
 * Basic Article Class  
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 */
class Article extends TranslatableArticle 
{
	/**
	 * @var integer
	 */
	protected $id;
	
	/**
	 * @var integer
	 */
	protected $left;
	
	/**
	 * @var integer
	 */
	protected $right;
	
	/**
	 * @var integer
	 */
	protected $level;
	
	/**
	 * @var integer
	 */
	protected $root;
	
	/**
	 * @var Article
	 */
	protected $parent;
	
	/**
	 * @var array[Article]
	 */
	protected $children;
	
	/**
	 * Returns id of article
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Returns parent of article
	 * @return Article
	 */
	public function getParent()	
	{
		return $this->parent;
	}
	
	public function setParent(Article $parent)
	{
		$this->parent = $parent;
	}
}
