<?php

namespace Osimek1\ArticlesBundle\Entity;

use Osimek1\ArticlesBundle\Model\BaseArticle;
use Osimek1\ArticlesBundle\Model\ArticleTranslationInterface;
use Osimek1\ArticlesBundle\Model\TranslatedArticleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Translatet article class
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 * @ORM\Entity()
 * @ORM\Table()
 */
class Article extends BaseArticle implements TranslatedArticleInterface
{
    /**
     * @var integer
     * @var id integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="lft")
     */
    protected $left;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="rgt")
     */
    protected $right;

    /**
     * @var integer
     * @ORM\Column(type="integer", name="lvl")
     */
    protected $level;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $root;

    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="Article")
     */
    protected $parent;

    /**
     * @var array[Article]
     * @ORM\OneToMany(targetEntity="Article", mappedBy="parent")
     */
    protected $children;

    /**
     * @var ArrayCollection
     * @ORM\ManyToOne(targetEntity="ArticleTranslation")
     */
    protected $translations;

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

    /**
     * @return 
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * {@inheritDoc}
     */
    public function addTranslation(ArticleTranslationInterface $tanslation)
    {
        $this->translations[$translation->getLocale()] = $translation;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTranslation($locale)
    {
        return $this->translations[$locale];
    }
}
