<?php

namespace PlanckeyBlogPublic\Controller;



use Planck\Controller;
use PlanckeyBlogPublic\Router;

class Tag extends Controller
{


    public function render($tagSlug)
    {



        $tag = $this->getApplication()->getModelEntity(\Planck\Extension\RichTag\Model\Entity\Tag::class);
        $tag->loadBy('slug', $tagSlug);

        $articles = $tag->getAssociatedEntities(\Planck\Extension\Content\Model\Entity\Article::class);



        foreach ($articles as $article) {

            $router = $this->getApplication()->getRouter(Router::class);
            $url = $router->getRouteByName('article')->buildURL(array($article->getId()));

            $article->setValue(
                'url',
                $url
            );
        }


        $layout = $this->getApplication()->getTheme()->getLayout('Home');
        $layout->setVariable('articles', $articles);


        $component = new \Planck\Theme\Yummy\Component\About();

        $sideBar = $layout->getSideBar();


        $sideBar->getDom()->find('.top')->html($component);





        return $layout->render();
    }

}


