<?php

namespace MusicAnt\Datastore;


class BaseRecord implements Record
{
    protected $id;

    public function __call($function, $args) {
        if (strlen($function) > 3) {
            $prefix = substr($function, 0, 3);
            $possibleAttribute = lcfirst(substr($function, 3));

            if (in_array($possibleAttribute, $this->getAttributes())) {
                if ($prefix == 'set') {
                    $this->$possibleAttribute = $args[0];
                    return $this;
                } else if ($prefix == 'get') {
                    return $this->$possibleAttribute;
                }
            }
        }
    }

    public function getId() {
    }

    public static function getFilterableAttributes() {
    }

    public static function getOrderableAttributes() {
    }

    public static function getAttributes() {
        $clazz = get_called_class();
        $attributes = array_keys(get_object_vars(new $clazz));

        return self::setIdAttributeToTheTop($attributes);
    }

    private static function setIdAttributeToTheTop(array $attributes) {
        $attributeCount = count($attributes);
        $rightOrderedAttributes[0] = $attributes[$attributeCount -1];

        for ($i = 1; $i < $attributeCount; $i++) {
            $rightOrderedAttributes[$i] = $attributes[$i-1];
        }

        return $rightOrderedAttributes;
    }
}
