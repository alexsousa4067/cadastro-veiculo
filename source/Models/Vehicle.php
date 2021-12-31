<?php

namespace Source\Models;

use Source\Core\Model;

class Vehicle extends Model
{
    public function __construct()
    {
        parent::__construct("vehicle", ["id"], [
            "chassi_number", "brand", "model", "year", "plate"
        ]);
    }

    public function characteristics()
    {
        $id = (!empty($this->vehicle) ? $this->vehicle : $this->id);
        $result = [];
        $characteristics = (new CharacteristicVehicle())->find("vehicle = :vehicle", "vehicle={$id}")->fetch(true);
        if (!empty($characteristics)) {
            foreach ($characteristics as $characteristic) {
                $result[] = (new Characteristic())->findById($characteristic->characteristic);
            }
        }
        return $result;
    }
}