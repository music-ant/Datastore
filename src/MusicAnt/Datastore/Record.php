<?php

namespace MusicAnt\Datastore;

use string;

interface Record {

    public function getId();

    public static function getFilterableAttributes();

    public static function getOrderableAttributes();
}
