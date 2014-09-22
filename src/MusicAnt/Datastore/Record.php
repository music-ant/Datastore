<?php

namespace MusicAnt\Datastore;

interface Record {

    public function getId();

    public static function getFilterableAttributes();

    public static function getOrderableAttributes();

    public static function getAttributes();
}
