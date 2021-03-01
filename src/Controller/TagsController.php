<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

class TagsController extends Controller
{
    
    public function tag(Request $request, Response $response, $args = [])
    {
        $tag = $this->ci->get('db')->find('App\Entity\Tag', $args['id']);

        if(!$author){
            throw new HttpNotFoundException($request);
        }
        /*
        $dql = "SELECT a FROM App\Entity\Article a
                WHERE a.author = :author
                ORDER BY a.published DESC";

        $query = $this->ci->get('db')->createQuery($dql);
        $query ->setParameter('author', $author);
        $articles = $query->getResult();
        */
        return $this->renderPage($response, 'tag.html', [
            'tag' => $tag,
            'articles' => $tag->getArticles()
        ]);
    }

    public function view(Request $request, Response $response){

        $tags = $this->ci->get('db')->getRepository('App\Entity\Tag')->findBy([], [
            'name' => 'DESC'
        ]);

        if(!$tags){
            throw new HttpNotFoundException($request);
        }

        return $this->renderPage($response, 'tags.html', [
            'tags' => $tags
        ]);

    }
    
    
}