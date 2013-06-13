<?php
namespace Osimek1\ArticlesBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article translation class
 *
 * @author Grzegorz Osimowicz <osimek1@gmail.com>
 */
interface ArticleTranslationInterface
{
    public function getLocale();

    public function setLocale($locale);
}
