<?php
namespace Osimek1\ArticlesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Osimek1\ArticlesBundle\Model\BaseArticle;
use Osimek1\ArticlesBundle\Model\ArticleTranslationInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Article translation class
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 * @ORM\Entity()
 * @ORM\Table()
 */
class ArticleTranslation extends BaseArticle implements ArticleTranslationInterface
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

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
	 * @Gedmo\Slug(fields={"title"})
     */
    protected $slug;

    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="Osimek1\ArticlesBundle\Entity\Article", cascade={"all"})
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    protected $article;
	
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }
    
    /**
     * @param $string
     * 
     * @return ArticleTranslation
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
    
    public function setArticle(Article $article)
    {
        $this->article = $article;
        return $this;
    }
    
    public function getArticle()
    {
        return $this->article;
    }
}
