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

use EBT\ConfigLoader\Exception\InvalidArgumentException;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Yaml\Yaml;

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
        if (! is_file($resource)) {
            throw new InvalidArgumentException(sprintf('File "%s" is not a regular file.', $resource));
        }

        /* Checking file readability before hand to ensure getting its contents never fail. */
        if (! is_readable($resource)) {
            throw new InvalidArgumentException(sprintf('File "%s" is not readable.', $resource));
        }

        /* Explicitly reading file's content, because support for passing file names is deprecated since Symfony 2.8. */
        $content = file_get_contents($resource);
        $parsedYaml = Yaml::parse($content);

        if (! is_array($parsedYaml)) {
            throw new InvalidArgumentException(sprintf('Could not parse Yaml of file "%s"', $resource));
        }

        return $parsedYaml;
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
