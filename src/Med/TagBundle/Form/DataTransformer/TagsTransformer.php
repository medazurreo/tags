<?php

namespace Med\TagBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Med\TagBundle\Entity\Tag;
use Symfony\Component\Form\DataTransformerInterface;

class TagsTransformer implements DataTransformerInterface 
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * TagsTransformer constructor.
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }
    /**
     * @param array $value
     * @return string
     */
    public function transform($value)
    {
        return implode(',' , $value);
    }

    /**
     * @param $string
     * @return array
     */
    public function reverseTransform($string)
    {
        $tags = [];
        $nameTags = array_unique(array_filter(array_map('trim', explode(',', $string))));

        $existingTags = $this->em->getRepository('TagBundle:Tag')->findBy([
            'name' => $nameTags
        ]);

        $newTags = array_diff($nameTags, $existingTags);
        foreach ($newTags as $name) {
            $tag = new Tag();
            $tag->setName($name);
            $tags[] = $tag;
        }
        return $tags;
    }
}