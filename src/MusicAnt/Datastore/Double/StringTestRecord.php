<?php
namespace MusicAnt\Datastore\Double;

class StringTestRecord implements \MusicAnt\Datastore\Record{
    public $id;
    public $name;
    public static  $filterableAttributes;
    public static  $orderableAttributes;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public static function setFilterableAttributes($attributes) {
        self::$filterableAttributes = $attributes;
    }
    public static function getFilterableAttributes() {
        return self::$filterableAttributes;
    }

    public static function setOrderableAttributes($attributes) {
        self::$orderableAttributes = $attributes;
    }
    public static function getOrderableAttributes() {
        return self::$orderableAttributes;
    }

    public static function getAttributes() {
        return array('id', 'name');
    }

}
