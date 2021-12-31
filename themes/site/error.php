<?php $v->layout("_theme"); ?>

<article class="not_found">
    <div class="container content">
        <header class="not_found_header">
            <p class="error">&bull;<?= $error->code; ?>&bull;</p>
            <h1><?= $error->title; ?></h1>
            <p><?= $error->message; ?></p>
        </header>
    </div>
</article>