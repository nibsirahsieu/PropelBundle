<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Propel\Bundle\PropelBundle\Form;

use Symfony\Component\Form\AbstractExtension;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Represents the Propel form extension, which loads the Propel functionality.
 *
 * @author Joseph Rouff <rouffj@gmail.com>
 */
class PropelExtension extends AbstractExtension
{
    /**
     * @return array<FormTypeInterface>
     */
    protected function loadTypes(): array
    {
        return array(
            new Type\ModelType(PropertyAccess::createPropertyAccessor()),
            new Type\TranslationCollectionType(),
            new Type\TranslationType(),
        );
    }

    /**
     * @return FormTypeGuesserInterface|null
     */
    protected function loadTypeGuesser(): ?FormTypeGuesserInterface
    {
        return new PropelTypeGuesser();
    }
}
