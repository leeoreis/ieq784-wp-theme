<?php
/**
 * Template para arquivo de taxonomia - Categoria de Expositor
 * 
 * @package Chomneq_Template
 */

get_header();
?>

<section class="hero-section" style="padding: 2rem 0;">
    <div class="container">
        <div class="hero-content">
            <h1>Categoria: <?php single_term_title(); ?></h1>
            <?php if (term_description()) : ?>
                <p><?php echo term_description(); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="expositores-grid">
    <div class="container">
        <div class="grid-header">
            <h2>Expositores nesta Categoria</h2>
            <span class="results-count">
                <?php 
                global $wp_query;
                echo $wp_query->found_posts; 
                ?> expositor(es) encontrado(s)
            </span>
        </div>
        
        <?php if (have_posts()) : ?>
            <div class="expositores-container">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'expositor-card'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php the_posts_pagination(array(
                'prev_text' => '« Anterior',
                'next_text' => 'Próximo »',
            )); ?>
        <?php else : ?>
            <p class="text-center">Nenhum expositor encontrado nesta categoria.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
