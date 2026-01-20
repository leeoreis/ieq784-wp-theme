
<?php
// Página completa do evento/atividade
global $post;

$pagina_evento = get_post_meta($post->ID, '_atividade_pagina_evento', true);
$data_fim = get_post_meta($post->ID, '_atividade_data_fim', true);
$hoje = date('Y-m-d');

// Se não deve ter página OU se a atividade já passou, redireciona para a home
if ($pagina_evento !== '1' || ($data_fim && $data_fim < $hoje)) {
    wp_redirect(home_url());
    exit;
}

get_header();

$imagem = get_the_post_thumbnail_url($post->ID, 'full');
$descricao = get_the_content(null, false, $post);
$link = get_post_meta($post->ID, '_atividade_link', true);
$cta = get_post_meta($post->ID, '_atividade_cta_texto', true) ?: 'Saiba Mais';
$cor = get_post_meta($post->ID, '_atividade_cor', true) ?: '#667eea';
$data_inicio = get_post_meta($post->ID, '_atividade_data_inicio', true);
$data_fim = get_post_meta($post->ID, '_atividade_data_fim', true);
$local = get_post_meta($post->ID, '_atividade_local', true);
$regional_id = get_post_meta($post->ID, '_atividade_regional', true);
$regional_nome = $regional_id ? get_the_title($regional_id) : '';
$ativa = get_post_meta($post->ID, '_atividade_ativa', true) === '1';
$fixa = get_post_meta($post->ID, '_atividade_fixa', true) === '1';

function chomneq_formatar_data($data) {
    if (!$data) return '';
    return date_i18n('d \d\e F \d\e Y', strtotime($data));
}

?>

<style>
.atividade-hero {
  background: #000;
  padding: 0;
  color: #fff;
  text-align: center;
  height: 500px;
  position: relative;

  width: 100% !important;
  max-width: none !important;

  left: auto !important;
  right: auto !important;
  margin-left: 0 !important;
  margin-right: 0 !important;

  overflow: hidden;

  <?php if ($imagem): ?>
  background-image: url('<?php echo esc_url($imagem); ?>');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  <?php endif; ?>
}


.atividade-hero-title {
    font-size: 2.6rem;
    font-weight: 800;
    margin: 0 0 12px 0;
    color: #fff;
    text-shadow: 0 2px 12px #0003;
}
.atividade-main {
    max-width: 700px;
    margin: 0 auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 32px #0001;
    padding: 40px 32px 32px 32px;
    margin-top: -60px;
    position: relative;
    z-index: 2;
}
.atividade-desc {
    font-size: 1.18rem;
    color: #333;
    margin-bottom: 32px;
}
.atividade-info-list {
    list-style: none;
    padding: 0;
    margin: 0 0 32px 0;
    display: flex;
    flex-wrap: wrap;
    gap: 18px 32px;
}
.atividade-info-list li {
    font-size: 1.08rem;
    color: #555;
    display: flex;
    align-items: center;
    gap: 8px;
}
.atividade-status.fixa {
    display: inline-block;
    font-size: 0.98rem;
    font-weight: 600;
    padding: 4px 14px;
    border-radius: 8px;
    background: #fef08a;
    color: #b45309;
    margin-right: 10px;
}
.atividade-btn {
    display: inline-block;
    padding: 16px 38px;
    background: linear-gradient(90deg, <?php echo esc_attr($cor); ?> 80%, #4f46e5 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 1.18rem;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    box-shadow: 0 2px 8px #0001;
    transition: background .2s, box-shadow .2s, transform .1s;
    margin-top: 18px;
}
.atividade-btn:hover {
    background: linear-gradient(90deg, #4f46e5 60%, <?php echo esc_attr($cor); ?> 100%);
    box-shadow: 0 4px 16px #0002;
    transform: translateY(-2px) scale(1.02);
}
@media (max-width: 800px) {
    .atividade-main { padding: 24px 4vw 24px 4vw; }
    .atividade-hero-title { font-size: 1.5rem; }
    .atividade-hero-img { max-height: 180px; }
}
</style>


<div class="atividade-hero"<?php if ($imagem) echo ' style="background-image: url(' . esc_url($imagem) . '); background-size: cover; background-position: center; background-repeat: no-repeat;"'; ?>>
</div>

<main class="atividade-main">
    <h1><?php echo esc_html(get_the_title($post)); ?></h1>
    <div class="atividade-desc">
        <?php echo wpautop($descricao); ?>
    </div>
    <ul class="atividade-info-list">
        <?php if ($regional_nome): ?><li><b>Regional:</b> <?php echo esc_html($regional_nome); ?></li><?php endif; ?>
        <?php if ($local): ?><li><b>Local:</b> <?php echo esc_html($local); ?></li><?php endif; ?>
        <?php
        // Lógica de exibição de data
        if ($data_inicio) {
            $meses = array(
                '01' => 'janeiro', '02' => 'fevereiro', '03' => 'março', '04' => 'abril',
                '05' => 'maio', '06' => 'junho', '07' => 'julho', '08' => 'agosto',
                '09' => 'setembro', '10' => 'outubro', '11' => 'novembro', '12' => 'dezembro'
            );
            $di = date('d', strtotime($data_inicio));
            $mi = $meses[date('m', strtotime($data_inicio))];
            $df = $data_fim ? date('d', strtotime($data_fim)) : '';
            $mf = $data_fim ? $meses[date('m', strtotime($data_fim))] : '';
            if ($data_fim && $data_fim !== $data_inicio) {
                echo '<li><b>Data:</b> de ' . intval($di) . ' de ' . $mi . ' a ' . intval($df) . ' de ' . $mf . '</li>';
            } else {
                echo '<li><b>Data:</b> ' . intval($di) . ' de ' . $mi . '</li>';
            }
        }
        ?>
    </ul>
    <?php
    // Sempre usar o CTA customizado definido pelo usuário
    if ($link) {
        echo '<a href="' . esc_url($link) . '" class="atividade-btn" target="_blank" rel="noopener noreferrer">' . esc_html($cta) . '</a>';
    }
    ?>
</main>
<?php get_footer(); ?>
