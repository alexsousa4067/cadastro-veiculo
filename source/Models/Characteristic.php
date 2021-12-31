<?php

namespace Source\Models;

use Source\Core\Model;

class Characteristic extends Model
{
    public function __construct()
    {
        parent::__construct("characteristics", ["id"], [
            "name"
        ]);
    }
}