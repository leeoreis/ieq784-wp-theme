<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
            <?php 
            $hero_logo_image_id = get_option('chomneq_hero_logo_image', '');
            if ($hero_logo_image_id) {
                $hero_logo_image_url = wp_get_attachment_image_url($hero_logo_image_id, 'medium');
                echo '<img src="' . esc_url($hero_logo_image_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '" style="height: 50px; width: auto;" />';
            } else {
                bloginfo('name');
            }
            ?>
        </a>
        
        <nav class="main-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'nav-menu',
                'container' => false,
                'fallback_cb' => false,
            ));
            ?>
        </nav>
    </div>
</header>
