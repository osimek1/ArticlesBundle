<?php
namespace Osimek1\ArticlesBundle\Twig\Extension;

use Symfony\Component\Translation\Translator;

use Twig_Extension;
use Twig_Filter_Method;

/**
 * @author Dawid Królak [taavit@gmail.com]
 *
 */
class LanguageExtension extends Twig_Extension
{
    protected $languages;
    public function __construct($languages)
    {
        $this->languages = $languages;
    }

    public function getGlobals()
    {
        return array('languages' => $this->languages);
    }
    public function getName()
    {
        return 'language_extension';
    }
}
