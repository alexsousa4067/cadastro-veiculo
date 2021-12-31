<?php $v->layout("_theme"); ?>

<section>
    <header class="main_content_header">
        <h1 class="section_title">Listagem de veículos</h1>
        <button class="btn" onclick="showModal('search_form_modal')">Filtrar</button>
    </header>
    <div class="modal_box" id="search_form_modal">
        <form class="search_form modal_item" id="search_form">
            <h1>Filtrar</h1>
            <span class="close">x</span>
            <input type="text" name="chassi_number" placeholder="Nº do chassi"
                   value="<?= $filter->chassi_number ?? '' ?>">
            <input type="text" name="brand" placeholder="Marca" value="<?= $filter->brand ?? '' ?>">
            <input type="text" name="model" placeholder="Modelo" value="<?= $filter->model ?? '' ?>">
            <input type="text" name="year" placeholder="Ano" value="<?= $filter->year ?? '' ?>">
            <input type="text" name="plate" placeholder="Placa" value="<?= $filter->plate ?? '' ?>">
            <div class="checkbox_container">
                <?php if (!empty($characteristics)): ?>
                    <?php foreach ($characteristics as $characteristic): ?>
                        <?php
                        $selecteds = $filter->characteristics ?? [];
                        $checked = function ($value) use ($selecteds){
                            return (in_array($value, $selecteds) ? "checked" : "");
                        }
                        ?>
                        <div class="checkbox_label">
                            <input type="checkbox" name="characteristics[]"
                                   value="<?= $characteristic->id ?>" <?= $checked($characteristic->id) ?>><span><?= $characteristic->name ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <button class="btn">Filtrar</button>
        </form>
    </div>

    <div class="vehicle_list_box">
        <table class="vehicle_list">
            <tr>
                <th>Nº do chassi</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th>Placa</th>
                <th>Características</th>
                <th>Ações</th>
            </tr>

            <?php if (!empty($vehicles)): ?>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <td><?= $vehicle->chassi_number ?></td>
                        <td><?= $vehicle->brand ?></td>
                        <td><?= $vehicle->model ?></td>
                        <td><?= $vehicle->year ?></td>
                        <td><?= $vehicle->plate ?></td>
                        <td>
                            <ul>
                                <?php if (!empty($vehicle->characteristics())): ?>
                                    <?php foreach ($vehicle->characteristics() as $characteristic): ?>
                                        <li><?= $characteristic->name ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </td>
                        <td>
                            <a href="<?= url('/editar-veiculo/' . $vehicle->id) ?>">Editar</a> -
                            <a href="<?= url('/excluir-veiculo/' . $vehicle->id) ?>"
                               onclick="return confirm('Você realmente deseja excluir este veículo? Esta ação não poderá ser desfeita!')">
                                Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</section>

<?php $v->start('scripts') ?>
<script>
    const form = document.querySelector("#search_form");

    form.addEventListener("submit", async function (event) {
        event.preventDefault();

        const request = await fetch('<?= url("/pesquisar")?>', {
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
<?php $v->end() ?>
