<?php

namespace App\Controller;

use App\Entity\Tag;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TagController extends Controller
{
	public function tag(Request $request, Response $response, $args = [])
    {
    	$tag = $this->ci->get('db')->find('App\Entity\Tag', $args['id']);

    	if(!$tag){
    		throw new HttpNotFoundException($request);
    	}

        return $this->renderPage($response, 'tag.html', [
        	'tag' => $tag,
        	'articles' => $tag->getArticles()
        ]);
    }

    public function view(Request $request, Response $response)
    {
    	$tags = $this->ci->get('db')->getRepository('App\Entity\Tag')->findBy([], []);
        return $this->renderPage($response, 'admin/tags/view.html', [
        		'tags' => $tags
        ]);
    }  

    public function create(Request $request, Response $response, $args = [])
    {
        $tag = new Tag;


        if($request->isPost()){
            $tag->setName($request->getParam('name'));

            $this->ci->get('db')->persist($tag);
            $this->ci->get('db')->flush();

            return $response->withRedirect('/admin/tags');
        }

        return $this->renderPage($response, 'admin/tags/create.html', [
            'tag' => $tag
        ]);
    }

    public function edit(Request $request, Response $response, $args = [])
    {
        $tag = $this->ci->get('db')->find('App\Entity\Tag', $args['id']);

        if (!$tag) {
            throw new HttpNotFoundException($request);
        }

        if($request->isPost()){

            if($request->getParam('action') == 'delete'){
                $this->ci->get('db')->remove($tag);
                $this->ci->get('db')->flush();

                return $response->withRedirect('/admin/tags');
            }

            $tag->setName($request->getParam('name'));

            $this->ci->get('db')->persist($tag);
            $this->ci->get('db')->flush();

            return $response->withRedirect('/admin/tags');
            
        }

        return $this->renderPage($response, 'admin/tags/edit.html', [
            'tag' => $tag
        ]);

        return implode($options);
    }
}