<?php
/**
 * Template Name: Em Construção
 * 
 * @package Regiao_784_Theme
 */

// Buscar igrejas regionais (exceto "Região 784" e "IEQ Estadual")
$igrejas = new WP_Query(array(
    'post_type' => 'igreja_regional',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'meta_value_num',
    'meta_key' => '_igreja_ordem',
    'order' => 'ASC',
    'post__not_in' => array_merge(
        get_posts(array(
            'post_type' => 'igreja_regional',
            'title' => 'Região 784',
            'posts_per_page' => 1,
            'fields' => 'ids'
        )),
        get_posts(array(
            'post_type' => 'igreja_regional',
            'title' => 'IEQ Estadual',
            'posts_per_page' => 1,
            'fields' => 'ids'
        ))
    )
));

// Buscar atividades fixas (sempre exibidas, sem filtro de data)
$atividades_fixas = new WP_Query(array(
    'post_type' => 'atividade',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order title',
    'order' => 'ASC',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => '_atividade_ativa',
            'value' => '1',
            'compare' => '='
        ),
        array(
            'key' => '_atividade_fixa',
            'value' => '1',
            'compare' => '='
        )
    )
));

// Buscar atividades com data (em andamento ou futuras, e ativas, não fixas)
$hoje = wp_date('Y-m-d');
$atividades_datas = new WP_Query(array(
    'post_type' => 'atividade',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'meta_value',
    'meta_key' => '_atividade_data_inicio',
    'order' => 'ASC',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => '_atividade_data_fim',
            'value' => $hoje,
            'compare' => '>=',
            'type' => 'DATE'
        ),
        array(
            'key' => '_atividade_ativa',
            'value' => '1',
            'compare' => '='
        ),
        array(
            'relation' => 'OR',
            array(
                'key' => '_atividade_fixa',
                'value' => '1',
                'compare' => '!='
            ),
            array(
                'key' => '_atividade_fixa',
                'compare' => 'NOT EXISTS'
            )
        )
    )
));

// Combinar os posts manualmente iterando sobre ambas as queries
$all_atividades = array();

// Adicionar atividades fixas primeiro
if ($atividades_fixas->have_posts()) {
    while ($atividades_fixas->have_posts()) {
        $atividades_fixas->the_post();
        $all_atividades[] = $post;
    }
    wp_reset_postdata();
}

// Adicionar atividades com data depois
if ($atividades_datas->have_posts()) {
    while ($atividades_datas->have_posts()) {
        $atividades_datas->the_post();
        $all_atividades[] = $post;
    }
    wp_reset_postdata();
}

