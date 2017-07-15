<?php
namespace Med\TagBundle\Tests\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Med\TagBundle\Entity\Tag;
use Med\TagBundle\Form\DataTransformer\TagsTransformer;
use Symfony\Bundle\SecurityBundle\Tests\Functional\WebTestCase;

class TagsTransformerTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateTagsArrayFromString()
    {
        $dataTransformer = $this->getMockedTagsTransformer();
        $tags = $dataTransformer->reverseTransform('demo, chat');
        $this->assertCount(2, $tags);
        $this->assertSame('demo', $tags[1]->getName());
    }

    public function testUserAlreadyDefinedTag()
    {
        $tag = new Tag();
        $tag->setName('chat');
        $dataTransformer = $this->getMockedTagsTransformer();
        $tags = $dataTransformer->reverseTransform('demo, chat');
        $this->assertCount(2, $tags);
        $this->assertSame($tag, $tags[0]->getName());
    }

    public function testRemoveEmptyTag()
    {
        $dataTransformer = $this->getMockedTagsTransformer();
        $tags = $dataTransformer->reverseTransform('demo,,  ,chat,  ');
        $this->assertCount(2, $tags);
        $this->assertSame('demo', $tags[1]->getName());
    }

    public function testRemoveDuplicateTags()
    {
        $dataTransformer = $this->getMockedTagsTransformer();
        $tags = $dataTransformer->reverseTransform('demo,,  ,Demo,  ');
        $this->assertCount(1, $tags);
    }

    public function getMockedTagsTransformer($result = [])
    {
        $tagRepository = $this->getMockBuilder(EntityRepository::class)
        ->disableOriginalConstructor()
            ->getMock();
        $tagRepository->expects($this->any())
            ->method('findBy')
        ->will($this->returnValue($result));

        $entityManager = $this->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($tagRepository));

        return new TagsTransformer($entityManager);

    }
}