<?php
namespace Osimek1\ArticlesBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Abstract class of base article
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 */
abstract class BaseArticle implements ArticleInterface
{
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     * @Assert\NotNull()
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    protected $shortDesc;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $articleContent;


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
        return $this->shortDesc;
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
        return $this->articleContent;
    }
    

    /**
     * {@inheritDoc}
     */
    public function setArticleContent($articleContent)
    {
        $this->articleContent = $articleContent;
        return $this;
    }
}
