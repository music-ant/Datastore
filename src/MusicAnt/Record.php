<?php

namespace MusicAnt;

use string;

interface Record {

    public function getId();

    public static function getFilterableAttributes();

    public static function getOrderableAttributes();
}
