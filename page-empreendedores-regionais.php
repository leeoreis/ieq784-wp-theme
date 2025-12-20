<?php
/**
 * Template Name: Empreendedores Regionais
 * 
 * @package Regiao_784_Theme
 */

get_header();

// Buscar configurações do admin
$empreendedores_title = get_option('chomneq_empreendedores_title', 'Bem-vindo à Feira de Empreendedorismo');
$empreendedores_description = get_option('chomneq_empreendedores_description', 'Descubra expositores incríveis, conecte-se com empreendedores e explore produtos e serviços únicos!');
$empreendedores_button_text = get_option('chomneq_empreendedores_button_text', '📝 Você é expositor? Cadastre-se aqui!');
$empreendedores_button_url = get_option('chomneq_empreendedores_button_url', home_url('/empreendedores-regionais/cadastro-expositor'));

$empreendedores_secondary_cta_enabled = get_option('chomneq_empreendedores_secondary_cta_enabled', '0');
$empreendedores_secondary_cta_text = get_option('chomneq_empreendedores_secondary_cta_text');
$empreendedores_secondary_cta_text = !empty($empreendedores_secondary_cta_text) ? $empreendedores_secondary_cta_text : 'Você é visitante? Confirme sua presença';
$empreendedores_secondary_cta_url = get_option('chomneq_empreendedores_secondary_cta_url');
$empreendedores_secondary_cta_url = !empty($empreendedores_secondary_cta_url) ? $empreendedores_secondary_cta_url : home_url('/empreendedores-regionais');
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1><?php echo esc_html($empreendedores_title); ?></h1>
            <p><?php echo esc_html($empreendedores_description); ?></p>
            
            <div class="hero-cta">
                <a href="<?php echo esc_url($empreendedores_button_url); ?>" class="btn-cadastro-expositor">
                    <?php echo esc_html($empreendedores_button_text); ?>
                </a>
                <?php if ($empreendedores_secondary_cta_enabled === '1') : ?>
                    <a href="<?php echo esc_url($empreendedores_secondary_cta_url); ?>" class="btn-cadastro-expositor">
                        <?php echo esc_html($empreendedores_secondary_cta_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Filtros -->
<section class="filters-section">
    <div class="container">
        <form method="get" action="<?php echo esc_url(home_url('/empreendedores-regionais')); ?>" class="filters-container">
            <div class="filter-group">
                <label for="search">Buscar Expositor:</label>
                <input type="text" id="search" name="busca" placeholder="Digite o nome..." value="<?php echo isset($_GET['busca']) ? esc_attr($_GET['busca']) : ''; ?>">
            </div>
            
            <div class="filter-group">
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria">
                    <option value="">Todas as Categorias</option>
                    <?php
                    // Função recursiva para exibir categorias hierárquicas
                    function chomneq_display_categoria_options($parent = 0, $level = 0, $selected_slug = '') {
                        $categorias = get_terms(array(
                            'taxonomy' => 'categoria_expositor',
                            'hide_empty' => true,
                            'parent' => $parent,
                        ));
                        
                        foreach ($categorias as $categoria) {
                            $indent = str_repeat('&nbsp;&nbsp;&nbsp;', $level);
                            $prefix = $level > 0 ? '└ ' : '';
                            $selected = ($selected_slug == $categoria->slug) ? 'selected' : '';
                            
                            echo '<option value="' . esc_attr($categoria->slug) . '" ' . $selected . '>';
                            echo $indent . $prefix . esc_html($categoria->name);
                            echo '</option>';
                            
                            // Chamar recursivamente para subcategorias
                            chomneq_display_categoria_options($categoria->term_id, $level + 1, $selected_slug);
                        }
                    }
                    
                    $selected_categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
                    chomneq_display_categoria_options(0, 0, $selected_categoria);
                    ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="regional">Regional:</label>
                <select id="regional" name="regional">
                    <option value="">Todas as Regionais</option>
                    <?php
                    $regionais = get_terms(array(
                        'taxonomy' => 'regional_expositor',
                        'hide_empty' => true,
                    ));
                    
                    foreach ($regionais as $regional) {
                        $selected = (isset($_GET['regional']) && $_GET['regional'] == $regional->slug) ? 'selected' : '';
                        echo '<option value="' . esc_attr($regional->slug) . '" ' . $selected . '>' . esc_html($regional->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label>&nbsp;</label>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn-filter">Filtrar</button>
                    <a href="<?php echo esc_url(home_url('/empreendedores-regionais')); ?>" class="btn-filter btn-reset">Limpar</a>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Grid de Expositores -->
<section class="expositores-grid">
    <div class="container">
        <div class="grid-header">
            <h2>Nossos Expositores</h2>
            <?php
            // Corrigir paginação para funcionar em páginas customizadas
            $paged = 1;
            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } elseif (get_query_var('page')) {
                $paged = get_query_var('page');
            } elseif (isset($_GET['paged'])) {
                $paged = intval($_GET['paged']);
            }

            $args = array(
                'post_type' => 'expositor',
                'posts_per_page' => 12,
                'orderby' => 'title',
                'order' => 'ASC',
                'post_status' => 'publish',
                'paged' => $paged,
            );
            
            // Adicionar filtro de busca expandida (título + conteúdo + meta fields)
            if (!empty($_GET['busca'])) {
                $search_term = sanitize_text_field($_GET['busca']);
                
                // Usar posts_where para busca customizada
                add_filter('posts_where', function($where) use ($search_term) {
                    global $wpdb;
                    
                    // Busca expandida: título, conteúdo, excerpt E meta fields
                    $custom_where = " AND (
                        ({$wpdb->posts}.post_title LIKE '%" . esc_sql($wpdb->esc_like($search_term)) . "%')
                        OR ({$wpdb->posts}.post_content LIKE '%" . esc_sql($wpdb->esc_like($search_term)) . "%')
                        OR ({$wpdb->posts}.post_excerpt LIKE '%" . esc_sql($wpdb->esc_like($search_term)) . "%')
                        OR EXISTS (
                            SELECT 1 FROM {$wpdb->postmeta} 
                            WHERE {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID 
                            AND {$wpdb->postmeta}.meta_value LIKE '%" . esc_sql($wpdb->esc_like($search_term)) . "%'
                        )
                    )";
                    
                    return $where . $custom_where;
                }, 10, 1);
            }
            
            // Adicionar filtros de taxonomia (categoria e/ou regional)
            $tax_query = array('relation' => 'AND');
            
            if (!empty($_GET['categoria'])) {
                $tax_query[] = array(
                    'taxonomy' => 'categoria_expositor',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['categoria']),
                );
            }
            
            if (!empty($_GET['regional'])) {
                $tax_query[] = array(
                    'taxonomy' => 'regional_expositor',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['regional']),
                );
            }
            
            if (count($tax_query) > 1) {
                $args['tax_query'] = $tax_query;
            }
            
            $expositores_query = new WP_Query($args);
            
            // Remover filtro de busca customizada após a query
            if (!empty($_GET['busca'])) {
                remove_all_filters('posts_where');
            }
            ?>
            <span class="results-count">
                <?php echo $expositores_query->found_posts; ?> expositor(es) encontrado(s)
            </span>
        </div>
        
        <?php if ($expositores_query->have_posts()) : ?>
            <div class="expositores-container">
                <?php while ($expositores_query->have_posts()) : $expositores_query->the_post(); ?>
                    <?php get_template_part('template-parts/content', 'expositor-card'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php if ($expositores_query->max_num_pages > 1) : ?>
                <div class="pagination">
                    <?php
                    // Corrigir paginação para funcionar em páginas customizadas
                    $current_paged = $paged;
                    echo paginate_links(array(
                        'base' => get_permalink() . 'page/%#%/',
                        'format' => 'page/%#%/',
                        'total' => $expositores_query->max_num_pages,
                        'current' => $current_paged,
                        'prev_text' => '« Anterior',
                        'next_text' => 'Próximo »',
                    ));
                    ?>
                </div>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="text-center">Nenhum expositor encontrado. Tente uma busca diferente!</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
