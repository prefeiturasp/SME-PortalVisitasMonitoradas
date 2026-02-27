<?php
$titleNews = get_sub_field('titulo');
$descNews = get_sub_field('descricao');
$txtBtnNews = get_sub_field('texto_botao');
$imgNews = get_sub_field('imagem');
$shortcode = get_sub_field('shortcode');
?>
<div class="container blc-news">
    <div class="row">
        <div class="col-12">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <h2 class="title-news"><?php echo $titleNews; ?></h2>
                        <p class="desc-news"><?php echo $descNews; ?></p>
                        <div class="form-news">
                            <?= do_shortcode("$shortcode"); ?>                            
                        </div>
                    </div>
                    <div class="col-sm-5"><img src="<?php echo $imgNews; ?>" alt="<?php echo $titleNews; ?>" width="405" height="308"></div>
                </div>
            </div>
        </div>
    </div>
</div>