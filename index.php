<?php
/**
 * Template padrão - Redireciona para página em construção ou empreendedores-regionais
 * 
 * @package Regiao_784_Theme
 */

// Garantir que estamos no contexto WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Se estiver na raiz, mostrar página em construção
if (function_exists('is_home') && is_home() && !is_paged()) {
    // Verificar se a página em construção existe
    $em_construcao = get_page_by_path('em-construcao');
    if ($em_construcao) {
        include(locate_template('front-page.php'));
        exit;
    }
}

// Para outras situações, continuar normalmente
get_header();
?>

<div class="container" style="padding: 4rem 0; text-align: center;">
    <h1>Página não encontrada</h1>
    <p>A página que você está procurando não existe.</p>
    <a href="<?php echo home_url('/empreendedores-regionais'); ?>" class="btn-ver-mais">Ir para o Catálogo de Expositores</a>
</div>

<?php get_footer(); ?>
