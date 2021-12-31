<?php use Source\Models\CharacteristicVehicle;

$v->layout("_theme"); ?>

<section>
    <h1 class="section_title">Atualizar veículo</h1>
    <form method="post" class="crud_form" id="update_vehicle_form">
        <div class="label_box">
            <label for="chassi_number" class="label">Nº do chassi</label>
            <input type="text" name="chassi_number" id="chassi_number" class="input_default"
                   value="<?= $vehicle->chassi_number ?? '' ?>">
        </div>

        <div class="label_box">
            <label for="brand" class="label">Marca</label>
            <input type="text" name="brand" id="brand" class="input_default"
                   value="<?= $vehicle->brand ?? '' ?>">
        </div>

        <div class="label_box">
            <label for="model" class="label">Modelo</label>
            <input type="text" name="model" id="model" class="input_default"
                   value="<?= $vehicle->model ?? '' ?>">
        </div>

        <div class="label_box">
            <label for="year" class="label">Ano</label>
            <input type="text" name="year" id="year" class="input_default"
                   value="<?= $vehicle->year ?? '' ?>">
        </div>

        <div class="label_box">
            <label for="plate" class="label">Placa</label>
            <input type="text" name="plate" id="plate" class="input_default"
                   value="<?= $vehicle->plate ?>">
        </div>

        <div class="label_box">
            <label class="label">Características</label>
            <div class="checkbox_container">
                <?php if (!empty($characteristics)): ?>
                <?php
                    $characteristicsVehicle = $vehicle->characteristics();
                    $checkeds = [];
                    foreach ($characteristicsVehicle as $item) {
                        $checkeds[] = $item->id;
                    }

                    $checked = function ($value) use ($checkeds){
                        return (in_array($value, $checkeds) ? "checked" : "");
                    }
                    ?>
                    <?php foreach ($characteristics as $characteristic): ?>
                        <div class="label_box">
                            <input class="input_checkbox" type="checkbox" name="characteristics[]"
                                   value="<?= $characteristic->id ?>"
                            <?= $checked($characteristic->id) ?>>
                            <span><?= $characteristic->name ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="label_box">
            <button class="btn">Atualizar</button>
        </div>
    </form>
</section>

<?php $v->start("scripts"); ?>
<script>
    const form = document.querySelector("#update_vehicle_form");

    form.addEventListener("submit", async function (event) {
        event.preventDefault();

        const request = await fetch('<?= url("/editar-veiculo/" . $vehicle->id)?>', {
            method: "POST",
            body: new FormData(form)
        });

        const response = await request.json();

        if (response.message) {
            showMessage(response.message);
        }
        if (response.redirect) {
            window.location.href = response.redirect;
        }
    });
</script>
<?php $v->end(); ?>
