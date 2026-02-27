<?php
$qtd = get_sub_field('quantidade');
$args = array(
    'post_type' => 'parceiros',
    'posts_per_page' => -1,
    'orderby' => 'title',
	'order'   => 'ASC',
);

$parceiros = array();

if(!$qtd || $qtd == ''){
    $qtd = 30;
}


// The Query
$the_query = new WP_Query( $args );

// The Loop
if ( $the_query->have_posts() ) {
	
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$parceiros[] = get_the_ID();
	}
	
} 

wp_reset_postdata();

$total =  count($parceiros);

?>

<div class="bg-bloco-parceiros mt-5">
    <div class="container pt-5 pb-5">
        <div class="row">
            <h2 class="col-12 title-bloc-parceiros mt-3 mb-3 text-center">Parceiros do projeto</h2>
        </div>
        <div class="row">
            <div class="col-12">

                <?php if($total <= $qtd && $total > 0): ?>

                    <div class="container carousel_part">

                        <?php
                            $i = 0;
                            foreach($parceiros as $parceiro){
                                $imagem = get_field('foto_principal_parceiro', $parceiro);
                                $img_url = '';
                                if(is_numeric($imagem)){
                                    $img_url = wp_get_attachment_image_url($imagem, 'parceiros');
                                } else {
                                    $img_url = $imagem;
                                }
                                if($i == 0){
                                    echo '<div class="row">';
                                }

                                echo '<div class="col mb-3">
                                        <a href="' . get_the_permalink($parceiro) . '"><img src="' . $img_url . '" class="d-block w-100" alt="Logo ' . get_the_title($parceiro) . '"></a>
                                    </div>';
                                $i++;

                                //echo "<pre>";
                                //print_r($imagem);
                                //echo "</pre>";
                                
                                if($i == 5){
                                    echo "</div>";
                                    $i = 0;
                                }
                            }

                            if($total % 5 != 0){
                                $complem =  5 - ($total % 5);
                                
                                for ($i = 1; $i <= $complem; $i++) {
                                    echo '<div class="col"></div>';
                                }
                                echo "</div>";
                            } 

                        ?>                                      

                    </div> 

                <?php else: ?>

                    <?php
                        $menuItems = array_slice( $parceiros, 0, 10 );
                        $totalSlides = ceil( $total / $qtd );
                    ?>

                    <div id="carouselExampleIndicators" class="carousel slide carousel_part" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php for ($i = 0; $i < $totalSlides; $i++): ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i; ?>" class="<?= $i == 0 ? 'active' : ''; ?>"></li>                            
                            <?php endfor; ?>
                        </ol>

                        <div class="carousel-inner">

                            <?php for ($i = 1; $i <= $totalSlides; $i++): ?>
                            
                                <div class="carousel-item <?= $i == 1 ? 'active' : ''; ?>">
                                    <div class="container">
                                        <?php
                                            $pagina = ($i * $qtd) - $qtd;
                                            $parceiroSlide = array_slice( $parceiros, $pagina, $qtd );
                                            $totalSlide = count($parceiroSlide);
                                            $j = 0;
                                            foreach( $parceiroSlide as $parceiro){
                                                $imagem = get_field('foto_principal_parceiro', $parceiro);
                                                $img_url = '';
                                                if(is_numeric($imagem)){
                                                    $img_url = wp_get_attachment_image_url($imagem, 'parceiros');
                                                } else {
                                                    $img_url = $imagem;
                                                }
                                                if($j == 0){
                                                    echo '<div class="row">';
                                                }

                                                echo '<div class="col mb-3">
                                                        <a href="' . get_the_permalink($parceiro) . '"><img src="' . $img_url . '" class="d-block w-100" alt="Logo ' . get_the_title($parceiro) . '"></a>
                                                    </div>';
                                                $j++;

                                                //echo "<pre>";
                                                //print_r($imagem);
                                                //echo "</pre>";
                                                
                                                if($j == 5){
                                                    echo "</div>";
                                                    $j = 0;
                                                }
                                            }

                                            if($totalSlide % 5 != 0){
                                                $complem =  5 - ($totalSlide % 5);
                                                
                                                for ($i = 1; $i <= $complem; $i++) {
                                                    echo '<div class="col"></div>';
                                                }
                                                echo "</div>";
                                            } 

                                        ?>                                    

                                    </div>                        
                                </div>

                            <?php endfor; ?>

                            
                        </div>
                        
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>