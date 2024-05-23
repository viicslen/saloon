<?php

declare(strict_types=1);

namespace Saloon\Helpers;

/**
 * @internal
 */
final class ObjectHelpers
{
    /**
     * Get an item from an object using "dot" notation.
     *
     * @param object<object-key, mixed> $object
     * @param string|null $key
     * @return ($key is null ? object<object-key, mixed> : mixed)
     */
    public static function get(object $object, string $key, mixed $default = null): mixed
    {
        // Split the dot notation into individual keys
        $keys = explode('.', $key);

        // Navigate through the object properties
        foreach ($keys as $key) {
            // Check if the object is an array or object and if the key exists
            if (is_object($object) && isset($object->{$key})) {
                $object = $object->{$key};
            } elseif (is_array($object) && isset($object[$key])) {
                $object = $object[$key];
            } else {
                // Return null if the key doesn't exist
                return null;
            }
        }

        return $object;
    }
}
