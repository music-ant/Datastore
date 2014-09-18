<?php

namespace MusicAnt;

use string;

interface Record {

    public function getId();

    public function getFilterableAttributes();

    public function getOrderableAttributes();
}
