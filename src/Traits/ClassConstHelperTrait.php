<?php

declare(strict_types=1);

namespace App\Traits;

trait ClassConstHelperTrait
{
    public static function getClassConstants(string $key = null, bool $associativeArray = false, string $keyPrefix = null, array $exclude = []): array
    {
        $data = [];
        $key = \is_string($key) ? strtoupper($key) : $key;
        $constants = (new \ReflectionClass(static::class))->getConstants();

        foreach ($constants as $name => $value) {
            if (\in_array($value, $exclude, true)) {
                continue;
            }

            if (null === $key || str_starts_with($name, $key)) {
                $data[$keyPrefix.$value] = $value;
            }
        }

        return $associativeArray ? $data : array_values($data);
    }
}
