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
use EBT\ConfigLoader\Exception\InvalidArgumentException;

/**
 * JsonFileLoader
 */
class JsonFileLoader extends Loader
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
        $resource = (string) $resource;

        if (!is_file($resource)) {
            throw new InvalidArgumentException(sprintf('File "%s" is not a regular file.', $resource));
        }

        if (!is_readable($resource)) {
            throw new InvalidArgumentException(sprintf('File "%s" is not readable.', $resource));
        }

        $content = file_get_contents($resource);
        $decoded = @json_decode($content, true);

        if ($decoded === null) {
            throw new InvalidArgumentException(
                sprintf('File "%s" cannot be json decode (error code: %s).', $resource, json_last_error())
            );
        }

        return $decoded;
    }

    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'json' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}
