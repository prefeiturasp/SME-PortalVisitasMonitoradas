<?php
$img = get_sub_field('imagem');
$titulo = get_sub_field('titulo');
$descricao = get_sub_field('descricao');
$ativar = get_sub_field('ativar_botao');
//echo "<pre>";
//print_r($img);
//echo "</pre>";
?>

<div class="card">
    <?php if($img && $img !=''): ?>
        <img class="card-img-top" src="<?= $img['url']; ?>" alt="<?= $img['alt']; ?>" />
    <?php endif; ?>

    <div class="card-body">
        <?php if($titulo && $titulo !=''): ?>
            <h4 class="card-title"><?= $titulo; ?></h4>
        <?php endif; ?>
        <?php if($descricao && $descricao !=''): ?>
            <p class="card-text"><?= $descricao; ?></p>
        <?php endif; ?>
        <?php if($ativar): ?>
            <a class="btn btn-card" href="<?= get_sub_field('link_do_botao'); ?>"><?= get_sub_field('texto_botao'); ?></a>
        <?php endif; ?>
    </div>
</div>