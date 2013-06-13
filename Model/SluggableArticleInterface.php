<?php

namespace Osimek1\ArticlesBundle\Model;

interface SluggableArticleInterface {
    /**
     * @return string
     */
    public function getSlug();
}
