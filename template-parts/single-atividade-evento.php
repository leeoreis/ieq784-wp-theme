<?php
/**
 * Template para página de evento individual (atividade)
 * Usado em /eventos/slug-do-evento
 */
global $post;
get_header();

$imagem = get_the_post_thumbnail_url($post->ID, 'large');
$descricao = get_the_content(null, false, $post);
$link = get_post_meta($post->ID, '_atividade_link', true);
$cta = get_post_meta($post->ID, '_atividade_cta_texto', true) ?: 'Saiba Mais';
$cor = get_post_meta($post->ID, '_atividade_cor', true) ?: '#667eea';

?>
<div class="wrapper">
    <div class="evento-single-card" style="max-width:600px;margin:40px auto;background:#fff;border-radius:12px;box-shadow:0 2px 12px #0001;overflow:hidden;">
        <?php if ($imagem): ?>
            <div style="background:linear-gradient(135deg,<?php echo esc_attr($cor); ?> 60%,#fff0 100%);padding:0;">
                <img src="<?php echo esc_url($imagem); ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>" style="width:100%;display:block;max-height:320px;object-fit:cover;">
            </div>
        <?php endif; ?>
        <div style="padding:32px 24px 24px 24px;">
            <h1 style="margin-top:0;font-size:2rem;line-height:1.2;"><?php echo esc_html(get_the_title($post)); ?></h1>
            <div style="margin:18px 0 24px 0;font-size:1.1rem;color:#444;">
                <?php echo wpautop($descricao); ?>
            </div>
            <?php if ($link): ?>
                <a href="<?php echo esc_url($link); ?>" class="cta-btn" style="display:inline-block;padding:12px 32px;background:<?php echo esc_attr($cor); ?>;color:#fff;border-radius:6px;font-weight:600;text-decoration:none;transition:.2s;"> <?php echo esc_html($cta); ?> </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
get_footer();
