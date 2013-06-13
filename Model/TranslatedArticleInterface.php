<?php

namespace Osimek1\ArticlesBundle\Model;

interface TranslatedArticleInterface extends ArticleInterface
{
    /**
     * @return string
     */
    public function getTranslations();
    
    /**
     * @param ArticleTranslationInterface $tanslation
     *
     * @return TranslatableArticle
     */
    public function addTranslation(ArticleTranslationInterface $tanslation);
    
    /**
     * @param string $locale
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getTranslation($locale);
    
     /**
     * {@inheritDoc}
     */
    public function getCreatedAt();
    
    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt();
}
