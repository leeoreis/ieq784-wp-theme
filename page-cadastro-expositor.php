<?php
/**
 * Template Name: Cadastro de Expositor
 * 
 * @package Chomneq_Template
 */

// Verificar se usuário está logado
if (!is_user_logged_in()) {
    // Redirecionar para página de registro/login
    get_header();
    ?>
    <div class="container" style="max-width: 600px; margin: 4rem auto; padding: 0 1rem;">
        <div style="background: white; padding: 2.5rem; border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.1); text-align: center;">
            <h1 style="color: #0073aa; margin-bottom: 1rem;">🔐 Acesso Restrito</h1>
            <p style="font-size: 1.1rem; color: #666; margin-bottom: 2rem;">
                Para cadastrar seu negócio na feira, você precisa estar logado como expositor.
            </p>
            
            <div style="display: flex; flex-direction: column; gap: 1rem; max-width: 400px; margin: 0 auto;">
                <a href="<?php echo wp_login_url(home_url('/cadastro-expositor')); ?>" 
                   class="btn-primary" 
                   style="display: block; padding: 1rem 2rem; background: #0073aa; color: white; text-decoration: none; border-radius: 4px; font-weight: 600; transition: all 0.3s;">
                    ✓ Já tenho conta - Fazer Login
                </a>
                
                <a href="#registro" 
                   onclick="document.getElementById('form-registro').style.display='block'; this.style.display='none'; return false;"
                   class="btn-secondary" 
                   style="display: block; padding: 1rem 2rem; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px; font-weight: 600; transition: all 0.3s;">
                    📝 Não tenho conta - Criar Conta de Expositor
                </a>
            </div>
            
            <!-- Formulário de Registro -->
            <div id="form-registro" style="display: none; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #eee;">
                <h2 style="color: #4CAF50; margin-bottom: 1.5rem;">Criar Nova Conta de Expositor</h2>
                
                <form method="post" action="" style="text-align: left;">
                    <?php wp_nonce_field('registro_expositor', 'registro_nonce'); ?>
                    <input type="hidden" name="action" value="registrar_expositor">
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="reg_nome" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nome Completo: *</label>
                        <input type="text" id="reg_nome" name="nome_completo" required 
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="reg_email" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">E-mail: *</label>
                        <input type="email" id="reg_email" name="email" required 
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="reg_usuario" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nome de Usuário: *</label>
                        <input type="text" id="reg_usuario" name="username" required 
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <small style="color: #666;">Apenas letras, números e underline</small>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="reg_senha" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Senha: *</label>
                        <input type="password" id="reg_senha" name="password" required 
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                        <small style="color: #666;">Mínimo 8 caracteres</small>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label for="reg_senha_confirm" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Confirmar Senha: *</label>
                        <input type="password" id="reg_senha_confirm" name="password_confirm" required 
                               style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    
                    <button type="submit" name="registrar_expositor" 
                            style="width: 100%; padding: 1rem; background: #4CAF50; color: white; border: none; border-radius: 4px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                        Criar Conta de Expositor
                    </button>
                </form>
                
                <?php
                // Processar registro
                if (isset($_POST['registrar_expositor']) && wp_verify_nonce($_POST['registro_nonce'], 'registro_expositor')) {
                    $nome_completo = sanitize_text_field($_POST['nome_completo']);
                    $email = sanitize_email($_POST['email']);
                    $username = sanitize_user($_POST['username']);
                    $password = $_POST['password'];
                    $password_confirm = $_POST['password_confirm'];
                    
                    $erros = array();
                    
                    // Validações
                    if (empty($nome_completo)) {
                        $erros[] = 'Nome completo é obrigatório';
                    }
                    
                    if (!is_email($email)) {
                        $erros[] = 'E-mail inválido';
                    }
                    
                    if (email_exists($email)) {
                        $erros[] = 'Este e-mail já está cadastrado';
                    }
                    
                    if (username_exists($username)) {
                        $erros[] = 'Este nome de usuário já está em uso';
                    }
                    
                    if (strlen($password) < 8) {
                        $erros[] = 'A senha deve ter no mínimo 8 caracteres';
                    }
                    
                    if ($password !== $password_confirm) {
                        $erros[] = 'As senhas não coincidem';
                    }
                    
                    if (empty($erros)) {
                        // Criar usuário
                        $user_id = wp_create_user($username, $password, $email);
                        
                        if (!is_wp_error($user_id)) {
                            // Atualizar nome completo
                            wp_update_user(array(
                                'ID' => $user_id,
                                'display_name' => $nome_completo,
                                'first_name' => $nome_completo
                            ));
                            
                            // Adicionar role de expositor
                            $user = new WP_User($user_id);
                            $user->set_role('expositor');
                            
                            // Fazer login automático
                            wp_set_current_user($user_id);
                            wp_set_auth_cookie($user_id);
                            
                            // Redirecionar para página de cadastro
                            wp_redirect(get_permalink());
                            exit;
                        } else {
                            $erros[] = 'Erro ao criar usuário: ' . $user->get_error_message();
                        }
                    }
                    
                    // Exibir erros
                    if (!empty($erros)) {
                        echo '<div style="margin-top: 1rem; padding: 1rem; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; color: #721c24;">';
                        echo '<strong>⚠️ Erro(s):</strong><ul style="margin: 0.5rem 0 0 1.5rem;">';
                        foreach ($erros as $erro) {
                            echo '<li>' . esc_html($erro) . '</li>';
                        }
                        echo '</ul></div>';
                        echo '<script>document.getElementById("form-registro").style.display="block";</script>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    get_footer();
    exit;
}

// Verificar se é expositor
$current_user = wp_get_current_user();
if (!in_array('expositor', $current_user->roles) && !current_user_can('administrator')) {
    wp_die('Você não tem permissão para acessar esta página. Apenas expositores podem cadastrar seus negócios.');
}

get_header();

// Buscar expositor existente do usuário
$user_expositor = get_posts(array(
    'post_type' => 'expositor',
    'author' => get_current_user_id(),
    'posts_per_page' => 1,
    'post_status' => array('publish', 'pending', 'draft')
));

$expositor_id = !empty($user_expositor) ? $user_expositor[0]->ID : 0;
$is_edit = $expositor_id > 0;

// Se está editando, carregar dados
if ($is_edit) {
    $expositor = $user_expositor[0];
    $status = $expositor->post_status;
}
?>

<div class="container" style="max-width: 900px; margin: 2rem auto; padding: 0 1rem;">
    <div class="cadastro-expositor-page">
        <header style="text-align: center; margin-bottom: 2rem;">
            <h1><?php echo $is_edit ? 'Editar Meu Negócio' : 'Cadastrar Meu Negócio'; ?></h1>
            <p style="color: #666;">
                <?php if ($is_edit): ?>
                    Status: <strong style="color: <?php echo $status == 'publish' ? 'green' : 'orange'; ?>">
                        <?php echo $status == 'publish' ? '✓ Aprovado' : '⏳ Aguardando Aprovação'; ?>
                    </strong>
                    <?php if ($status == 'publish'): ?>
                        <br>
                        <a href="<?php echo get_permalink($expositor_id); ?>" 
                           target="_blank" 
                           style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; transition: background 0.3s;">
                            🌐 Ver Minha Página Publicada
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    Preencha os dados do seu negócio para participar da feira
                <?php endif; ?>
            </p>
        </header>

        <form id="form-cadastro-expositor" method="post" enctype="multipart/form-data" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <?php wp_nonce_field('salvar_expositor_frontend', 'expositor_nonce'); ?>
            <input type="hidden" name="action" value="salvar_expositor_frontend">
            <input type="hidden" name="expositor_id" value="<?php echo $expositor_id; ?>">

            <!-- Informações Básicas -->
            <section class="form-section">
                <h2 style="border-bottom: 2px solid #0073aa; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                    📋 Informações Básicas
                </h2>

                <div class="form-group">
                    <label for="titulo">Nome do Negócio/Produto: *</label>
                    <input type="text" id="titulo" name="titulo" required 
                           value="<?php echo $is_edit ? esc_attr($expositor->post_title) : ''; ?>"
                           placeholder="Ex: Doces da Maria">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição: *</label>
                    <?php
                    $content = $is_edit ? $expositor->post_content : '';
                    wp_editor($content, 'descricao', array(
                        'textarea_name' => 'descricao',
                        'textarea_rows' => 10,
                        'media_buttons' => true,
                        'teeny' => false,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect,bold,italic,underline,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
                            'toolbar2' => 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help'
                        ),
                        'quicktags' => true,
                        'drag_drop_upload' => true
                    ));
                    ?>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria: *</label>
                    <div style="display: flex; gap: 0.5rem; align-items: flex-start;">
                        <select id="categoria" name="categoria" required style="flex: 1;">
                            <option value="">Selecione uma categoria</option>
                            <option value="nova" style="font-weight: bold; color: #0073aa;">+ Criar Nova Categoria</option>
                            <optgroup label="Categorias Existentes">
                                <?php
                                $categorias = get_terms(array(
                                    'taxonomy' => 'categoria_expositor', 
                                    'hide_empty' => false,
                                    'parent' => 0
                                ));
                                $categoria_atual = $is_edit ? wp_get_post_terms($expositor_id, 'categoria_expositor', array('fields' => 'ids')) : array();
                                $categoria_atual = !empty($categoria_atual) ? $categoria_atual[0] : 0;
                                
                                function render_categoria_tree($parent_id, $nivel, $categoria_atual) {
                                    $categorias = get_terms(array(
                                        'taxonomy' => 'categoria_expositor',
                                        'hide_empty' => false,
                                        'parent' => $parent_id
                                    ));
                                    
                                    foreach ($categorias as $cat) {
                                        $prefix = str_repeat('&nbsp;&nbsp;', $nivel);
                                        echo '<option value="' . $cat->term_id . '" ' . selected($categoria_atual, $cat->term_id, false) . '>';
                                        echo $prefix . ($nivel > 0 ? '↳ ' : '') . esc_html($cat->name);
                                        echo '</option>';
                                        render_categoria_tree($cat->term_id, $nivel + 1, $categoria_atual);
                                    }
                                }
                                
                                render_categoria_tree(0, 0, $categoria_atual);
                                ?>
                            </optgroup>
                        </select>
                    </div>
                    
                    <!-- Modal de Nova Categoria -->
                    <div id="modal-nova-categoria" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
                        <div style="background: white; padding: 2rem; border-radius: 8px; max-width: 500px; width: 90%;">
                            <h3 style="margin: 0 0 1.5rem 0;">✨ Criar Nova Categoria</h3>
                            
                            <div style="margin-bottom: 1rem;">
                                <label for="nova_categoria_nome" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nome da Categoria: *</label>
                                <input type="text" id="nova_categoria_nome" placeholder="Ex: Artesanato" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                            
                            <div style="margin-bottom: 1.5rem;">
                                <label for="nova_categoria_pai" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Categoria Pai (Opcional):</label>
                                <select id="nova_categoria_pai" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;">
                                    <option value="0">Nenhuma (categoria principal)</option>
                                    <?php render_categoria_tree(0, 0, 0); ?>
                                </select>
                                <p style="font-size: 0.85rem; color: #666; margin-top: 0.5rem;">Deixe como "Nenhuma" para criar uma categoria principal</p>
                            </div>
                            
                            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                <button type="button" id="cancelar-nova-categoria" style="padding: 0.75rem 1.5rem; border: 2px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">Cancelar</button>
                                <button type="button" id="salvar-nova-categoria" style="padding: 0.75rem 1.5rem; background: #0073aa; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Criar Categoria</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="imagem_destaque">Imagem Principal (máx. 5MB): *</label>
                    <input type="file" id="imagem_destaque" name="imagem_destaque" accept="image/*" <?php echo !$is_edit ? 'required' : ''; ?>>
                    <small style="color: #666; display: block; margin-top: 0.25rem;">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 5MB</small>
                    <?php if ($is_edit && has_post_thumbnail($expositor_id)): ?>
                        <div style="margin-top: 1rem;">
                            <img src="<?php echo get_the_post_thumbnail_url($expositor_id, 'medium'); ?>" 
                                 style="max-width: 200px; border-radius: 4px;">
                            <p style="font-size: 0.9rem; color: #666;">Imagem atual (deixe em branco para manter)</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Galeria de Imagens -->
            <section class="form-section">
                <h2 style="border-bottom: 2px solid #0073aa; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                    🖼️ Galeria de Imagens
                </h2>

                <div class="form-group">
                    <label>Fotos dos produtos ou serviços:</label>
                    <input type="file" id="galeria_imagens" name="galeria_imagens[]" accept="image/*" multiple>
                    <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">
                        Você pode selecionar múltiplas imagens de uma vez
                    </p>
                    
                    <?php if ($is_edit):
                        $gallery_ids = get_post_meta($expositor_id, 'expositor_gallery', true);
                        if (!empty($gallery_ids)):
                            $ids_array = explode(',', $gallery_ids);
                    ?>
                        <div class="galeria-preview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; margin-top: 1rem;">
                            <?php foreach ($ids_array as $img_id):
                                $img_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                                if ($img_url):
                            ?>
                                <div class="galeria-item" style="position: relative;">
                                    <img src="<?php echo esc_url($img_url); ?>" 
                                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px;">
                                </div>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                        <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">
                            Galeria atual (novas imagens serão adicionadas)
                        </p>
                    <?php 
                        endif;
                    endif; 
                    ?>
                </div>
            </section>

            <!-- Informações Gerais -->
            <section class="form-section">
                <h2 style="border-bottom: 2px solid #0073aa; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                    📍 Informações Gerais
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="regional">Regional (Comunidade de Origem):</label>
                        <?php
                        $regionais = get_terms(array(
                            'taxonomy' => 'regional_expositor',
                            'hide_empty' => false,
                        ));
                        $regional_atual = $is_edit ? wp_get_post_terms($expositor_id, 'regional_expositor', array('fields' => 'ids')) : array();
                        $regional_id = !empty($regional_atual) ? $regional_atual[0] : '';
                        ?>
                        <select id="regional" name="regional">
                            <option value="">Selecione uma regional</option>
                            <option value="nova">➕ Adicionar nova regional...</option>
                            <?php foreach ($regionais as $regional) : ?>
                                <option value="<?php echo esc_attr($regional->term_id); ?>" <?php selected($regional_id, $regional->term_id); ?>>
                                    <?php echo esc_html($regional->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small style="color: #666; font-size: 0.9em;">Selecione a regional/igreja ou adicione uma nova</small>
                    </div>

                    <div class="form-group" id="nova-regional-container" style="display: none;">
                        <label for="nova_regional">Nome da Nova Regional:</label>
                        <input type="text" id="nova_regional" name="nova_regional" 
                               placeholder="Ex: IEQ Central São Paulo">
                        <small style="color: #666; font-size: 0.9em;">Digite o nome completo da regional</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="localizacao">Endereço de Atendimento:</label>
                        <input type="text" id="localizacao" name="localizacao" 
                               value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_localizacao', true)) : ''; ?>"
                               placeholder="Endereço da sua loja/empresa">
                        <small style="color: #666; font-size: 0.9em;">Indique o local físico ou se atende em múltiplas localidades</small>
                    </div>
                </div>
            </section>

            <!-- Informações de Contato -->
            <section class="form-section">
                <h2 style="border-bottom: 2px solid #0073aa; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                    📞 Informações de Contato
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="telefone">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" 
                               value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_telefone', true)) : ''; ?>"
                               placeholder="(00) 0000-0000">
                    </div>

                    <div class="form-group">
                        <label for="whatsapp">WhatsApp: *</label>
                        <input type="tel" id="whatsapp" name="whatsapp" required
                               value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_whatsapp', true)) : ''; ?>"
                               placeholder="(00) 00000-0000">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">E-mail: *</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_email', true)) : ''; ?>"
                           placeholder="contato@exemplo.com">
                </div>

                <div class="form-group">
                    <label for="website">Website:</label>
                    <input type="url" id="website" name="website"
                           value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_website', true)) : ''; ?>"
                           placeholder="https://seusite.com">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="instagram">Instagram:</label>
                        <input type="text" id="instagram" name="instagram"
                               value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_instagram', true)) : ''; ?>"
                               placeholder="@seuinstagram">
                    </div>

                    <div class="form-group">
                        <label for="facebook">Facebook:</label>
                        <input type="url" id="facebook" name="facebook"
                               value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_facebook', true)) : ''; ?>"
                               placeholder="https://facebook.com/suapagina">
                    </div>
                </div>
            </section>

            <!-- Informações de Pagamento -->
            <section class="form-section">
                <h2 style="border-bottom: 2px solid #0073aa; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                    💳 Informações de Pagamento
                </h2>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" id="servico_gratuito" name="servico_gratuito" value="1" 
                               <?php echo ($is_edit && get_post_meta($expositor_id, '_expositor_servico_gratuito', true) == '1') ? 'checked' : ''; ?>
                               style="width: auto;">
                        <span style="font-weight: 600;">Meu produto/serviço é gratuito</span>
                    </label>
                </div>

                <div id="campos-pagamento" style="<?php echo ($is_edit && get_post_meta($expositor_id, '_expositor_servico_gratuito', true) == '1') ? 'display:none;' : ''; ?>">
                    <div class="form-group">
                        <label for="metodos_pagamento">Métodos de Pagamento Aceitos: *</label>
                        <input type="text" id="metodos_pagamento" name="metodos_pagamento"
                               value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_metodos_pagamento', true)) : ''; ?>"
                               placeholder="Ex: Dinheiro, PIX, Cartão de Crédito (separe por vírgula)">
                    </div>

                    <div class="form-group">
                        <label for="pix">Chave PIX:</label>
                        <input type="text" id="pix" name="pix"
                               value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_pix', true)) : ''; ?>"
                               placeholder="CPF, E-mail, Telefone ou Chave Aleatória">
                    </div>

                    <div class="form-group">
                        <label for="pix_qrcode">QR Code PIX:</label>
                        <input type="file" id="pix_qrcode" name="pix_qrcode" accept="image/*">
                        <?php if ($is_edit):
                            $qrcode_id = get_post_meta($expositor_id, '_expositor_pix_qrcode', true);
                            if ($qrcode_id):
                        ?>
                            <div style="margin-top: 1rem;">
                                <img src="<?php echo esc_url(wp_get_attachment_url($qrcode_id)); ?>" 
                                     style="max-width: 150px; border-radius: 4px;">
                                <p style="font-size: 0.9rem; color: #666;">QR Code atual</p>
                            </div>
                        <?php 
                            endif;
                        endif; 
                        ?>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="banco">Banco:</label>
                            <input type="text" id="banco" name="banco"
                                   value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_banco', true)) : ''; ?>"
                                   placeholder="Nome do Banco">
                        </div>

                        <div class="form-group">
                            <label for="agencia">Agência:</label>
                            <input type="text" id="agencia" name="agencia"
                                   value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_agencia', true)) : ''; ?>"
                                   placeholder="0000">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="conta">Conta:</label>
                        <input type="text" id="conta" name="conta"
                               value="<?php echo $is_edit ? esc_attr(get_post_meta($expositor_id, '_expositor_conta', true)) : ''; ?>"
                               placeholder="00000-0">
                    </div>
                </div>
            </section>

            <!-- Botões de Ação -->
            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #ddd; flex-wrap: wrap;">
                <button type="submit" class="btn-submit" style="background: #0073aa; color: white; padding: 1rem 2rem; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold;">
                    <?php echo $is_edit ? '💾 Atualizar Cadastro' : '✓ Enviar para Aprovação'; ?>
                </button>
                
                <?php if ($is_edit && $status == 'publish'): ?>
                <button type="button" id="btn-gerar-qrcode" style="background: #9C27B0; color: white; padding: 1rem 2rem; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold;">
                    📱 QR Code da minha Página
                </button>
                <?php endif; ?>
                
            </div>
        </form>

        <!-- Modal QR Code -->
        <?php if ($is_edit && $status == 'publish'): ?>
        <div id="modal-qrcode" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center; overflow-y: auto; padding: 1rem;">
            <div style="background: white; padding: 2rem; border-radius: 8px; max-width: 650px; width: 90%; text-align: center; margin: auto;">
                <h3 style="margin: 0 0 1.5rem 0;">📱 QR Code da Sua Página</h3>
                
                <div id="qrcode-container" style="display: flex; justify-content: center; margin: 2rem 0;">
                    <div id="qrcode" style="padding: 1.5rem; background: white; border: 3px solid #333; border-radius: 12px; display: inline-block;"></div>
                </div>
                
                <p style="color: #666; margin-bottom: 0.5rem; font-size: 0.9rem;">
                    <strong><?php echo esc_html($expositor->post_title); ?></strong>
                </p>
                <p style="color: #666; margin-bottom: 1.5rem; font-size: 0.85rem;">
                    Resolução: 512x512px (ideal para impressão em A4)
                </p>
                
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <button type="button" id="btn-download-qrcode" style="padding: 0.75rem 1.5rem; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        ⬇️ Baixar QR Code
                    </button>
                    <button type="button" id="btn-imprimir-qrcode" style="padding: 0.75rem 1.5rem; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        🖨️ Imprimir
                    </button>
                    <button type="button" id="fechar-modal-qrcode" style="padding: 0.75rem 1.5rem; border: 2px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div id="mensagem-resultado" style="display: none; margin-top: 2rem; padding: 1rem; border-radius: 4px; text-align: center;"></div>
    </div>
</div>

<style>
    .form-section {
        margin-bottom: 2.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    /* Estilos para o editor WordPress */
    .wp-editor-wrap {
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .wp-editor-container {
        border: none;
    }
    
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="tel"],
    .form-group input[type="url"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
        font-family: inherit;
    }
    
    .form-group input[type="file"] {
        padding: 0.5rem;
    }
    
    .form-group textarea {
        resize: vertical;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    .btn-submit:hover {
        background: #005a87 !important;
    }
    
    .mensagem-sucesso {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .mensagem-erro {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    a[href*="Ver Minha Página"]:hover {
        background: #45a049 !important;
    }
    
    #btn-gerar-qrcode:hover {
        background: #7B1FA2 !important;
    }
    
    @media print {
        body * {
            visibility: hidden !important;
        }
        #qrcode canvas {
            visibility: visible !important;
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -50%) !important;
        }
        @page {
            size: A4;
            margin: 0;
        }
    }
</style>

<!-- Incluir biblioteca QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
jQuery(document).ready(function($) {
    // Validar tamanho da imagem ao selecionar
    $('#imagem_destaque').on('change', function() {
        var file = this.files[0];
        if (file) {
            var maxSize = 5 * 1024 * 1024; // 5MB
            var fileSize = file.size;
            var fileSizeMB = (fileSize / 1024 / 1024).toFixed(2);
            
            if (fileSize > maxSize) {
                alert('❌ Erro: A imagem selecionada tem ' + fileSizeMB + 'MB.\n\nO tamanho máximo permitido é 5MB.\n\nPor favor, selecione uma imagem menor ou comprima a imagem antes de fazer upload.');
                $(this).val(''); // Limpar seleção
                return false;
            }
        }
    });
    
    // Toggle campos de pagamento baseado no checkbox gratuito
    $('#servico_gratuito').on('change', function() {
        if ($(this).is(':checked')) {
            $('#campos-pagamento').slideUp();
            // Remover required dos campos de pagamento
            $('#metodos_pagamento').prop('required', false);
        } else {
            $('#campos-pagamento').slideDown();
            // Adicionar required ao campo de métodos de pagamento
            $('#metodos_pagamento').prop('required', true);
        }
    });
    
    // Mostrar/ocultar campo de nova regional
    $('#regional').on('change', function() {
        if ($(this).val() === 'nova') {
            $('#nova-regional-container').show();
            $('#nova_regional').focus();
        } else {
            $('#nova-regional-container').hide();
            $('#nova_regional').val('');
        }
    });
    
    // Abrir modal de nova categoria
    $('#categoria').on('change', function() {
        if ($(this).val() === 'nova') {
            $('#modal-nova-categoria').css('display', 'flex');
            $('#nova_categoria_nome').focus();
        }
    });
    
    // Fechar modal
    $('#cancelar-nova-categoria, #modal-nova-categoria').on('click', function(e) {
        if (e.target === this) {
            $('#modal-nova-categoria').hide();
            $('#categoria').val('');
            $('#nova_categoria_nome').val('');
            $('#nova_categoria_pai').val('0');
        }
    });
    
    // Salvar nova categoria
    $('#salvar-nova-categoria').on('click', function() {
        var nome = $('#nova_categoria_nome').val().trim();
        var pai = $('#nova_categoria_pai').val();
        
        if (!nome) {
            alert('Por favor, digite o nome da categoria');
            return;
        }
        
        var $btn = $(this);
        $btn.prop('disabled', true).text('Criando...');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'criar_categoria_expositor',
                nome: nome,
                pai: pai,
                nonce: '<?php echo wp_create_nonce('criar_categoria'); ?>'
            },
            success: function(response) {
                if (response.success) {
                    // Adicionar nova categoria ao select
                    var option = $('<option></option>')
                        .attr('value', response.data.term_id)
                        .text(response.data.name)
                        .prop('selected', true);
                    
                    $('#categoria optgroup').append(option);
                    
                    // Fechar modal
                    $('#modal-nova-categoria').hide();
                    $('#nova_categoria_nome').val('');
                    $('#nova_categoria_pai').val('0');
                    
                    alert('✓ Categoria criada com sucesso!');
                } else {
                    alert('Erro: ' + response.data);
                }
            },
            error: function() {
                alert('Erro ao criar categoria');
            },
            complete: function() {
                $btn.prop('disabled', false).text('Criar Categoria');
            }
        });
    });
    
    // Formulário principal
    $('#form-cadastro-expositor').on('submit', function(e) {
        e.preventDefault();
        
        console.log('Formulário submetido');
        
        // Garantir que o TinyMCE salvou o conteúdo
        if (typeof tinyMCE !== 'undefined') {
            tinyMCE.triggerSave();
        }
        
        <?php if (!$is_edit): ?>
        // Validação de imagem principal no cadastro inicial
        if (!$('#imagem_destaque')[0].files.length) {
            alert('❌ Por favor, selecione uma imagem principal para seu negócio/produto.');
            $('#imagem_destaque').focus();
            return false;
        }
        
        // Validar tamanho da imagem (máx 5MB)
        var imagemDestaque = $('#imagem_destaque')[0].files[0];
        if (imagemDestaque) {
            var maxSize = 5 * 1024 * 1024; // 5MB
            if (imagemDestaque.size > maxSize) {
                var fileSizeMB = (imagemDestaque.size / 1024 / 1024).toFixed(2);
                alert('❌ Erro: A imagem principal tem ' + fileSizeMB + 'MB.\n\nO tamanho máximo permitido é 5MB.\n\nPor favor, selecione uma imagem menor ou comprima a imagem antes de fazer upload.');
                $('#imagem_destaque').focus();
                return false;
            }
        }
        <?php endif; ?>
        
        var formData = new FormData(this);
        
        console.log('FormData criado, campos:');
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + (pair[1] instanceof File ? 'FILE: ' + pair[1].name : pair[1]));
        }
        
        var $btn = $('.btn-submit');
        var btnText = $btn.text();
        
        $btn.prop('disabled', true).text('Enviando...');
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Resposta AJAX:', response);
                
                if (response.success) {
                    $('#mensagem-resultado')
                        .removeClass('mensagem-erro')
                        .addClass('mensagem-sucesso')
                        .html('<strong>✓ Sucesso!</strong> ' + response.data.message)
                        .slideDown();
                    
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    var errorMsg = response.data || 'Erro desconhecido';
                    $('#mensagem-resultado')
                        .removeClass('mensagem-sucesso')
                        .addClass('mensagem-erro')
                        .html('<strong>✗ Erro!</strong> ' + errorMsg)
                        .slideDown();
                    
                    $btn.prop('disabled', false).text(btnText);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro AJAX completo:', {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                    statusCode: xhr.status
                });
                
                var errorMsg = 'Ocorreu um erro ao enviar o formulário.';
                
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response && response.data) {
                        errorMsg = response.data;
                    }
                } catch(e) {
                    console.error('Erro ao parsear resposta:', e);
                }
                
                $('#mensagem-resultado')
                    .removeClass('mensagem-sucesso')
                    .addClass('mensagem-erro')
                    .html('<strong>✗ Erro!</strong> ' + errorMsg)
                    .slideDown();
                
                $btn.prop('disabled', false).text(btnText);
            }
        });
    });
    
    <?php if ($is_edit && $status == 'publish'): ?>
    // Gerar QR Code
    var qrcodeObj = null;
    
    $('#btn-gerar-qrcode').on('click', function() {
        var pageUrl = '<?php echo get_permalink($expositor_id); ?>';
        
        // Limpar QR Code anterior se existir
        $('#qrcode').empty();
        
        // Gerar novo QR Code em alta resolução para impressão A4
        qrcodeObj = new QRCode(document.getElementById('qrcode'), {
            text: pageUrl,
            width: 512,
            height: 512,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
        
        // Mostrar modal
        $('#modal-qrcode').css('display', 'flex');
    });
    
    // Fechar modal
    $('#fechar-modal-qrcode, #modal-qrcode').on('click', function(e) {
        if (e.target === this) {
            $('#modal-qrcode').hide();
        }
    });
    
    // Download QR Code
    $('#btn-download-qrcode').on('click', function() {
        var canvas = $('#qrcode canvas')[0];
        if (canvas) {
            var link = document.createElement('a');
            link.download = 'qrcode-<?php echo sanitize_title($expositor->post_title); ?>.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }
    });
    
    // Imprimir QR Code
    $('#btn-imprimir-qrcode').on('click', function() {
        var canvas = $('#qrcode canvas')[0];
        if (!canvas) return;
        
        // Criar janela de impressão com apenas o QR Code
        var printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>QR Code - <?php echo esc_js($expositor->post_title); ?></title>');
        printWindow.document.write('<style>');
        printWindow.document.write('body { margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }');
        printWindow.document.write('@media print { @page { size: A4; margin: 2cm; } body { margin: 0; } img { max-width: 100%; height: auto; } }');
        printWindow.document.write('</style></head><body>');
        printWindow.document.write('<img src="' + canvas.toDataURL() + '" />');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        
        // Aguardar carregamento e imprimir
        setTimeout(function() {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 250);
    });
    <?php endif; ?>
});
</script>

<?php get_footer(); ?>
