<?php
namespace Med\TagBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Med\TagBundle\Form\DataTransformer\TagsTransformer;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagsType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * TagsType constructor.
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CollectionToArrayTransformer(), true);

        $builder->addModelTransformer( new TagsTransformer($this->em), true);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefault('attr', [
            'class' => 'tag-input',
        ]);
        $resolver->setDefault('required', false);
    }
    /**
     * @return mixed
     */
    public function getParent()
    {
        return TextType::class;
    }


}