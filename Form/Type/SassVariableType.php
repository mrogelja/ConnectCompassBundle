<?php

namespace Mr\ConnectCompassBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Mr\ConnectCompassBundle\Model\SassVariable;

class SassVariableType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $types =  array();

        foreach (SassVariable::$types as $type) {
            $types[$type] = $type;
        }

        $builder
            ->add('name', null, array(
                'label' => 'form.sass_variable_name',
                'translation_domain' => 'MrConnectCompassBundle',
                'label_attr' => array('class' => 'sass_variable_name')
            ))
            ->add('value', null, array(
                'label' => 'form.sass_variable_value',
                'translation_domain' => 'MrConnectCompassBundle',
                'label_attr' => array('class' => 'sass_variable_value')
            ))
            ->add('type', 'choice', array(
                'choices' => $types,
                'label' => 'form.sass_variable_type',
                'translation_domain' => 'MrConnectCompassBundle',
                'label_attr' => array('class' => 'sass_variable_type')
            ))
            ->add('comment', 'textarea', array(
                'label' => 'form.sass_variable_comment',
                'translation_domain' => 'MrConnectCompassBundle',
                'label_attr' => array('class' => 'sass_variable_comment')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'connect_compass_sass_variable';
    }
}