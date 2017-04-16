<?php

namespace Propel\Bundle\PropelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class BaseAbstractType extends AbstractType
{
    protected $options = array(
        'name' => '',
    );

    public function __construct($mergeOptions = null)
    {
        if ($mergeOptions) {
            $this->mergeOptions($mergeOptions);
        }
    }

    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function getOption($name)
    {
        return $this->options[$name];
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function mergeOptions($options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function configureOptions(OptionsResolver $resolver) 
    {
        $resolver->setDefaults($this->options);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
    
    public function getBlockPrefix() 
    {
        return $this->getOption('name');
    }
}
