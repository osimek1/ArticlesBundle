<?php

namespace Osimek1\ArticlesBundle\Entity;

//use Osimek1\ArticlesBundle\Model\ArticleInterface;
use Osimek1\ArticlesBundle\Model\ArticleTranslationInterface;
use Osimek1\ArticlesBundle\Model\TranslatedArticleInterface;
use Osimek1\ArticlesBundle\Model\TimestampableArticle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Translatet article class
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 * @ORM\Entity()
 * @ORM\Table()
 */
class Article extends TimestampableArticle implements TranslatedArticleInterface 
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
     * @ORM\OneToMany(targetEntity="ArticleTranslation", mappedBy="article")
     */
    protected $translations;

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
    public function addTranslation(ArticleTranslationInterface $translation)
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
    
    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getShortDesc()
    {
        return $this->shortDesc;
    }

    /**
     * {@inheritDoc}
     */
    public function getArticleContent()
    {
        return $this->articleContent;
    }
    
    /**
     * @param string $title
     *
     * @return ArticleInterface
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $shortDesc
     *
     * @return ArticleInterface
     */
    public function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;
        return $this;
    }

    /**
     * @param string $articleContent
     *
     * @return ArticleInterface
     */
    public function setArticleContent($articleContent)
    {
        $this->articleContent = $articleContent;
        return $this;
    }
}
