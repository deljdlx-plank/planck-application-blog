<?php
namespace PlanckeyBlogPublic;


use Phi\Routing\Route;
use Planck\Exception\InvalidValue;
use Planck\Extension\Content\Model\Entity\Category;
use Planck\Extension\RichTag\Model\Entity\Tag;
use Planck\Extension\User\Model\Entity\User;
use Planck\Helper\StringUtil;
use Planck\Model\Entity;
use Planck\Routing\RouteDescriptor;
use PlanckeyBlogPublic\Controller\Article;

use PlanckeyBlogPublic\Controller\ArticleByAuthor;
use PlanckeyBlogPublic\Controller\ArticleByCategory;
use PlanckeyBlogPublic\Controller\ArticleByDate;
use PlanckeyBlogPublic\Controller\Home;
use PlanckeyBlogPublic\Controller\Tag as TagController;

class Router extends \Planck\Routing\Router
{

    public function registerRoutes()
    {


        $this->get('article', '`/article/(\d+)`', function($articleId) {
            $controller = new Article();
            echo $controller->render($articleId);

        })->setBuilder(function($article) {

            if($article instanceof Entity) {
                return '?/article/'.$article->getId();
            }
            else if(is_scalar($article)) {
                return '?/article/'.$article;
            }
            else {
                throw new InvalidValue('Can not build route "article". Provided parameter is not an article nor an article id');
            }
        }, null, array(
            'article' => array(
                'accept' => array(
                    'int', \Planck\Extension\Content\Model\Entity\Article::class
                )
            )
        ))
            ->setDescriptor(new RouteDescriptor(array(
            'label' => 'Article',
            'description' => 'Affichage d\'un article',
        )));





        //=======================================================
        $this->get('tag', '`tag/(.*?)'.Route::getEndRouteRegexp().'`', function($slug) {
            $controller = new TagController();
            echo $controller->render($slug);

        })->setBuilder(function(Tag $tag) {
            return '?/tag/'.$tag->getValue('slug');
        });


        $this->get('author', '`author/(\d+)/.*'.Route::getEndRouteRegexp().'`', function($userId) {

            $controller = new ArticleByAuthor();
            echo $controller->render($userId);


        })->setBuilder(function(User $user) {
            return '?/author/'.$user->getId().'/'.StringUtil::slugify($user->getName());
        });



        $this->get('date', '`date/(\d+?)-(\d+)'.Route::getEndRouteRegexp().'`', function($year, $month) {

            $controller = new ArticleByDate();
            echo $controller->render($year, $month);

        })->setBuilder(function($datetime) {
            $time = strtotime($datetime);
            return '?/date/'.date('Y-m', $time);
        });


        $this->get('category', '`category/(\d+)/.+'.Route::getEndRouteRegexp().'`', function($categoryId) {

            $controller = new ArticleByCategory();
            echo $controller->render($categoryId);

        })->setBuilder(function(Category $category) {
            return '?/category/'.$category->getId().'/'.$category->getValue('qname');
        });



        //=======================================================





        $this->get('home', '`'.Route::getEndRouteRegexp().'`', function() {
            $controller = new Home();
            echo $controller->render();
        })->setBuilder('?');





    }


}