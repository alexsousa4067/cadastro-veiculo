<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Models\Characteristic;
use Source\Models\CharacteristicVehicle;
use Source\Models\Vehicle;

/**
 * Web Controller
 * @package Source\App
 */
class Web extends Controller
{
    /**
     * Web constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_THEME . "/");
    }

    /**
     * SITE HOME
     */
    public function home(): void
    {
        $filter = (new Session())->filter;

        if (empty($filter)) {
            $vehicles = (new Vehicle())->find()->fetch(true);
        } else {
            $where = "";
            $inner = "";
            if (!empty($filter->characteristics)) {
                foreach ($filter->characteristics as $characteristic) {
                    $inner .= " inner join characteristic_vehicle on vehicle.id = characteristic_vehicle.vehicle";
                    $where .= (empty($where)
                        ? " characteristic_vehicle.characteristic = '{$characteristic}'"
                        : " AND characteristic_vehicle.characteristic = '{$characteristic}'");
                }
            }

            $where = (empty($where) ? "id != 0" : $where);

            $where .= (!empty($filter->chassi_number) ? " AND chassi_number = '{$filter->chassi_number}'" : "");
            $where .= (!empty($filter->brand) ? " AND brand = '{$filter->brand}'" : "");
            $where .= (!empty($filter->model) ? " AND model = '{$filter->model}'" : "");
            $where .= (!empty($filter->year) ? " AND year = '{$filter->year}'" : "");
            $where .= (!empty($filter->plate) ? " AND plate = '{$filter->plate}'" : "");

            $vehicles = (new Vehicle())->find($where, "", "*", $inner)->fetch(true);
        }

        echo $this->view->render("home", [
            "title" => CONF_SITE_NAME . " | Home",
            "vehicles" => $vehicles,
            "characteristics" => (new Characteristic())->find()->fetch(true),
            "filter" => $filter
        ]);
    }

    public function search($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        (new Session())->set('filter', [
            "chassi_number" => $data["chassi_number"] ?? null,
            "brand" => $data["brand"] ?? null,
            "model" => $data["model"] ?? null,
            "year" => $data["year"] ?? null,
            "plate" => $data["plate"] ?? null,
            "characteristics" => $data["characteristics"] ?? null
        ]);

        $json['redirect'] = url();
        echo json_encode($json);
    }

    /**
     * @return void
     */
    public function createVehicle()
    {
        $characteristics = (new Characteristic())->find()->fetch(true);

        echo $this->view->render('create_vehicle', [
            "title" => CONF_SITE_NAME . " | Cadastrar Ve??culo",
            "characteristics" => $characteristics
        ]);
    }

    /**
     * @param array|null $data
     * @return void
     */
    public function storeVehicle(?array $data)
    {

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (empty($data)) {
            $json["message"] = $this->message->error("Informe os campos necess??rios")->render();
            echo json_encode($json);
            return;
        }

        $characteristics = $data["characteristics"] ?? null;
        if (empty($characteristics) || count($characteristics) < 2) {
            $json["message"] = $this->message->error("Informe pelo menos duas caracter??sticas")->render();
            echo json_encode($json);
            return;
        }

        $vehicle = new Vehicle();
        $vehicle->chassi_number = $data["chassi_number"] ?? null;
        $vehicle->brand = $data["brand"] ?? null;
        $vehicle->model = $data["model"] ?? null;
        $vehicle->year = $data["year"] ?? null;
        $vehicle->plate = $data["plate"] ?? null;

        if (!$vehicle->save()) {
            $json["message"] = $vehicle->message()->render();
            echo json_encode($json);
            return;
        }

        foreach ($characteristics as $characteristic) {
            $characteristicVehicle = new CharacteristicVehicle();
            $characteristicVehicle->vehicle = $vehicle->id;
            $characteristicVehicle->characteristic = $characteristic;

            if (!$characteristicVehicle->save()) {
                $vehicle->destroy();

                $json["message"] = $characteristicVehicle->message()->render();
                echo json_encode($json);
                return;
            }
        }

        $this->message->success("Ve??culo cadastrado com sucesso")->flash();
        $json["redirect"] = url("/editar-veiculo/{$vehicle->id}");
        echo json_encode($json);
        return;
    }

    /**
     * @param $data
     * @return void
     */
    public function editVehicle($data)
    {
        $vehicleId = $data['vehicle_id'] ?? null;
        if (empty(filter_var($vehicleId, FILTER_VALIDATE_INT))) {
            $this->message->error("Voc?? tentou editar um ve??culo que n??o existe no sistema")->flash();
            $json["redirect"] = url();
            echo json_encode($json);
            return;
        }

        $vehicle = (new Vehicle())->findById($vehicleId);
        $characteristics = (new Characteristic())->find()->fetch(true);

        echo $this->view->render('update_vehicle', [
            "title" => CONF_SITE_NAME . " | Editar Ve??culo",
            "vehicle" => $vehicle,
            "characteristics" => $characteristics
        ]);

    }

