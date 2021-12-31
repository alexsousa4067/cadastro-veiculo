<?php $v->layout("_theme"); ?>

<section>
    <h1 class="section_title">Cadastrar novo veículos</h1>
    <form method="post" class="crud_form" id="create_vehicle_form">
        <div class="label_box">
            <label for="chassi_number" class="label">Nº do chassi</label>
            <input type="text" name="chassi_number" id="chassi_number" class="input_default">
        </div>

        <div class="label_box">
            <label for="brand" class="label">Marca</label>
            <input type="text" name="brand" id="brand" class="input_default">
        </div>

        <div class="label_box">
            <label for="model" class="label">Modelo</label>
            <input type="text" name="model" id="model" class="input_default">
        </div>

        <div class="label_box">
            <label for="year" class="label">Ano</label>
            <input type="text" name="year" id="year" class="input_default">
        </div>

        <div class="label_box">
            <label for="plate" class="label">Placa</label>
            <input type="text" name="plate" id="plate" class="input_default">
        </div>

        <div class="label_box">
            <label class="label">Características</label>
            <div class="checkbox_container">
                <?php if (!empty($characteristics)): ?>
                    <?php foreach ($characteristics as $characteristic): ?>
                        <div class="label_box">
                            <input class="input_checkbox" type="checkbox" name="characteristics[]"
                                   value="<?= $characteristic->id ?>">
                            <span><?= $characteristic->name ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="label_box">
            <button class="btn">Cadastrar</button>
        </div>
    </form>
</section>

<?php $v->start("scripts"); ?>
<script>
    const form = document.querySelector("#create_vehicle_form");

    form.addEventListener("submit", async function (event) {
        event.preventDefault();

        const request = await fetch('<?= url("/cadastrar-veiculo")?>', {
            method: "POST",
            body: new FormData(form)
        });

        const response = await request.json();

        if (response.message){
            showMessage(response.message);
        }
        if (response.redirect){
            window.location.href = response.redirect;
        }
    });
</script>
<?php $v->end(); ?>
