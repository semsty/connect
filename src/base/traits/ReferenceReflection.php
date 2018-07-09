<?php

namespace semsty\connect\base\traits;

trait ReferenceReflection
{
    public static function getReferenceClass($path, $default, $depth = 3)
    {
        $reflector = new \ReflectionClass(static::class);
        $exploded = explode('\\', $reflector->getNamespaceName());
        foreach (range(0, $depth) as $step) {
            $exploded = array_splice($exploded, 0, count($exploded) - $step);
            $className = implode('\\', $exploded) . '\\' . $path;
            if (class_exists($className)) {
                return $className;
            }
        }
        return $default;
    }
}
