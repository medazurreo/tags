<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function finLatest($tag=null)
    {
         $sql = $this->createQueryBuilder('p')
            ->join('p.tags', 't')
            ->select('p', 't');
        if ($tag) {
            $sql->where('t.name =:name')
                ->setParameter('name', $tag);
        }

        return $sql->getQuery();
    }
}