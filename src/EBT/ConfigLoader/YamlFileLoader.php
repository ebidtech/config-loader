<?php

/*
 * This file is a part of the Config loader library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\ConfigLoader;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Yaml\Yaml;
use EBT\ConfigLoader\Exception\InvalidArgumentException;

/**
 * YamlFileLoader
 */
class YamlFileLoader extends Loader
{
    /**
     * Loads a resource.
     *
     * @param mixed  $resource The resource
     * @param string $type     The resource type
     *
     * @return array
     *
     * @throws InvalidArgumentException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function load($resource, $type = null)
    {
        if (!is_file($resource)) {
            throw new InvalidArgumentException(sprintf('File "%s" is not a regular file.', $resource));
        }

        $content = Yaml::parse($resource);
        if (!is_array($content)) {
            throw new InvalidArgumentException(sprintf('Could not parse Yaml of file "%s"', $resource));
        }

        return $content;
    }

    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}
