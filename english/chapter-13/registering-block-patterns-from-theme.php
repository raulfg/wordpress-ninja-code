<?php
/**
 * Title: Hero with image and CTA
 * Slug: mi-tema/hero-cta
 * Categories: featured
 * Keywords: hero, image, homepage, cta
 */
?>
<!-- wp:cover {"overlayColor":"primary","minHeight":500,"minHeightUnit":"px"} -->
<div class="wp-block-cover" style="min-height:500px">
    <span class="has-primary-background-color wp-block-cover__background has-background-dim"></span>
    <div class="wp-block-cover__inner-container">
        <!-- wp:heading {"textAlign":"center","level":1,"textColor":"background"} -->
        <h1 class="wp-block-heading has-text-align-center has-background-color has-text-color">
            Main site title
        </h1>
        <!-- /wp:heading -->
        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
        <div class="wp-block-buttons">
            <!-- wp:button {"backgroundColor":"accent","textColor":"background"} -->
            <div class="wp-block-button">
                <a class="wp-block-button__link has-background-color has-accent-background-color has-text-color wp-element-button">
                    Call to action
                </a>
            </div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->
    </div>
</div>
<!-- /wp:cover -->
