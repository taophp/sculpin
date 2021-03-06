<?php

declare(strict_types=1);

/*
 * This file is a part of Sculpin.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sculpin\Bundle\SculpinBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Data Provider pass
 *
 * @author Beau Simensen <beau@dflydev.com>
 */
class DataProviderManagerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('sculpin.data_provider_manager')) {
            return;
        }

        $definition = $container->getDefinition('sculpin.data_provider_manager');

        foreach ($container->findTaggedServiceIds('sculpin.data_provider') as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall('registerDataProvider', array($attributes['alias'], new Reference($id)));
            }
        }
    }
}
