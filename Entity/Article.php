<?php
namespace Osimek1\ArticlesBundle\Entity;

use Osimek1\ArticlesBundle\Model\ArticleTranslationInterface;
use Osimek1\ArticlesBundle\Model\TranslatedArticleInterface;
use Osimek1\ArticlesBundle\Model\TimestampableArticle;
use Osimek1\ArticlesBundle\Model\NestedObjectInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Translated article class
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table()
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
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
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer", name="lft")
     */
    protected $left;

    /**
     * @var integer
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer", name="rgt")
     */
    protected $right;

    /**
     * @var integer
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer", name="lvl")
     */
    protected $level;

    /**
     * @var integer
     * @Gedmo\TreeRoot
     * @ORM\Column(type="integer")
     */
    protected $root;

    /**
     * @var Article
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Osimek1\ArticlesBundle\Entity\Article",  inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $parent;

    /**
     * @var array[Article]
     * @ORM\OneToMany(targetEntity="Osimek1\ArticlesBundle\Entity\Article", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     */
    protected $children;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Osimek1\ArticlesBundle\Entity\ArticleTranslation",
                      mappedBy="article", cascade={"all"})
     */
    protected $translations;

    /**
     * @var string
     * @Assert\NotNull()
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
     * @var string
     * @Assert\NotNull()
     */
    protected $slug;


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
        if (isset($this->translations[$locale])) {
            return $this->translations[$locale];
        } else {
            foreach ($this->translations as $key => $value) {
                if ($value->getLocale() === $locale) {
                    return $value;
                }
            }
            $artTranslation = new ArticleTranslation();
            $artTranslation->setArticle($this);
            $artTranslation->setLocale($locale);
            $this->addTranslation($artTranslation);
            
            return $artTranslation;
        }
        return  null;
    }


    public function translate($locale)
    {
        $translation = $this->getTranslation($locale);
        
        if ($translation->getTitle() === null) {
            foreach ($this->translations as $tmpTranslation) {
                if ($tmpTranslation->getTitle() !== null) {
                    $translation = $tmpTranslation;
                    break;
                }
            }
            
            if ($translation->getTitle() === null) {
                return false;
            }
        }
        $this->title = $translation->getTitle();
        $this->shortDesc = $translation->getShortDesc();
        $this->slug = $translation->getSlug();
        $this->articleContent = $translation->getArticleContent();
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
     * Returns id of article
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return integer
     */
    public function getLeft()
    {
        return $this->left;
    }


    /**
     * @return integer
     */
    public function getRight()
    {
        return $this->right;
    }


    public function getRoot()
    {
        return $this->root;
    }


    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
