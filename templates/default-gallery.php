<?php

$post_ID = $post->ID;
$post_title = $post->post_title;
$post_link = get_permalink( $post_ID );
$post_img = get_the_post_thumbnail_url( $post_ID );

?>

<div class="hgw_carousel_item">
    <a href="<?= $post_link ?>" class="hgw_anchor_container">
        <div class="hgw_bg_blur" style="background-image: url(<?= $post_img ?>);"></div>
        <div class="hgw_carousel_img" style="background-image: url(<?= $post_img ?>);"></div>
        <div class="hgw_title_container">
            <p><?= $post_title ?></p>
        </div>
    </a>
</div>