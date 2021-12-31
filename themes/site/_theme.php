<!doctype html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? CONF_SITE_NAME ?></title>
</head>
<body>

</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? CONF_SITE_NAME ?></title>

    <link rel="stylesheet" href="<?= theme("/assets/css/boot.css"); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/message.css"); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/style.css"); ?>"/>
</head>
<body>
<div class="ajax_response"><?php echo flash(); ?></div>
<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<!--HEADER-->
<header class="main_header">
    <h1>Cadastro de veículos</h1>
</header>
<header class="sub_header">
    <nav class="sub_header_nav">
        <ul>
            <li><a href="<?= url() ?>">Listagem de veículos</a></li>
            <li><a href="<?= url('/cadastrar-veiculo') ?>">Cadastrar novo veículo</a></li>
        </ul>
    </nav>
</header>

<!--CONTENT-->
<main class="main_content">
    <?= $v->section("content"); ?>
</main>
<script src="<?= theme("/assets/js/scripts.js"); ?>"></script>
<?= $v->section("scripts"); ?>
</body>
</html>