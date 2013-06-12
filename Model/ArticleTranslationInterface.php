<?php

namespace Osimek1\ArticlesBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article translation class
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 */
class ArticleTranslationInterface extends TranslatedArticleInterface
{
    abstract public function getLocale();

    abstract public function setLocale($locale);
}
