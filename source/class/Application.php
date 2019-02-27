<?php


namespace PlanckeyBlogPublic;


use Planck\Extension\Content\Model\Entity\Article;
use Planck\Extension\RichTag\Decorator\Taggable;
use Planck\Theme\Yummy\Yummy;

class Application extends \Planck\Extension\Bootstrap\WebContentApplication
{


    public function __construct($path = null, $instanceName = null, $autobuild = true)
    {
        parent::__construct($path, $instanceName, $autobuild);


        $pathContainer = new \PlanckeyBlogPublic\Container\Path();
        $this->addContainer($pathContainer);


        $mainContainer = new \PlanckeyBlogPublic\Container\Main();
        $this->addContainer($mainContainer);
        $this->setModel($mainContainer->get('model'));


    }





    public function initialize()
    {
        parent::initialize();
        $this->registerRoutes();

        $this->registerEntitiesDecorators();
    }


    public function getTheme()
    {
        if(!$this->theme) {
            $this->theme = new Yummy();
        }
        return $this->theme;
    }




    protected function registerRoutes()
    {
        //parent::registerRoutes();
        $router = new Router($this);
        $this->addRouter($router);
        return $this;
    }



    public function registerEntitiesDecorators()
    {
        $this->getModel()->addEntityDecorator(Article::class, Taggable::class);
    }





    public function render()
    {
        //=======================================================
        return $this->getRenderer()->render();

    }


    //=======================================================





}