    /**
     * @param $data
     * @return void
     */
    public function updateVehicle($data)
    {
        $vehicleId = $data['vehicle_id'] ?? null;
        if (empty(filter_var($vehicleId, FILTER_VALIDATE_INT))) {
            $this->message->error("Voc?? tentou editar um ve??culo que n??o existe no sistema")->flash();
            $json["redirect"] = url();
            echo json_encode($json);
            return;
        }

        $vehicle = (new Vehicle())->findById($vehicleId);

        if (empty($vehicle)) {
            $this->message->error("Voc?? tentou editar um ve??culo que n??o existe no sistema")->flash();
            $json["redirect"] = url();
            echo json_encode($json);
            return;
        }

        $vehicle->chassi_number = $data["chassi_number"] ?? null;
        $vehicle->brand = $data["brand"] ?? null;
        $vehicle->model = $data["model"] ?? null;
        $vehicle->year = $data["year"] ?? null;
        $vehicle->plate = $data["plate"] ?? null;

        if (!$vehicle->save()) {
            $json["message"] = $vehicle->message()->render();
            echo json_encode($json);
            return;
        }

        if (empty($data["characteristics"]) || count($data["characteristics"]) < 2) {
            $json["message"] = $this->message->error("Informe pelo menos duas caracter??sticas")->render();
            echo json_encode($json);
            return;
        }

        $characteristicVehicle = (new CharacteristicVehicle())
            ->find("vehicle = :vehicle", "vehicle={$vehicle->id}")->count();

        //se n??o houver nenhuma caracter??stica no banco - cadastra as selecionadas
        if (empty($characteristicVehicle)) {
            foreach ($data["characteristics"] as $characteristic) {
                $characteristicVehicle = new CharacteristicVehicle();
                $characteristicVehicle->vehicle = $vehicle->id;
                $characteristicVehicle->characteristic = $characteristic;
                $characteristicVehicle->save();
            }
        } //se houver no banco - atualiza de acordo com a sele????o
        else {
            //cadastra os itens marcados que ainda n??o est??o cadastrados
            foreach ($data["characteristics"] as $c) {
                $check = (new CharacteristicVehicle())->find("vehicle = :vehicle AND characteristic = :characteristic",
                    "vehicle={$vehicle->id}&characteristic={$c}")->fetch();
                if (empty($check)) {
                    $characteristicVehicle = new CharacteristicVehicle();
                    $characteristicVehicle->vehicle = $vehicle->id;
                    $characteristicVehicle->characteristic = $c;
                    $characteristicVehicle->save();
                }
            }

            //consulta com os itens atualizados
            $characteristicVehicle = (new CharacteristicVehicle())
                ->find("vehicle = :vehicle", "vehicle={$vehicle->id}")->fetch(true);

            //remove do banco os itens que foram desmarcados
            foreach ($characteristicVehicle as $c) {
                if (!in_array($c->characteristic, $data["characteristics"])) {
                    $c->destroy();
                }
            }
        }
        $json["message"] = $this->message->success("Ve??culo atualizado com sucesso")->render();
        echo json_encode($json);
        return;
    }

    /**
     * @param $data
     * @return void
     */
    public function deleteVehicle($data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $vehicleId = $data["vehicle_id"] ?? null;

        if (empty($vehicleId)) {
            $this->message->error("Voc?? tentou excluir um ve??culo que n??o existe no sistema")->flash();
            redirect(url());
        }

        $vehicle = (new Vehicle())->findById($vehicleId);
        if (empty($vehicle)) {
            $this->message->error("Voc?? tentou excluir um ve??culo que n??o existe no sistema")->flash();
            redirect(url());
        }

        $vehicle->destroy();

        $this->message->success("Ve??culo removido com sucesso")->flash();
        redirect(url());
    }

    /**
     * @param $data
     * @return void
     */
    public function error($data)
    {
        $error = new \stdClass();
        $error->code = $data["errcode"];

        switch ($error->code) {
            case '404':
                $error->title = "P??gina n??o encontrada";
                $error->message = "A p??gina solicitana n??o existe ou foi removida";
                break;
            case '500':
                $error->title = "Erro interno no servidor";
                $error->message = "Ocorreu um erro inexperado, j?? estamos trabalhando no problema, em breve tudo voltar?? ao normal";
                break;
            case 'problemas':
                $error->code = 503;
                $error->title = "Problemas :/";
                $error->message = "Estamos enfrentando instabilidades no momento, j?? estamos trabalhando no problema, em breve tudo voltar?? ao normal";
                break;
            case 'manutencao':
                $error->code = 503;
                $error->title = "Manuten????o";
                $error->message = "Estamos trabalhando em melhorias no sistema, em breve tudo voltar?? ao normal";
                break;
            default:
                $error->code = 500;
                $error->title = "Erro ao processar requisi????o";
                $error->message = "Ocorreu um erro ao processar a requisi????o";
                break;
        }


        echo $this->view->render("error", [
            "error" => $error
        ]);
    }
}