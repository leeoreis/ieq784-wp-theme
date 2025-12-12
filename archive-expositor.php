<?php
/**
 * Template para arquivo de Custom Post Type - Expositor
 * 
 * @package Chomneq_Template
 */

get_header();
?>

<section class="hero-section" style="padding: 2rem 0;">
    <div class="container">
        <div class="hero-content">
            <h1>Todos os Expositores</h1>
            <p>Conheça todos os expositores da nossa feira de empreendedorismo</p>
        </div>
    </div>
</section>

<section class="filters-section">
    <div class="container">
        <form method="get" action="<?php echo esc_url(get_post_type_archive_link('expositor')); ?>" class="filters-container">
            <div class="filter-group">
                <label for="search">Buscar Expositor:</label>
                <input type="text" id="search" name="s" placeholder="Digite o nome..." value="<?php echo get_search_query(); ?>">
            </div>
            
            <div class="filter-group">
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria">
                    <option value="">Todas as Categorias</option>
                    <?php
                    $categorias = get_terms(array(
                        'taxonomy' => 'categoria_expositor',
                        'hide_empty' => true,
                    ));
                    
                    foreach ($categorias as $categoria) {
                        $selected = (isset($_GET['categoria']) && $_GET['categoria'] == $categoria->slug) ? 'selected' : '';
                        echo '<option value="' . esc_attr($categoria->slug) . '" ' . $selected . '>' . esc_html($categoria->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn-filter">Filtrar</button>
            </div>
        </form>
    </div>
</section>

<section class="expositores-grid">
    <div class="container">
        <div class="grid-header">
            <h2>Expositores</h2>
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
            <p class="text-center">Nenhum expositor encontrado.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
