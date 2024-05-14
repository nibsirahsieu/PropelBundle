<?php

namespace Propel\Bundle\PropelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseAbstractType extends AbstractType
{
    protected $options = array(
        'name' => '',
    );

    /**
     *
     * @param array|null $mergeOptions
     */
    public function __construct(?array $mergeOptions = null)
    {
        if ($mergeOptions) {
            $this->mergeOptions($mergeOptions);
        }
    }

    /**
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setOption(string $name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     *
     * @param string $name
     * @return mixed
     */
    public function getOption(string $name)
    {
        return $this->options[$name];
    }

    /**
     *
     * @param array $options
     * @return void
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     *
     * @param array $options
     * @return void
     */
    public function mergeOptions(array $options): void
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults($this->options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->getOption('name');
    }
}
