<?php

namespace Med\TagBundle\Controller;

use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    /**
     * @Route("tags.json", name="tag.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction(Request $request)
    {
        $tagRepo = $this->getDoctrine()->getManager()->getRepository('TagBundle:Tag');
        if ($q = $request->query->get('q')){
            $tags = $tagRepo->search($q)->getResult();
        }else {
            $tags = $tagRepo->findAll();
        }
        $tags = $tagRepo->tagsUnused(Post::class);

        return $this->json($tags, 200, [], array('groups' => ['public']));
    }
}
