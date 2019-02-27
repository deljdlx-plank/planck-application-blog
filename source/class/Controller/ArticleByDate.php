<?php

namespace PlanckeyBlogPublic\Controller;



use Planck\Controller;
use PlanckeyBlogPublic\Router;

class ArticleByDate extends Controller
{


    public function render($year = null, $month = null, $date = null)
    {


        $articles = null;

        $repository = $this->getApplication()->getModelRepository(\Planck\Extension\Content\Model\Repository\Article::class);
        $articles = $repository->getByDate($year, $month, $date);

        $router = $this->getApplication()->getRouter(Router::class);

        foreach ($articles as $article) {

            $url = $router->getRouteByName('article')->buildURL(array($article->getId()));

            $article->setValue(
                'url',
                $url
            );
        }




        $layout = $this->getApplication()->getTheme()->getLayout('Home');
        $layout->setVariable('articles', $articles);






        return $layout->render();
    }

}


