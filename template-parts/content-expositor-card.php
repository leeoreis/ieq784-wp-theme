<?php
/**
 * Template part para exibir card de expositor
 * 
 * @package Chomneq_Template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('expositor-card'); ?>>
    <div class="card-image-wrapper">
        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php the_post_thumbnail_url('expositor-card'); ?>" alt="<?php the_title_attribute(); ?>" class="card-image">
        <?php else : ?>
            <div class="card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                <?php echo substr(get_the_title(), 0, 1); ?>
            </div>
        <?php endif; ?>
        
        <!-- Sistema de Avaliação com Corações -->
        <?php
        $expositor_id = get_the_ID();
        $likes_count = get_post_meta($expositor_id, '_expositor_likes', true);
        $likes_count = $likes_count ? intval($likes_count) : 0;
        
        // Verificar se usuário já curtiu
        $has_liked = false;
        $user_id = get_current_user_id();
        
        if ($user_id) {
            // Usuário logado: verificar via user meta
            $liked_expositores = get_user_meta($user_id, '_liked_expositores', true);
            $liked_expositores = $liked_expositores ? $liked_expositores : array();
            $has_liked = in_array($expositor_id, $liked_expositores);
        } else {
            // Usuário não logado: verificar via cookie
            $cookie_name = 'expositor_liked_' . $expositor_id;
            $has_liked = isset($_COOKIE[$cookie_name]);
        }
        ?>
        <button class="btn-like <?php echo $has_liked ? 'liked' : ''; ?>" 
                data-expositor-id="<?php echo $expositor_id; ?>"
                data-liked="<?php echo $has_liked ? '1' : '0'; ?>"
                title="<?php echo $has_liked ? 'Você já curtiu' : 'Curtir este expositor'; ?>">
            <span class="heart-icon"><?php echo $has_liked ? '❤️' : '🤍'; ?></span>
            <span class="likes-count"><?php echo $likes_count; ?></span>
        </button>
    </div>
    
    <div class="card-content">
        <h3 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <?php
        $categorias = chomneq_get_expositor_categorias(get_the_ID());
        if (!empty($categorias)) :
            $primeira_categoria = $categorias[0];
        ?>
            <span class="card-category"><?php echo esc_html($primeira_categoria->name); ?></span>
        <?php endif; ?>
        
        <div class="card-excerpt">
            <?php 
            if (has_excerpt()) {
                the_excerpt();
            } else {
                echo wp_trim_words(get_the_content(), 20, '...');
            }
            ?>
        </div>
        
        <div class="card-footer">
            <a href="<?php the_permalink(); ?>" class="btn-ver-mais">Ver Mais</a>
            <?php
            $regionais = wp_get_post_terms(get_the_ID(), 'regional_expositor');
            if (!empty($regionais) && !is_wp_error($regionais)) :
            ?>
                <span style="color: #666; font-size: 0.9rem;">⛪ <?php echo esc_html($regionais[0]->name); ?></span>
            <?php endif; ?>
            
        </div>
    </div>
</article>
