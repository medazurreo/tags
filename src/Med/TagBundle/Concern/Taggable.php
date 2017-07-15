<?php

namespace  Med\TagBundle\Concern;
use Med\TagBundle\Entity\Tag;

trait Taggable
{
    /**
     * @var array $tags
     * @ORM\ManyToMany(targetEntity="Med\TagBundle\Entity\Tag", cascade={"persist"} )
     */
    private $tags;

    /**
     * Add tag
     *
     * @param \Med\TagBundle\Entity\Tag $tag
     *
     * @return Post
     */
    public function addTag(\Med\TagBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Med\TagBundle\Entity\Tag $tag
     */
    public function removeTag(\Med\TagBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}