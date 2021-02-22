<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

class TagsController extends Controller
{
    public function tag(Request $request, Response $response){

        $tags = $this->ci->get('db')->getRepository('App\Entity\Tag')->findBy([], [
            'name' => 'DESC'
        ]);

        if(!$tags){
            throw new HttpNotFoundException($request);
        }

        return $this->renderPage($response, 'tag.html', [
            'tags' => $tags
        ]);

    }
    
    
}