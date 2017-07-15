<?php

namespace Med\TagBundle\Repository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Med\TagBundle\Entity\Tag;

/**
 * TagRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TagRepository extends \Doctrine\ORM\EntityRepository
{
    public function search($q)
    {
        return $this->createQueryBuilder('t')
            ->select('t.name')
            ->where('t.name like :name')
            ->setParameter('name', "%".$q."%")
            ->getQuery();
    }


    public function tagsUnused($class)
    {
        $em = $this->getEntityManager();
        $rsm = new ResultSetMappingBuilder($em);
        $rsm->addRootEntityFromClassMetadata(Tag::class, 't');
        $join_table = $em->getClassMetadata($class)->getAssociationMapping('tags')['joinTable']['name'];

        return $em->createNativeQuery(
          "SELECT t.id, t.name 
            from tag t 
              LEFT JOIN  ".$join_table." pt on pt.tag_id = t.id
              where pt.tag_id IS NULL ", $rsm)->getResult();

    }
}