// Criar uma query "fake" para o loop usar corretamente
$atividades = new WP_Query(array(
    'post_type' => 'atividade',
    'post__in' => array_map(function($p) { return $p->ID; }, $all_atividades),
    'orderby' => 'post__in',
    'posts_per_page' => -1
));
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal da Região 784 - IEQ Rio de Janeiro</title>
    <!-- Lottie carregado com defer para não bloquear parsing -->
    <link rel="modulepreload" href="https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            min-height: 100vh;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #000 !important;
            min-height: 100vh;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        
        .page-content {
            flex: 1;
        }
        
        .hero {
            text-align: center;
            padding: 3rem 2rem;
            color: white;
            position: relative;
            background: #000;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 60vh;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero::after {
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,1) 100%);
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        
        .hero > * {
            position: relative;
            z-index: 2;
        }
        
        .hero .icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
            display: inline-block;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto 2rem;
        }
        
        .loader {
            display: inline-block;
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .section {
            background: white;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        
        .section-title {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .section-title .emoji {
            font-size: 2.5rem;
        }
        
        .date-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin: 1.5rem 0 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border: 2px solid #dee2e6;
        }
        
        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: 2px solid #dee2e6;
            background: white;
            color: #495057;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
            flex: 1;
            min-width: 140px;
        }
        
        .filter-btn:hover {
            background: #007bff;
            color: white;
            border-color: #007bff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.3);
        }
        
        .filter-btn.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-color: #0056b3;
            box-shadow: 0 4px 12px rgba(0,123,255,0.4);
        }
        
        .date-filter-mobile {
            display: none;
            margin: 1.5rem 0 2rem;
        }
        
        .filter-select {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #dee2e6;
            background: white;
            color: #495057;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23495057' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 3rem;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }
        
        .section-subtitle {
            color: #7f8c8d;
            margin-bottom: 2rem;
            font-size: 1.05rem;
        }
        
        /* Igrejas Regionais */
        .igrejas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .igreja-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .igreja-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }
        
        .igreja-card.sede .igreja-header::after {
            content: '⭐ SEDE';
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.95);
            color: #667eea;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .igreja-header {
            position: relative;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }
        
        .igreja-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
        }
        
        .igreja-header h3 {
            position: relative;
            z-index: 1;
            color: white;
            margin: 0;
            font-size: 1.3rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .igreja-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }
        
        .igreja-info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.95rem;
            color: #555;
            line-height: 1.5;
        }
        
        .igreja-info-item .icon {
            font-size: 1.2rem;
            flex-shrink: 0;
            margin-top: 2px;
        }
        
        .instagram-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.35rem 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: auto;
        }
        
        .instagram-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        /* Atividades */
        .atividades-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .atividade-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
            position: relative;
        }
        
        
        .atividade-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        
        .atividade-header {
            color: white;
            padding: 2rem 1.5rem;
            position: relative;
            overflow: hidden;
            min-height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .atividade-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
            z-index: 1;
        }
        
        .atividade-header h3 {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .atividade-meta {
            font-size: 0.9rem;
            position: relative;
            z-index: 2;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        }
        
        .atividade-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }
        
        .atividade-description {
            color: #555;
            line-height: 1.6;
        }
        
        .atividade-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .atividade-regional {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 3;
            padding-left: 15px;
            background: rgba(0,0,0,0.7) !important;
            font-weight: bold;
        }

        .item-regional {
            height: 35px;
            background: transparent !important;
            color: #fff !important;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #666;
            font-size: 0.95rem;
        }
        
        .info-item .icon {
            font-size: 1.2rem;
        }
        
        .atividade-link {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.85rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            margin-top: auto;
        }
        
        .atividade-link:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary {
            display: inline-block;
            background: white;
            color: #667eea;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-top: 1rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }
        
        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        /* Botões de Filtro */
        .filter-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
            justify-content: center;
        }
        
        .filter-modal-btn {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            min-width: 200px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .filter-modal-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-color: #667eea;
        }
        
        .filter-icon {
            font-size: 1.5rem;
        }
        
        .filter-label {
            font-size: 0.85rem;
            color: #666;
            font-weight: 500;
        }
        
        .filter-value {
            font-size: 1rem;
            color: #333;
            font-weight: 600;
        }
        
        .clear-filters-btn {
            background: #ff4757;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(255,71,87,0.3);
        }
        
        .clear-filters-btn:hover {
            background: #ff3838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,71,87,0.4);
        }
        
        /* Modal Styles */
        .filter-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }
        
        .filter-modal.active {
            display: flex;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .filter-modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: slideUp 0.3s ease;
        }
        
        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .filter-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .filter-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
        }
        
        .close-modal {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            font-size: 2rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            line-height: 1;
        }
        
        .close-modal:hover {
            background: rgba(255,255,255,0.3);
            transform: rotate(90deg);
        }
        
        .filter-modal-body {
            padding: 1.5rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .filter-option {
            background: #f8f9fa;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 1rem 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            text-align: left;
            font-weight: 500;
            color: #333;
        }
        
        .filter-option:hover {
            background: #e9ecef;
            border-color: #667eea;
            transform: translateX(5px);
        }
        
        .filter-option.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero .icon { font-size: 3.5rem; }
            .hero p { font-size: 1rem; }
            
            .section { padding: 2rem 1.5rem; }
            .section-title { font-size: 1.5rem; }
            
            .igrejas-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1rem;
            }
            
            .atividades-grid {
                grid-template-columns: 1fr;
            }
            
            .filter-buttons {
                flex-direction: column;
            }
            
            .filter-modal-btn {
                min-width: 100%;
            }
            
            .filter-modal-content {
                width: 95%;
                max-height: 85vh;
            }
        }
    </style>
    <?php wp_head(); ?>
