<?php

namespace PlanckeyBlogPublic\Controller;



use Planck\Controller;
use PlanckeyBlogPublic\Router;

class Home extends Controller
{


    public function render()
    {



        $repository = $this->getApplication()->getModelRepository(\Planck\Extension\Content\Model\Repository\Article::class);


        $articles = $repository->getLasts(10);

        foreach ($articles as $article) {

            $router = $this->getApplication()->getRouter(Router::class);
            $url = $router->getRouteByName('article')->buildURL(array($article->getId()));

            $article->setValue(
                'url',
                $url
            );
        }


        //$layout = new \Planck\Theme\Yummy\Layout\Home($this->getApplication());

        $layout = $this->getApplication()->getTheme()->getLayout('Home');

        $layout->setVariable('articles', $articles);


        $component = new \Planck\Theme\Yummy\Component\About();

        $sideBar = $layout->getSideBar();


        $sideBar->getDom()->find('.top')->html($component);





        return $layout->render();
    }

}


