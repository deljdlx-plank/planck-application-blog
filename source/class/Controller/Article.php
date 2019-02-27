<?php

namespace PlanckeyBlogPublic\Controller;



use Planck\Controller;

class Article extends Controller
{


    public function render($articeId)
    {



        $repository = $this->getApplication()->getModelRepository(\Planck\Extension\Content\Model\Repository\Article::class);

        $article = $repository->getById($articeId);



        $view = new \Planck\Theme\Yummy\View\Article();
        $view->setVariable('article', $article);





        $layout = $this->getApplication()->getTheme()->getLayout('Article');


        $layout->registerComponent($view, '#article-container');

        $layout->registerComponent(
            $article->getTitle(),
            'title'
        );








        return $layout->render();
    }

}


