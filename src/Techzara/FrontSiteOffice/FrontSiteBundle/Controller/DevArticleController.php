<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 10/16/18
 * Time: 10:44 PM
 */

namespace App\Techzara\FrontSiteOffice\FrontSiteBundle\Controller;


use App\Techzara\Service\MetierManagerBundle\Entity\DevArticle;
use App\Techzara\Service\MetierManagerBundle\Utils\ServiceName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DevArticleController extends Controller
{
    public function indexAction()
    {
        $_article_manager = $this->get(ServiceName::SRV_METIER_ARTICLE);
        $article_liste = $_article_manager->getAllArticle();

        return $this->render('FrontSiteBundle:DevArticle:index.html.twig',array(
           'articles'  => $article_liste
        ));
    }

    /**
     * @param $_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showArticleAction(DevArticle $article)
    {
        if (!$article){
            $this->createNotFoundException('Article not exist');
        }
        return $this->render('FrontSiteBundle:DevArticle:detail.html.twig',array(
            'article' => $article,
        ));
    }
}