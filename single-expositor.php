<?php
/**
 * Template para página individual de Expositor
 * 
 * @package Regiao_784_Theme
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('expositor-single'); ?>>
        <div class="container">
            <!-- Header do Expositor -->
            <header class="expositor-header">
                <h1><?php the_title(); ?></h1>
                
                <?php
                $categorias = chomneq_get_expositor_categorias(get_the_ID());
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
                
                <div style="display: flex; gap: 1rem; justify-content: center; align-items: center; margin-top: 1rem; flex-wrap: wrap;">
                    <?php if (!empty($categorias)) : ?>
                        <div style="display: flex; gap: 0.5rem; height: 50px;">
                            <?php foreach ($categorias as $categoria) : ?>
                                <span class="card-category" style="display: flex; gap: 0.5rem; height: 50px; align-items: center;"><?php echo esc_html($categoria->name); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Sistema de Curtidas -->
                    <button class="btn-like <?php echo $has_liked ? 'liked' : ''; ?>" 
                            data-expositor-id="<?php echo $expositor_id; ?>"
                            data-liked="<?php echo $has_liked ? '1' : '0'; ?>"
                            title="<?php echo $has_liked ? 'Você já curtiu' : 'Curtir este expositor'; ?>"
                            style="margin: 0;">
                        <span class="heart-icon"><?php echo $has_liked ? '❤️' : '🤍'; ?></span>
                        <span class="likes-count"><?php echo $likes_count; ?></span>
                    </button>
                </div>
                
                
            </header>
            
            <!-- Imagem Destacada -->
            <?php if (has_post_thumbnail()) : ?>
                <div style="text-align: center; margin-bottom: 3rem;">
                    <img src="<?php the_post_thumbnail_url('expositor-hero'); ?>" alt="<?php the_title_attribute(); ?>" class="expositor-featured-image">
                </div>
            <?php endif; ?>

            <!-- Conteúdo Principal e Sidebar -->
            <div class="expositor-content">
                <!-- Conteúdo Principal -->
                <div class="expositor-main">
                    <div class="info-section">
                        <h3>Sobre</h3>
                        <div class="content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    
                    <!-- Galeria de Fotos -->
                    <?php
                    $gallery_ids = get_post_meta(get_the_ID(), 'expositor_gallery', true);
                    
                    if (!empty($gallery_ids)) :
                        // Limpar e filtrar IDs
                        $ids_array = array_map('trim', explode(',', $gallery_ids));
                        $ids_array = array_filter($ids_array, function($id) {
                            return !empty($id) && is_numeric($id);
                        });
                        
                        if (!empty($ids_array)) :
                    ?>
                        <div class="info-section">
                            <h3>Galeria de Produtos</h3>
                            <div class="gallery-grid">
                                <?php 
                                foreach ($ids_array as $img_id) : 
                                    $img_id = intval($img_id);
                                    $img_url = wp_get_attachment_image_url($img_id, 'medium');
                                    $img_full = wp_get_attachment_image_url($img_id, 'full');
                                    $img_caption = wp_get_attachment_caption($img_id);
                                    $img_description = get_post_field('post_content', $img_id);
                                    $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                                    
                                    if ($img_url) :
                                ?>
                                    <div class="gallery-item" 
                                         data-full="<?php echo esc_url($img_full); ?>"
                                         data-caption="<?php echo esc_attr($img_caption); ?>"
                                         data-description="<?php echo esc_attr($img_description); ?>">
                                        <img src="<?php echo esc_url($img_url); ?>" 
                                             alt="<?php echo esc_attr($img_alt ?: 'Produto'); ?>" 
                                             loading="lazy">
                                    </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>
                    <?php 
                        endif;
                    endif; 
                    ?>
                    <!-- Seção de Comentários -->
                    <div class="info-section comments-section" style="margin-top: 3rem;">
                        <h3>Comentários (<?php echo get_comments_number(); ?>)</h3>
                        
                        <!-- Formulário de Comentário -->
                        <div class="comment-form-container" style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                            <h4 style="margin-bottom: 1rem; font-size: 1.1rem;" id="form-title">Deixe seu comentário</h4>
                            <form id="expositor-comment-form">
                                <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                <input type="hidden" name="comment_id" id="edit-comment-id" value="">
                                <input type="hidden" name="parent_id" id="parent-comment-id" value="">
                                
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nome *</label>
                                        <input type="text" name="author_name" id="comment-author-name" required 
                                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                    <div>
                                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">E-mail *</label>
                                        <input type="email" name="author_email" id="comment-author-email" required 
                                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                                        <small style="color: #666;">Não será publicado</small>
                                    </div>
                                </div>
                                
                                <div style="margin-bottom: 1rem;">
                                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Comentário *</label>
                                    <textarea name="comment_content" id="comment-content" rows="4" required maxlength="1000"
                                              style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; resize: vertical;"></textarea>
                                    <small style="color: #666;">Mínimo 6 caracteres. Links não são permitidos.</small>
                                </div>
                                
                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    <button type="submit" class="btn-ver-mais" id="submit-comment-btn">
                                        Enviar Comentário
                                    </button>
                                    <button type="button" class="btn-cancel-edit" id="cancel-edit-btn" style="display: none; background: #6c757d; color: white; padding: 0.5rem 1.5rem; border: none; border-radius: 4px; cursor: pointer;">
                                        Cancelar
                                    </button>
                                    <span id="comment-feedback" style="color: #27ae60; font-weight: 500;"></span>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Lista de Comentários -->
                        <div id="comments-list">
                            <?php
                            $comments = get_comments(array(
                                'post_id' => get_the_ID(),
                                'status' => 'approve',
                                'parent' => 0, // Apenas comentários principais
                                'order' => 'DESC'
                            ));
                            
                            if ($comments) :
                                foreach ($comments as $comment) :
                                    chomneq_display_comment($comment);
                                endforeach;
                            else :
                            ?>
                                <p style="text-align: center; color: #666; padding: 2rem;">
                                    Ainda não há comentários. Seja o primeiro a comentar!
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Sidebar com Informações de Contato -->
                <aside class="expositor-sidebar">
                    <div class="info-section">
                        <h3>Informações de Contato</h3>
                        
                        <?php
                        $regionais = wp_get_post_terms(get_the_ID(), 'regional_expositor');
                        if (!empty($regionais) && !is_wp_error($regionais)) :
                        ?>
                            <div class="info-item">
                                <span class="info-icon">⛪</span>
                                <div>
                                    <strong>Regional</strong><br>
                                    <?php echo esc_html($regionais[0]->name); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        $localizacao = get_post_meta(get_the_ID(), '_expositor_localizacao', true);
                        if ($localizacao) :
                        ?>
                            <div class="info-item">
                                <span class="info-icon">📍</span>
                                <div>
                                    <strong>Endereço de Atendimento</strong><br>
                                    <?php echo esc_html($localizacao); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        $telefone = get_post_meta(get_the_ID(), '_expositor_telefone', true);
                        if ($telefone) :
                        ?>
                            <div class="info-item">
                                <span class="info-icon">📞</span>
                                <div>
                                    <strong>Telefone</strong><br>
                                    <a href="tel:<?php echo esc_attr($telefone); ?>"><?php echo esc_html($telefone); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        $whatsapp = get_post_meta(get_the_ID(), '_expositor_whatsapp', true);
                        if ($whatsapp) :
                            $whatsapp_clean = preg_replace('/[^0-9]/', '', $whatsapp);
                        ?>
                            <div class="info-item">
                                <span class="info-icon">💬</span>
                                <div>
                                    <strong>WhatsApp</strong><br>
                                    <a href="https://wa.me/55<?php echo esc_attr($whatsapp_clean); ?>" target="_blank"><?php echo esc_html($whatsapp); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        $email = get_post_meta(get_the_ID(), '_expositor_email', true);
                        if ($email) :
                        ?>
                            <div class="info-item">
                                <span class="info-icon">📧</span>
                                <div>
                                    <strong>E-mail</strong><br>
                                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        $website = get_post_meta(get_the_ID(), '_expositor_website', true);
                        if ($website) :
                        ?>
                            <div class="info-item">
                                <span class="info-icon">🌐</span>
                                <div>
                                    <strong>Website</strong><br>
                                    <a href="<?php echo esc_url($website); ?>" target="_blank">Visitar Site</a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        $instagram = get_post_meta(get_the_ID(), '_expositor_instagram', true);
                        if ($instagram) :
                        ?>
                            <div class="info-item">
                                <span class="info-icon">📷</span>
                                <div>
                                    <strong>Instagram</strong><br>
                                    <a href="https://instagram.com/<?php echo esc_attr(ltrim($instagram, '@')); ?>" target="_blank"><?php echo esc_html($instagram); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        $facebook = get_post_meta(get_the_ID(), '_expositor_facebook', true);
                        if ($facebook) :
                        ?>
                            <div class="info-item">
                                <span class="info-icon">👥</span>
                                <div>
                                    <strong>Facebook</strong><br>
                                    <a href="<?php echo esc_url($facebook); ?>" target="_blank">Visitar Página</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Métodos de Pagamento -->
                    <?php
                    $servico_gratuito = get_post_meta(get_the_ID(), '_expositor_servico_gratuito', true);
                    if ($servico_gratuito !== '1') : // Só exibe se NÃO for gratuito
                        $metodos = get_post_meta(get_the_ID(), '_expositor_metodos_pagamento', true);
                        if ($metodos) :
                            $metodos_array = array_map('trim', explode(',', $metodos));
                        ?>
                            <div class="info-section">
                                <h3>Métodos de Pagamento</h3>
                                <div class="payment-methods">
                                    <?php foreach ($metodos_array as $metodo) : ?>
                                        <span class="payment-badge"><?php echo esc_html($metodo); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <!-- Informações Bancárias -->
                    <?php
                    $servico_gratuito = get_post_meta(get_the_ID(), '_expositor_servico_gratuito', true);
                    if ($servico_gratuito !== '1') : // Só exibe se NÃO for gratuito
                        $pix = get_post_meta(get_the_ID(), '_expositor_pix', true);
                        $pix_qrcode = get_post_meta(get_the_ID(), '_expositor_pix_qrcode', true);
                        $banco = get_post_meta(get_the_ID(), '_expositor_banco', true);
                        $agencia = get_post_meta(get_the_ID(), '_expositor_agencia', true);
                        $conta = get_post_meta(get_the_ID(), '_expositor_conta', true);
                        
                        if ($pix || $banco) :
                    ?>
                        <div class="info-section">
                            <h3>Dados para Pagamento</h3>
                            
                            <?php if ($pix) : ?>
                                <div class="info-item">
                                    <span class="info-icon">💳</span>
                                    <div>
                                        <strong>Chave PIX</strong><br>
                                        <code style="background: #f0f0f0; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.9rem;"><?php echo esc_html($pix); ?></code>
                                    </div>
                                </div>
                                
                                <?php if ($pix_qrcode) : ?>
                                    <div class="info-item" style="text-align: center; margin-top: 1rem;">
                                        <div>
                                            <strong>QR Code PIX</strong><br>
                                            <img src="<?php echo esc_url(wp_get_attachment_url($pix_qrcode)); ?>" 
                                                 alt="QR Code PIX" 
                                                 style="max-width: 200px; margin-top: 0.5rem; border: 2px solid #ddd; border-radius: 8px; padding: 0.5rem; background: white;">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if ($banco) : ?>
                                <div class="info-item">
                                    <span class="info-icon">🏦</span>
                                    <div>
                                        <strong>Dados Bancários</strong><br>
                                        Banco: <?php echo esc_html($banco); ?><br>
                                        <?php if ($agencia) : ?>Agência: <?php echo esc_html($agencia); ?><br><?php endif; ?>
                                        <?php if ($conta) : ?>Conta: <?php echo esc_html($conta); ?><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php 
                        endif; // fim if ($pix || $banco)
                    endif; // fim if ($servico_gratuito !== '1')
                    ?>

                     <?php
                $servico_gratuito = get_post_meta(get_the_ID(), '_expositor_servico_gratuito', true);
                if ($servico_gratuito === '1') :
                ?>
                    <div style="text-align: center; margin-top: 1rem;">
                        <span style="display: inline-block; background: #4CAF50; color: white; padding: 0.5rem 1.5rem; border-radius: 25px; font-weight: bold; font-size: 0.95rem;">✓ Serviço Gratuito</span>
                    </div>
                <?php endif; ?>
            
                    
                    <!-- Botão de Voltar -->
                    <div style="margin-top: 2rem;">
                        <a href="<?php echo esc_url(home_url('/empreendedores-regionais')); ?>" class="btn-ver-mais" style="display: block; text-align: center;">← Voltar para Expositores</a>
                    </div>
                    
                    
                </aside>
            </div>
        </div>
    </article>
<?php endwhile; ?>

<script>
jQuery(document).ready(function($) {
    // Enviar/Editar comentário
    $('#expositor-comment-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitBtn = $('#submit-comment-btn');
        var feedback = $('#comment-feedback');
        var commentId = $('#edit-comment-id').val();
        var isEdit = commentId !== '';
        
        submitBtn.prop('disabled', true).text(isEdit ? 'Atualizando...' : 'Enviando...');
        feedback.text('');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: form.serialize() + '&action=add_expositor_comment',
            success: function(response) {
                if (response.success) {
                    feedback.css('color', '#27ae60').text(response.data.message);
                    
                    if (isEdit) {
                        // Atualizar comentário existente na lista
                        var commentDiv = $('#comment-' + commentId);
                        commentDiv.find('.comment-content').html(
                            $('#comment-content').val().replace(/\n/g, '<br>')
                        );
                        
                        // Limpar formulário
                        form[0].reset();
                        $('#edit-comment-id').val('');
                        submitBtn.text('Enviar Comentário');
                        $('#cancel-edit-btn').hide();
                    } else {
                        // Recarregar página para mostrar novo comentário
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                } else {
                    feedback.css('color', '#e74c3c').text(response.data);
                }
            },
            error: function() {
                feedback.css('color', '#e74c3c').text('Erro ao processar comentário.');
            },
            complete: function() {
                submitBtn.prop('disabled', false);
                if (!isEdit) {
                    submitBtn.text('Enviar Comentário');
                }
            }
        });
    });
    
    // Responder comentário
    $(document).on('click', '.btn-reply-comment', function() {
        var commentId = $(this).data('comment-id');
        var authorName = $(this).data('author');
        
        $('#parent-comment-id').val(commentId);
        $('#edit-comment-id').val(''); // Limpar edição se houver
        $('#form-title').text('Respondendo a ' + authorName);
        $('#submit-comment-btn').text('Enviar Resposta');
        $('#cancel-edit-btn').show();
        $('#comment-content').focus();
        
        $('html, body').animate({
            scrollTop: $('#expositor-comment-form').offset().top - 100
        }, 500);
    });
    
    // Editar comentário
    $(document).on('click', '.btn-edit-comment', function() {
        var commentId = $(this).data('comment-id');
        var author = $(this).data('author');
        var email = $(this).data('email');
        var content = $(this).data('content');
        
        $('#edit-comment-id').val(commentId);
        $('#parent-comment-id').val(''); // Limpar resposta se houver
        $('#comment-author-name').val(author);
        $('#comment-author-email').val(email);
        $('#comment-content').val(content);
        $('#form-title').text('Editando comentário');
        $('#submit-comment-btn').text('Atualizar Comentário');
        $('#cancel-edit-btn').show();
        
        $('html, body').animate({
            scrollTop: $('#expositor-comment-form').offset().top - 100
        }, 500);
    });
    
    // Cancelar edição/resposta
    $('#cancel-edit-btn').on('click', function() {
        $('#expositor-comment-form')[0].reset();
        $('#edit-comment-id').val('');
        $('#parent-comment-id').val('');
        $('#form-title').text('Deixe seu comentário');
        $('#submit-comment-btn').text('Enviar Comentário');
        $(this).hide();
        $('#comment-feedback').text('');
    });
    
    // Deletar comentário
    $(document).on('click', '.btn-delete-comment', function() {
        if (!confirm('Tem certeza que deseja deletar este comentário?')) {
            return;
        }
        
        var commentId = $(this).data('comment-id');
        var commentDiv = $('#comment-' + commentId);
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'delete_expositor_comment',
                comment_id: commentId
            },
            success: function(response) {
                if (response.success) {
                    commentDiv.fadeOut(300, function() {
                        $(this).remove();
                        
                        // Atualizar contador
                        var count = $('.comments-section h3');
                        var currentCount = parseInt(count.text().match(/\d+/)[0]);
                        count.text('Comentários (' + (currentCount - 1) + ')');
                    });
                } else {
                    alert(response.data);
                }
            },
            error: function() {
                alert('Erro ao deletar comentário.');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
