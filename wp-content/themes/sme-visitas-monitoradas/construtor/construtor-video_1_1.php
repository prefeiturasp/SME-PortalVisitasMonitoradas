<?php
$tamanho = get_sub_field('limite_tamanho');
$tamanhoDesk = get_sub_field('tam_desk');
$tamanhoMob = get_sub_field('tam_mob');

echo '<div class="container">';
    if($tamanho){        
        if($tamanhoDesk == $tamanhoMob){
            echo '<div class="mt-3 mb-3 video-1" style="width: ' . $tamanhoDesk . '; margin: 0 auto;"><div class="video-container">'.get_sub_field('fx_video_1_1').'</div></div>';
        } else {
            echo '<div class="mt-3 mb-3 video-1 d-none d-lg-block" style="width: ' . $tamanhoDesk . '; margin: 0 auto;"><div class="video-container">'.get_sub_field('fx_video_1_1').'</div></div>';
            echo '<div class="mt-3 mb-3 video-1 d-block d-lg-none" style="width: ' . $tamanhoMob . '; margin: 0 auto;"><div class="video-container">'.get_sub_field('fx_video_1_1').'</div></div>';
        }        
    } else {        
        echo '<div class="mt-3 mb-3 video-1"><div class="video-container">'.get_sub_field('fx_video_1_1').'</div></div>';    
    }
echo '</div>';