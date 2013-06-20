<?php
namespace Osimek1\ArticlesBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CreateArticleCommand extends ContainerAwareCommand
{
    protected $titles = array();
    
    protected function configure()
    {
        $this
            ->setName('osimek1:articles:create')
            ->setDescription(
                'Create new article'
            );
            //->addArgument('titles', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Array of article titles.');
    }
    
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();  
        $manager = $container->get('osimek1.articles.manager');
        
        $languages = $container->getParameter('osimek1.articles.languages');
        $article = $manager->createArticle();
        foreach ($languages as $key => $value) {
            if (!isset($this->titles[$key])) {
                throw new \Exception("$value title can not be empty");
            }
            $article->getTranslation($key)->setTitle($this->titles[$key]);
        }
        $manager->save($article);
    }
    
    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $languages = $this->getContainer()->getParameter('osimek1.articles.languages');
        foreach ($languages as $key => $value) {
            $title = $this->getHelper('dialog')->askAndValidate(
                $output,
                "Please enter title for $value language:",
                function($title) {
                    if (empty($title)) {
                        throw new \Exception('Title can not be empty');
                    }
    
                    return $title;
                }
            );
            $this->titles[$key] = $title;
        }
    }
}
