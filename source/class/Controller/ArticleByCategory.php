<?php

namespace PlanckeyBlogPublic\Controller;



use Planck\Controller;
use PlanckeyBlogPublic\Router;

class ArticleByCategory extends Controller
{


    public function render($categoryId)
    {


        $articles = null;

        $repository = $this->getApplication()->getModelRepository(\Planck\Extension\Content\Model\Repository\Article::class);
        $articles = $repository->getByCategoryId($categoryId);

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


