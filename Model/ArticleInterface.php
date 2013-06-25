<?php
namespace Osimek1\ArticlesBundle\Model;

interface ArticleInterface
{
    /**
     * @return string
     */
    public function getTitle();
    
    /**
     * @return string
     */
    public function getShortDesc();

    /**
     * @return string
     */
    public function getArticleContent();

    /**
     * @param string $title
     *
     * @return ArticleInterface
     */
    public function setTitle($title);

    /**
     * @param string $shortDesc
     *
     * @return ArticleInterface
     */
    public function setShortDesc($shortDesc);

    /**
     * @param string $articleContent
     *
     * @return ArticleInterface
     */
    public function setArticleContent($articleContent);
}
