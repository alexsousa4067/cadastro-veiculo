<?php

namespace Source\Models;

use Source\Core\Model;

class CharacteristicVehicle extends Model
{
    public function __construct()
    {
        parent::__construct("characteristic_vehicle", ["id"], [
            "characteristic", "vehicle"
        ]);
    }
}