</head>
<body>
    <?php
    // Buscar configurações da hero
    $hero_bg_image_id = get_option('chomneq_hero_background_image', '');
    $hero_bg_image_url = $hero_bg_image_id ? wp_get_attachment_image_url($hero_bg_image_id, 'full') : '';
    $hero_style = $hero_bg_image_url ? 'style="background-image: url(' . esc_url($hero_bg_image_url) . ');"' : '';
    
    $hero_logo_image_id = get_option('chomneq_hero_logo_image', '');
    $hero_logo_image_url = $hero_logo_image_id ? wp_get_attachment_image_url($hero_logo_image_id, 'full') : 'https://assets-ieq784.leoreis.dev.br/wp-content/uploads/logo-784.PNG';
    
    $hero_title = get_option('chomneq_hero_title', 'Bem-vindo ao Portal da Região 784');
    $hero_subtitle = get_option('chomneq_hero_subtitle', 'Igreja do Evangelho Quadrangular no Rio de Janeiro');
    $hero_description = get_option('chomneq_hero_description', 'Conheça nossas igrejas regionais, atividades e programação de eventos.');
    ?>
    <div class="page-content">
    <div class="hero" <?php echo $hero_style; ?>>
        <?php if ($hero_logo_image_url) : ?>
            <img src="<?php echo esc_url($hero_logo_image_url); ?>" alt="Logo Região 784" style="width: 300px; margin: 1rem auto; display: block;" />
        <?php endif; ?>
        <h2><?php echo esc_html($hero_title); ?></h2>
        <p><?php echo esc_html($hero_subtitle); ?></p>
        <br />
        <br />
        <p><?php echo esc_html($hero_description); ?></p>

    </div>
    
    <div class="container">
               
        <?php if ($atividades->have_posts()) : ?>
        <!-- Seção de Atividades -->
        <div class="section">
            <h2 class="section-title">
                🗓 Agenda Regional
            </h2>
            <p class="section-subtitle">Eventos e atividades programadas para toda a região 784</p>
            
            <!-- Botões de Filtro -->
            <div class="filter-buttons">
                <button class="filter-modal-btn" id="openDateFilter">
                    <span class="filter-icon">🗓</span>
                    <span class="filter-label">Filtrar por Data</span>
                    <span class="filter-value" id="dateFilterValue">Próximos 3 meses</span>
                </button>
                <button class="filter-modal-btn" id="openRegionalFilter">
                    <span class="filter-icon">📍</span>
                    <span class="filter-label">Filtrar por Regional</span>
                    <span class="filter-value" id="regionalFilterValue">Todas</span>
                </button>
                <button class="clear-filters-btn" id="clearFilters" style="display: none;">
                    ✕ Limpar Filtros
                </button>
            </div>
            
            <div class="atividades-grid">
                <?php while ($atividades->have_posts()) : $atividades->the_post(); 
                    $data_inicio = get_post_meta(get_the_ID(), '_atividade_data_inicio', true);
                    $data_fim = get_post_meta(get_the_ID(), '_atividade_data_fim', true);
                    $local = get_post_meta(get_the_ID(), '_atividade_local', true);
                    $link = get_post_meta(get_the_ID(), '_atividade_link', true);
                    $cta_texto = get_post_meta(get_the_ID(), '_atividade_cta_texto', true);
                    $cor = get_post_meta(get_the_ID(), '_atividade_cor', true) ?: '#667eea';
                    $fixa = get_post_meta(get_the_ID(), '_atividade_fixa', true);
                    $regional_id = get_post_meta(get_the_ID(), '_atividade_regional', true);
                    
                    // Buscar informações da regional
                    $regional_nome = '';
                    if ($regional_id) {
                        $regional = get_post($regional_id);
                        if ($regional) {
                            $regional_nome = $regional->post_title;
                        }
                    }
                    
                    // Texto do botão: usar custom ou fallback
                    $texto_botao = !empty($cta_texto) ? $cta_texto : 'Saiba Mais';
                    
                    // Formatar data
                    $data_formatada = '';
                    if ($data_inicio) {
                        $data_inicio_obj = DateTime::createFromFormat('Y-m-d', $data_inicio);
                        if ($data_fim && $data_fim !== $data_inicio) {
                            $data_fim_obj = DateTime::createFromFormat('Y-m-d', $data_fim);
                            $data_formatada = $data_inicio_obj->format('d/m/Y') . ' a ' . $data_fim_obj->format('d/m/Y');
                        } else {
                            $data_formatada = $data_inicio_obj->format('d/m/Y');
                        }
                    }
                    
                    $has_thumb = has_post_thumbnail();
                    
                    // Calcular timestamp para filtro (atividades fixas usam timestamp 0 para sempre aparecer)
                    $data_timestamp = ($fixa === '1') ? 0 : ($data_inicio ? strtotime($data_inicio) : 0);
                    
                    // Classe adicional para atividades fixas
                    $fixa_class = ($fixa === '1') ? ' atividade-fixa' : '';
                ?>
                <div class="atividade-card<?php echo $fixa_class; ?>" data-date="<?php echo esc_attr($data_timestamp); ?>" data-regional="<?php echo esc_attr($regional_id ? $regional_id : '0'); ?>" data-fixa="<?php echo esc_attr($fixa === '1' ? '1' : '0'); ?>">
                    <div class="atividade-header" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>');">
                        
                        <h3><?php the_title(); ?></h3>
                        <?php if ($data_formatada) : ?>
                            <div class="atividade-meta">🗓 <?php echo esc_html($data_formatada); ?></div>
                        <?php elseif ($fixa === '1') : ?>
                            <br />
                            <!-- <div class="atividade-meta">📌 Atividade Permanente</div> -->
                        <?php endif; ?>
                    </div>
                    
                    <div class="atividade-body">
                        <?php if (get_the_content()) : ?>
                            <div class="atividade-description">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($local) : ?>
                        <div class="atividade-info">
                            <div class="info-item">
                                <span class="icon">📍</span>
                                <span><?php echo esc_html($local); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($regional_nome) : ?>
                        <div class="atividade-info atividade-regional">
                            <div class="info-item item-regional">
                                <span>Evento da <?php echo esc_html($regional_nome); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer" class="atividade-link">
                                <?php echo esc_html($texto_botao); ?> →
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <hr style="margin: 3rem 0 0;" />
            <div style="text-align: center; padding: 2rem 0;">
                <a href="/empreendedores-regionais" class="btn-primary">🛍️ Veja o catálogo de Empreendedores Regionais</a>
            </div>
        </div>
        
        <!-- Modal de Filtro de Data -->
        <div id="dateFilterModal" class="filter-modal">
            <div class="filter-modal-content">
                <div class="filter-modal-header">
                    <h3>📅 Filtrar por Data</h3>
                    <button class="close-modal" data-modal="dateFilterModal">&times;</button>
                </div>
                <div class="filter-modal-body">
                    <button class="filter-option" data-months="1">Próximo mês</button>
                    <button class="filter-option" data-months="2">Próximos 2 meses</button>
                    <button class="filter-option active" data-months="3">Próximos 3 meses</button>
                    <button class="filter-option" data-months="6">Próximos 6 meses</button>
                    <button class="filter-option" data-months="12">Próximos 12 meses</button>
                </div>
            </div>
        </div>
        
        <!-- Modal de Filtro de Regional -->
        <div id="regionalFilterModal" class="filter-modal">
            <div class="filter-modal-content">
                <div class="filter-modal-header">
                    <h3>📍 Filtrar por Regional</h3>
                    <button class="close-modal" data-modal="regionalFilterModal">&times;</button>
                </div>
                <div class="filter-modal-body">
                    <button class="filter-option active" data-regional="0">Todas as Regionais</button>
                    <?php 
                    // Buscar todas as regionais para o filtro
                    $regionais_filter = new WP_Query(array(
                        'post_type' => 'igreja_regional',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ));
                    
                    while ($regionais_filter->have_posts()) : $regionais_filter->the_post();
                    ?>
                        <button class="filter-option" data-regional="<?php echo get_the_ID(); ?>">
                            <?php the_title(); ?>
                        </button>
                    <?php 
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
        
        <?php endif; wp_reset_postdata(); ?>



        <?php if ($igrejas->have_posts()) : ?>
        <!-- Seção de Igrejas Regionais -->
        <div class="section">
            <h2 class="section-title">
                📍 Regionais
            </h2>
            <p class="section-subtitle">Igrejas que fazem parte da nossa região</p>
            
            <div class="igrejas-grid">
                <?php while ($igrejas->have_posts()) : $igrejas->the_post(); 
                    $instagram = get_post_meta(get_the_ID(), '_igreja_instagram', true);
                    $pastor = get_post_meta(get_the_ID(), '_igreja_pastor', true);
                    $endereco = get_post_meta(get_the_ID(), '_igreja_endereco', true);
                    $has_thumb = has_post_thumbnail();
                    $is_sede = get_post_meta(get_the_ID(), '_igreja_sede', true);
                    $sede_class = ($is_sede === '1') ? ' sede' : '';
                    $thumb_url = $has_thumb ? get_the_post_thumbnail_url(get_the_ID(), 'large') : '';
                ?>
                <div class="igreja-card<?php echo $sede_class; ?>">
                    <div class="igreja-header" style="<?php if ($thumb_url) echo 'background-image: url(' . esc_url($thumb_url) . ');'; ?>">
                        <h3><?php the_title(); ?></h3>
                    </div>
                    <div class="igreja-body">
                        <?php if ($pastor) : ?>
                        <div class="igreja-info-item">
                            <span class="icon">👤</span>
                            <span><strong>Titular:</strong> <?php echo esc_html($pastor); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($endereco) : ?>
                        <div class="igreja-info-item">
                            <span class="icon">📍</span>
                            <span><?php echo nl2br(esc_html($endereco)); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($instagram) : ?>
                            <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" class="instagram-link">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                <span>Seguir no Instagram</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; wp_reset_postdata(); ?>
        
    </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const atividadeCards = document.querySelectorAll('.atividade-card');
        const dateFilterModal = document.getElementById('dateFilterModal');
        const regionalFilterModal = document.getElementById('regionalFilterModal');
        const openDateBtn = document.getElementById('openDateFilter');
        const openRegionalBtn = document.getElementById('openRegionalFilter');
        const clearFiltersBtn = document.getElementById('clearFilters');
        const dateFilterValue = document.getElementById('dateFilterValue');
        const regionalFilterValue = document.getElementById('regionalFilterValue');
        
        // Estado dos filtros
        let currentMonths = 3;
        let currentRegional = 0;
        const now = Math.floor(Date.now() / 1000);
        
        // Abrir modais
        openDateBtn.addEventListener('click', () => {
            dateFilterModal.classList.add('active');
        });
        
        openRegionalBtn.addEventListener('click', () => {
            regionalFilterModal.classList.add('active');
        });
        
        // Fechar modais
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal');
                document.getElementById(modalId).classList.remove('active');
            });
        });
        
        // Fechar modal ao clicar fora
        [dateFilterModal, regionalFilterModal].forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });
        
        // Função para aplicar filtros combinados
        function applyFilters() {
            // Calcular timestamp limite (agora + X meses)
            const limitDate = new Date();
            limitDate.setMonth(limitDate.getMonth() + currentMonths);
            const limitTimestamp = Math.floor(limitDate.getTime() / 1000);
            
            let visibleCount = 0;
            atividadeCards.forEach(card => {
                const cardDate = parseInt(card.getAttribute('data-date'));
                const cardRegional = parseInt(card.getAttribute('data-regional'));
                const isFixa = card.getAttribute('data-fixa') === '1';
                
                // Atividades fixas sempre passam no filtro de data
                const passDateFilter = isFixa || (cardDate >= now && cardDate <= limitTimestamp);
                
                // Verificar filtro de regional (0 = todas)
                const passRegionalFilter = currentRegional === 0 || cardRegional === currentRegional;
                
                // Mostrar apenas se passar ambos os filtros
                if (passDateFilter && passRegionalFilter) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Mostrar/esconder botão de limpar filtros
            if (currentMonths !== 3 || currentRegional !== 0) {
                clearFiltersBtn.style.display = 'block';
            } else {
                clearFiltersBtn.style.display = 'none';
            }
            
            // Mostrar mensagem se não houver atividades
            const grid = document.querySelector('.atividades-grid');
            let noResultsMsg = grid.querySelector('.no-results');
            
            if (visibleCount === 0) {
                if (!noResultsMsg) {
                    noResultsMsg = document.createElement('div');
                    noResultsMsg.className = 'no-results';
                    noResultsMsg.innerHTML = '<p style="text-align: center; padding: 3rem; color: #6c757d; font-size: 1.1rem;">📅 Nenhuma atividade encontrada com os filtros selecionados.</p>';
                    noResultsMsg.style.gridColumn = '2';
                    
                    if (window.innerWidth <= 768) {
                        noResultsMsg.style.gridColumn = '1';
                    }
                    
                    grid.appendChild(noResultsMsg);
                }
            } else {
                if (noResultsMsg) {
                    noResultsMsg.remove();
                }
            }
        }
        
        // Filtros de Data
        document.querySelectorAll('#dateFilterModal .filter-option').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remover active de todos
                document.querySelectorAll('#dateFilterModal .filter-option').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Atualizar filtro
                currentMonths = parseInt(this.getAttribute('data-months'));
                dateFilterValue.textContent = this.textContent;
                
                // Aplicar filtros e fechar modal
                applyFilters();
                dateFilterModal.classList.remove('active');
            });
        });
        
        // Filtros de Regional
        document.querySelectorAll('#regionalFilterModal .filter-option').forEach(btn => {
            btn.addEventListener('click', function() {
                // Remover active de todos
                document.querySelectorAll('#regionalFilterModal .filter-option').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Atualizar filtro
                currentRegional = parseInt(this.getAttribute('data-regional'));
                regionalFilterValue.textContent = this.textContent;
                
                // Aplicar filtros e fechar modal
                applyFilters();
                regionalFilterModal.classList.remove('active');
            });
        });
        
        // Limpar filtros
        clearFiltersBtn.addEventListener('click', function() {
            // Resetar para valores padrão
            currentMonths = 3;
            currentRegional = 0;
            
            // Atualizar labels
            dateFilterValue.textContent = 'Próximos 3 meses';
            regionalFilterValue.textContent = 'Todas';
            
            // Atualizar classes active
            document.querySelectorAll('#dateFilterModal .filter-option').forEach(btn => {
                btn.classList.toggle('active', parseInt(btn.getAttribute('data-months')) === 3);
            });
            document.querySelectorAll('#regionalFilterModal .filter-option').forEach(btn => {
                btn.classList.toggle('active', parseInt(btn.getAttribute('data-regional')) === 0);
            });
            
            // Aplicar filtros
            applyFilters();
        });
        
        // Aplicar filtro inicial (3 meses, todas regionais)
        applyFilters();
    });
    
    // Lazy-load do Lottie player após page load para não bloquear rendering
    window.addEventListener('load', function() {
        // Aguardar 500ms após load para garantir que conteúdo principal já renderizou
        setTimeout(function() {
            // Carregar script do Lottie
            const script = document.createElement('script');
            script.type = 'module';
            script.src = 'https://unpkg.com/@lottiefiles/dotlottie-wc@0.8.5/dist/dotlottie-wc.js';
            
            script.onload = function() {
                // Criar elemento Lottie
                const lottieEl = document.createElement('dotlottie-wc');
                lottieEl.setAttribute('src', 'https://lottie.host/a05e1752-91df-4669-b7ff-4d7ae5b0f9a9/DATc0OP9Ed.lottie');
                lottieEl.setAttribute('autoplay', '');
                lottieEl.setAttribute('loop', '');
                lottieEl.style.width = '300px';
                lottieEl.style.height = '200px';
                lottieEl.style.margin = '0 auto';
                
                // Substituir placeholder pela animação
                const container = document.getElementById('lottie-container');
                if (container) {
                    container.innerHTML = '';
                    container.appendChild(lottieEl);
                }
            };
            
            document.head.appendChild(script);
        }, 500);
    });
    </script>
    
    <?php get_footer(); ?>
