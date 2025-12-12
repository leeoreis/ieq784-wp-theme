<?php
/**
 * Chomneq Template Functions
 * 
 * @package Chomneq_Template
 */

// Evitar acesso direto
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Setup do tema
 */
function chomneq_setup() {
    // Suporte a título dinâmico
    add_theme_support('title-tag');
    
    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(800, 600, true);
    add_image_size('expositor-card', 400, 300, true);
    add_image_size('expositor-hero', 1200, 600, true);
    
    // Suporte a HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Registro de menus
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'chomneq'),
        'footer' => __('Menu Rodapé', 'chomneq'),
    ));
}
add_action('after_setup_theme', 'chomneq_setup');

/**
 * Meta tags SEO e Open Graph
 */
function chomneq_add_meta_tags() {
    $site_name = 'Portal da Região 784 - IEQ Rio de Janeiro';
    $site_description = 'Portal da Região 784 da Igreja do Evangelho Quadrangular no Rio de Janeiro. Confira nossas igrejas regionais, atividades, eventos e programações.';
    $site_url = home_url();
    $site_image = 'https://assets-ieq784.leoreis.dev.br/wp-content/uploads/og-image.png';
    
    // SEO Básico
    echo '<meta name="description" content="' . esc_attr($site_description) . '">' . "\n";
    echo '<meta name="keywords" content="IEQ, Igreja do Evangelho Quadrangular, Região 784, Rio de Janeiro, RJ, Padre Miguel, Igreja Evangélica, Cultos, Eventos, Programação">' . "\n";
    echo '<meta name="author" content="Leonardo Reis dos Santos">' . "\n";
    echo '<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">' . "\n";
    
    // Open Graph (Facebook, LinkedIn, WhatsApp)
    echo '<meta property="og:locale" content="pt_BR">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($site_description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($site_url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    
    // Imagem OG
    if (is_singular() && has_post_thumbnail()) {
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        if ($thumbnail) {
            echo '<meta property="og:image" content="' . esc_url($thumbnail[0]) . '">' . "\n";
            echo '<meta property="og:image:width" content="' . esc_attr($thumbnail[1]) . '">' . "\n";
            echo '<meta property="og:image:height" content="' . esc_attr($thumbnail[2]) . '">' . "\n";
        }
    } else {
        echo '<meta property="og:image" content="' . esc_url($site_image) . '">' . "\n";
        echo '<meta property="og:image:width" content="1200">' . "\n";
        echo '<meta property="og:image:height" content="630">' . "\n";
    }
    
    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($site_description) . '">' . "\n";
    
    // Informações de contato e localização (Schema.org)
    echo '<meta itemprop="name" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta itemprop="description" content="' . esc_attr($site_description) . '">' . "\n";
    
    // Canonical URL
    echo '<link rel="canonical" href="' . esc_url($site_url) . '">' . "\n";
    
    // Geo tags para SEO local
    echo '<meta name="geo.region" content="BR-RJ">' . "\n";
    echo '<meta name="geo.placename" content="Rio de Janeiro">' . "\n";
    echo '<meta name="geo.position" content="-22.878178;-43.461497">' . "\n";
    echo '<meta name="ICBM" content="-22.878178, -43.461497">' . "\n";
}
add_action('wp_head', 'chomneq_add_meta_tags', 1);

/**
 * Schema.org JSON-LD para SEO
 */
function chomneq_add_schema_org() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Church',
        'name' => 'IEQ Região 784 - Rio de Janeiro',
        'description' => 'Portal da Região 784 da Igreja do Evangelho Quadrangular no Rio de Janeiro',
        'url' => home_url(),
        'logo' => get_template_directory_uri() . '/assets/logo.png',
        'telephone' => '+55-21-XXXX-XXXX',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => 'Rua Murundu, 377',
            'addressLocality' => 'Padre Miguel',
            'addressRegion' => 'RJ',
            'postalCode' => '21715-300',
            'addressCountry' => 'BR'
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => '-22.878178',
            'longitude' => '-43.461497'
        ),
        'sameAs' => array(
            'https://www.instagram.com/ieq784',
            'https://www.facebook.com/ieq784'
        )
    );
    
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    
    // WebSite Schema
    $website_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Portal da Região 784 - IEQ Rio de Janeiro',
        'url' => home_url(),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => home_url('/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string'
        ),
        'author' => array(
            '@type' => 'Person',
            'name' => 'Leonardo Reis dos Santos',
            'url' => 'https://www.linkedin.com/in/leeoreis/'
        )
    );
    
    echo '<script type="application/ld+json">' . json_encode($website_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'chomneq_add_schema_org', 2);

/**
 * Adicionar sitemap XML hint
 */
function chomneq_add_sitemap_hint() {
    echo '<link rel="sitemap" type="application/xml" title="Sitemap" href="' . home_url('/sitemap.xml') . '">' . "\n";
}
add_action('wp_head', 'chomneq_add_sitemap_hint', 3);

/**
 * Otimizações de Performance
 */
function chomneq_performance_optimizations() {
    // Remover emojis (reduz requisições HTTP)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Remover WordPress embed (se não usa embeds internos)
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    
    // Remover links REST API desnecessários no head
    remove_action('wp_head', 'rest_output_link_header', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11);
    
    // Remover generator tag
    remove_action('wp_head', 'wp_generator');
    
    // Remover RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remover wlwmanifest
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remover shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'chomneq_performance_optimizations');

/**
 * Desabilitar Gutenberg CSS no frontend (se não usa blocos)
 */
function chomneq_remove_wp_block_library_css() {
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-blocks-style');
        wp_dequeue_style('global-styles');
    }
}
add_action('wp_enqueue_scripts', 'chomneq_remove_wp_block_library_css', 100);

/**
 * Limitar revisões de posts
 */
if (!defined('WP_POST_REVISIONS')) {
    define('WP_POST_REVISIONS', 3);
}

/**
 * Otimizar queries do WordPress
 */
function chomneq_optimize_queries($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Desabilitar busca de attachments em queries principais
        if ($query->is_search()) {
            $query->set('post_type', array('post', 'page', 'expositor', 'igreja_regional', 'atividade'));
        }
    }
}
add_action('pre_get_posts', 'chomneq_optimize_queries');

/**
 * Lazy load para imagens (nativo do WP 5.5+)
 */
add_filter('wp_lazy_loading_enabled', '__return_true');

/**
 * ========================================
 * AWS S3 Integration
 * ========================================
 */

/**
 * Adicionar página de configurações AWS S3
 */
function chomneq_add_s3_settings_page() {
    add_options_page(
        'Configurações AWS S3',
        'CDN',
        'manage_options',
        'chomneq-s3-settings',
        'chomneq_render_s3_settings_page'
    );
}
add_action('admin_menu', 'chomneq_add_s3_settings_page');

/**
 * Registrar configurações S3
 */
function chomneq_register_s3_settings() {
    register_setting('chomneq_s3_settings', 'chomneq_s3_access_key');
    register_setting('chomneq_s3_settings', 'chomneq_s3_secret_key');
    register_setting('chomneq_s3_settings', 'chomneq_s3_bucket');
    register_setting('chomneq_s3_settings', 'chomneq_s3_region');
    register_setting('chomneq_s3_settings', 'chomneq_s3_cloudfront_url');
    register_setting('chomneq_s3_settings', 'chomneq_s3_enabled');
}
add_action('admin_init', 'chomneq_register_s3_settings');

/**
 * Renderizar página de configurações
 */
function chomneq_render_s3_settings_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Testar conexão se solicitado
    $connection_status = '';
    if (isset($_GET['test_connection']) && $_GET['test_connection'] == '1') {
        $test_result = chomneq_test_s3_connection();
        if ($test_result['success']) {
            $connection_status = '<div class="notice notice-success"><p>✅ Conexão com AWS S3 estabelecida com sucesso!</p></div>';
        } else {
            $connection_status = '<div class="notice notice-error"><p>❌ Erro na conexão: ' . esc_html($test_result['message']) . '</p></div>';
        }
    }
    
    // Sincronizar biblioteca com S3
    if (isset($_GET['sync_media']) && $_GET['sync_media'] == '1') {
        $sync_result = chomneq_sync_media_to_s3();
        if ($sync_result['success']) {
            $connection_status = '<div class="notice notice-success"><p>✅ ' . esc_html($sync_result['message']) . '</p></div>';
        } else {
            $connection_status = '<div class="notice notice-error"><p>❌ ' . esc_html($sync_result['message']) . '</p></div>';
        }
    }
    
    // Listar arquivos do S3
    if (isset($_GET['list_s3']) && $_GET['list_s3'] == '1') {
        $list_result = chomneq_list_s3_files();
        if ($list_result['success']) {
            $files_list = '<ul style="max-height: 300px; overflow-y: auto; background: #f5f5f5; padding: 15px; margin: 10px 0;">';
            foreach ($list_result['files'] as $file) {
                $files_list .= '<li>' . esc_html($file) . '</li>';
            }
            $files_list .= '</ul>';
            $connection_status = '<div class="notice notice-info"><p><strong>📋 Arquivos no S3 (' . count($list_result['files']) . '):</strong></p>' . $files_list . '</div>';
        } else {
            $connection_status = '<div class="notice notice-error"><p>❌ ' . esc_html($list_result['message']) . '</p></div>';
        }
    }
    
    if (isset($_GET['settings-updated'])) {
        add_settings_error('chomneq_s3_messages', 'chomneq_s3_message', 'Configurações salvas com sucesso!', 'updated');
    }
    
    settings_errors('chomneq_s3_messages');
    ?>
    <div class="wrap">
        <h1>⚙️ Configurações AWS S3 / CDN</h1>
        
        <?php echo $connection_status; ?>
        
        <div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04); margin-top: 20px;">
            <h2>📋 Como Obter as Credenciais</h2>
            <ol style="line-height: 1.8;">
                <li><strong>AWS Access Key ID e Secret Access Key:</strong>
                    <ul>
                        <li>Acesse o <a href="https://console.aws.amazon.com/iam/" target="_blank">AWS IAM Console</a></li>
                        <li>Vá em "Users" → Seu usuário → "Security credentials"</li>
                        <li>Clique em "Create access key"</li>
                    </ul>
                </li>
                <li><strong>Bucket Name:</strong>
                    <ul>
                        <li>Acesse o <a href="https://s3.console.aws.amazon.com/" target="_blank">AWS S3 Console</a></li>
                        <li>Crie um bucket ou use um existente</li>
                        <li>Configure como público (desmarque "Block all public access")</li>
                    </ul>
                </li>
                <li><strong>Region:</strong> Ex: us-east-1, sa-east-1 (São Paulo)</li>
                <li><strong>CloudFront URL:</strong> (Opcional) URL da distribuição CloudFront</li>
            </ol>
            
            <h3>🔐 Permissões IAM Necessárias:</h3>
            <pre style="background: #f5f5f5; padding: 15px; border-radius: 4px; overflow-x: auto;">
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": [
        "s3:PutObject",
        "s3:GetObject",
        "s3:DeleteObject",
        "s3:ListBucket"
      ],
      "Resource": [
        "arn:aws:s3:::SEU-BUCKET/*",
        "arn:aws:s3:::SEU-BUCKET"
      ]
    }
  ]
}</pre>
        </div>
        
        <form method="post" action="options.php" style="margin-top: 20px;">
            <?php settings_fields('chomneq_s3_settings'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="chomneq_s3_enabled">Habilitar S3</label>
                    </th>
                    <td>
                        <input type="checkbox" 
                               id="chomneq_s3_enabled" 
                               name="chomneq_s3_enabled" 
                               value="1" 
                               <?php checked(1, get_option('chomneq_s3_enabled'), true); ?>>
                        <p class="description">Marque para ativar o upload automático para S3</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="chomneq_s3_access_key">AWS Access Key ID *</label>
                    </th>
                    <td>
                        <input type="text" 
                               id="chomneq_s3_access_key" 
                               name="chomneq_s3_access_key" 
                               value="<?php echo esc_attr(get_option('chomneq_s3_access_key')); ?>" 
                               class="regular-text">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="chomneq_s3_secret_key">AWS Secret Access Key *</label>
                    </th>
                    <td>
                        <input type="password" 
                               id="chomneq_s3_secret_key" 
                               name="chomneq_s3_secret_key" 
                               value="<?php echo esc_attr(get_option('chomneq_s3_secret_key')); ?>" 
                               class="regular-text">
                        <p class="description">Mantenha esta chave em segredo</p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="chomneq_s3_bucket">Bucket Name *</label>
                    </th>
                    <td>
                        <input type="text" 
                               id="chomneq_s3_bucket" 
                               name="chomneq_s3_bucket" 
                               value="<?php echo esc_attr(get_option('chomneq_s3_bucket')); ?>" 
                               class="regular-text"
                               placeholder="meu-bucket-wordpress">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="chomneq_s3_region">Region *</label>
                    </th>
                    <td>
                        <select id="chomneq_s3_region" name="chomneq_s3_region" class="regular-text">
                            <option value="">Selecione a região</option>
                            <?php
                            $regions = array(
                                'us-east-1' => 'US East (N. Virginia)',
                                'us-east-2' => 'US East (Ohio)',
                                'us-west-1' => 'US West (N. California)',
                                'us-west-2' => 'US West (Oregon)',
                                'sa-east-1' => 'South America (São Paulo)',
                                'eu-west-1' => 'Europe (Ireland)',
                                'eu-central-1' => 'Europe (Frankfurt)',
                                'ap-southeast-1' => 'Asia Pacific (Singapore)',
                                'ap-southeast-2' => 'Asia Pacific (Sydney)',
                            );
                            $current_region = get_option('chomneq_s3_region');
                            foreach ($regions as $code => $name) {
                                printf(
                                    '<option value="%s" %s>%s</option>',
                                    esc_attr($code),
                                    selected($current_region, $code, false),
                                    esc_html($name)
                                );
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="chomneq_s3_cloudfront_url">CloudFront URL</label>
                    </th>
                    <td>
                        <input type="url" 
                               id="chomneq_s3_cloudfront_url" 
                               name="chomneq_s3_cloudfront_url" 
                               value="<?php echo esc_attr(get_option('chomneq_s3_cloudfront_url')); ?>" 
                               class="regular-text"
                               placeholder="https://d1234567890.cloudfront.net">
                        <p class="description">Opcional: URL do CloudFront para CDN (sem barra no final)</p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button('Salvar Configurações'); ?>
        </form>
        
        <div style="margin-top: 20px;">
            <a href="<?php echo admin_url('options-general.php?page=chomneq-s3-settings&test_connection=1'); ?>" 
               class="button button-secondary">
                🔍 Testar Conexão com S3
            </a>
            
            <a href="<?php echo admin_url('options-general.php?page=chomneq-s3-settings&sync_media=1'); ?>" 
               class="button button-secondary"
               onclick="return confirm('Isso irá fazer upload de todas as imagens da biblioteca de mídia para o S3. Continuar?');">
                📤 Sincronizar Biblioteca com S3
            </a>
            
            <a href="<?php echo admin_url('options-general.php?page=chomneq-s3-settings&list_s3=1'); ?>" 
               class="button button-secondary">
                📋 Listar Arquivos no S3
            </a>
        </div>
        
        <div style="background: #fffbcc; border-left: 4px solid #ffb900; padding: 15px; margin-top: 20px;">
            <strong>⚠️ Importante:</strong>
            <ul style="margin: 10px 0 0 20px;">
                <li>Todas as novas imagens serão enviadas automaticamente para o S3</li>
                <li>URLs das imagens apontarão para o S3/CloudFront</li>
                <li>Imagens antigas no WordPress não serão migradas automaticamente</li>
                <li>Certifique-se de que o bucket tem as permissões corretas</li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * Testar conexão com S3
 */
function chomneq_test_s3_connection() {
    $access_key = get_option('chomneq_s3_access_key');
    $secret_key = get_option('chomneq_s3_secret_key');
    $bucket = get_option('chomneq_s3_bucket');
    $region = get_option('chomneq_s3_region');
    
    if (empty($access_key) || empty($secret_key) || empty($bucket) || empty($region)) {
        return array('success' => false, 'message' => 'Preencha todas as credenciais obrigatórias');
    }
    
    try {
        // Criar assinatura AWS
        $endpoint = "https://{$bucket}.s3.{$region}.amazonaws.com/";
        $date = gmdate('D, d M Y H:i:s T');
        $string_to_sign = "GET\n\n\n{$date}\n/{$bucket}/";
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $secret_key, true));
        
        $response = wp_remote_head($endpoint, array(
            'headers' => array(
                'Date' => $date,
                'Authorization' => "AWS {$access_key}:{$signature}"
            ),
            'timeout' => 10
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $code = wp_remote_retrieve_response_code($response);
        if ($code == 200 || $code == 403) { // 403 é ok, significa que bucket existe mas pode ter restrições
            return array('success' => true, 'message' => 'Conexão estabelecida');
        }
        
        return array('success' => false, 'message' => "Código de resposta: {$code}");
        
    } catch (Exception $e) {
        return array('success' => false, 'message' => $e->getMessage());
    }
}

/**
 * Sincronizar biblioteca de mídia existente com S3
 */
function chomneq_sync_media_to_s3() {
    if (!get_option('chomneq_s3_enabled')) {
        return array('success' => false, 'message' => 'S3 não está habilitado');
    }
    
    // Buscar todos os attachments de imagem
    $attachments = get_posts(array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'posts_per_page' => -1,
        'post_status' => 'inherit'
    ));
    
    if (empty($attachments)) {
        return array('success' => false, 'message' => 'Nenhuma imagem encontrada na biblioteca');
    }
    
    $uploaded = 0;
    $skipped = 0;
    $errors = 0;
    
    foreach ($attachments as $attachment) {
        $attachment_id = $attachment->ID;
        
        // Verificar se já foi enviado para S3
        if (get_post_meta($attachment_id, '_s3_url', true)) {
            $skipped++;
            continue;
        }
        
        $file_path = get_attached_file($attachment_id);
        
        if (!file_exists($file_path)) {
            $errors++;
            continue;
        }
        
        $mime_type = get_post_mime_type($attachment_id);
        $s3_url = chomneq_upload_to_s3($file_path, $mime_type);
        
        if ($s3_url) {
            update_post_meta($attachment_id, '_s3_url', $s3_url);
            
            // Upload dos thumbnails
            $metadata = wp_get_attachment_metadata($attachment_id);
            if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
                foreach ($metadata['sizes'] as $size => $size_data) {
                    $thumb_path = path_join(dirname($file_path), $size_data['file']);
                    
                    if (file_exists($thumb_path)) {
                        $thumb_s3_url = chomneq_upload_to_s3($thumb_path, $size_data['mime-type']);
                        
                        if ($thumb_s3_url) {
                            $metadata['sizes'][$size]['s3_url'] = $thumb_s3_url;
                        }
                    }
                }
                wp_update_attachment_metadata($attachment_id, $metadata);
            }
            
            $uploaded++;
        } else {
            $errors++;
        }
    }
    
    $message = "Sincronização concluída: {$uploaded} enviadas, {$skipped} já existiam, {$errors} erros";
    return array('success' => true, 'message' => $message);
}

/**
 * Listar arquivos no bucket S3
 */
function chomneq_list_s3_files() {
    $access_key = get_option('chomneq_s3_access_key');
    $secret_key = get_option('chomneq_s3_secret_key');
    $bucket = get_option('chomneq_s3_bucket');
    $region = get_option('chomneq_s3_region');
    
    if (empty($access_key) || empty($secret_key) || empty($bucket) || empty($region)) {
        return array('success' => false, 'message' => 'Credenciais incompletas');
    }
    
    try {
        $host = "{$bucket}.s3.{$region}.amazonaws.com";
        $prefix = 'wp-content/uploads/';
        $endpoint = "https://{$host}/?list-type=2&prefix={$prefix}";
        
        $date = gmdate('Ymd\\THis\\Z');
        $date_short = gmdate('Ymd');
        
        // Headers para AWS Signature v4
        $headers = array(
            'Host' => $host,
            'x-amz-date' => $date,
        );
        
        $canonical_headers = "host:{$host}\nx-amz-date:{$date}\n";
        $signed_headers = 'host;x-amz-date';
        $payload_hash = hash('sha256', '');
        
        $canonical_request = "GET\n/\nlist-type=2&prefix={$prefix}\n{$canonical_headers}\n{$signed_headers}\n{$payload_hash}";
        
        $scope = "{$date_short}/{$region}/s3/aws4_request";
        $string_to_sign = "AWS4-HMAC-SHA256\n{$date}\n{$scope}\n" . hash('sha256', $canonical_request);
        
        $k_date = hash_hmac('sha256', $date_short, "AWS4{$secret_key}", true);
        $k_region = hash_hmac('sha256', $region, $k_date, true);
        $k_service = hash_hmac('sha256', 's3', $k_region, true);
        $k_signing = hash_hmac('sha256', 'aws4_request', $k_service, true);
        
        $signature = hash_hmac('sha256', $string_to_sign, $k_signing);
        $authorization = "AWS4-HMAC-SHA256 Credential={$access_key}/{$scope}, SignedHeaders={$signed_headers}, Signature={$signature}";
        
        unset($headers['Host']);
        
        $response = wp_remote_get($endpoint, array(
            'headers' => array_merge($headers, array(
                'Authorization' => $authorization
            )),
            'timeout' => 15
        ));
        
        if (is_wp_error($response)) {
            return array('success' => false, 'message' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $xml = simplexml_load_string($body);
        
        if ($xml === false) {
            return array('success' => false, 'message' => 'Erro ao parsear resposta XML');
        }
        
        $files = array();
        if (isset($xml->Contents)) {
            foreach ($xml->Contents as $content) {
                $files[] = (string) $content->Key;
            }
        }
        
        return array('success' => true, 'files' => $files);
        
    } catch (Exception $e) {
        return array('success' => false, 'message' => $e->getMessage());
    }
}

/**
 * Otimizar imagem: redimensionar e comprimir
 */
function chomneq_optimize_image($file_path, $mime_type) {
    // Verificar se é imagem
    if (strpos($mime_type, 'image/') !== 0 || $mime_type === 'image/svg+xml') {
        return $file_path; // Não processar SVG
    }
    
    // Criar imagem do arquivo
    $image = null;
    switch ($mime_type) {
        case 'image/jpeg':
        case 'image/jpg':
            $image = @imagecreatefromjpeg($file_path);
            break;
        case 'image/png':
            $image = @imagecreatefrompng($file_path);
            break;
        case 'image/gif':
            $image = @imagecreatefromgif($file_path);
            break;
        case 'image/webp':
            $image = @imagecreatefromwebp($file_path);
            break;
    }
    
    if (!$image) {
        return $file_path; // Não conseguiu processar
    }
    
    $width = imagesx($image);
    $height = imagesy($image);
    
    // Determinar limites baseado na orientação
    $max_width = $width;
    $max_height = $height;
    
    if ($width > $height) {
        // Horizontal: 1920x1080
        if ($width > 1920 || $height > 1080) {
            $ratio = min(1920 / $width, 1080 / $height);
            $max_width = round($width * $ratio);
            $max_height = round($height * $ratio);
        }
    } elseif ($height > $width) {
        // Vertical: 1080x1920
        if ($width > 1080 || $height > 1920) {
            $ratio = min(1080 / $width, 1920 / $height);
            $max_width = round($width * $ratio);
            $max_height = round($height * $ratio);
        }
    } else {
        // Quadrada: 1000x1000
        if ($width > 1000) {
            $max_width = 1000;
            $max_height = 1000;
        }
    }
    
    // Redimensionar se necessário
    if ($max_width != $width || $max_height != $height) {
        $resized = imagecreatetruecolor($max_width, $max_height);
        
        // Preservar transparência para PNG
        if ($mime_type === 'image/png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
            imagefilledrectangle($resized, 0, 0, $max_width, $max_height, $transparent);
        }
        
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $max_width, $max_height, $width, $height);
        imagedestroy($image);
        $image = $resized;
    }
    
    // Criar arquivo temporário otimizado
    $temp_file = $file_path . '.optimized';
    
    // Salvar com compressão
    $success = false;
    switch ($mime_type) {
        case 'image/jpeg':
        case 'image/jpg':
            $success = imagejpeg($image, $temp_file, 85); // Qualidade 85%
            break;
        case 'image/png':
            $success = imagepng($image, $temp_file, 6); // Compressão nível 6
            break;
        case 'image/gif':
            $success = imagegif($image, $temp_file);
            break;
        case 'image/webp':
            $success = imagewebp($image, $temp_file, 85);
            break;
    }
    
    imagedestroy($image);
    
    if ($success && file_exists($temp_file)) {
        // Substituir arquivo original pelo otimizado
        rename($temp_file, $file_path);
    }
    
    return $file_path;
}

/**
 * Upload de arquivo para S3
 */
function chomneq_upload_to_s3($file_path, $mime_type) {
    if (!get_option('chomneq_s3_enabled')) {
        return false;
    }
    
    $access_key = get_option('chomneq_s3_access_key');
    $secret_key = get_option('chomneq_s3_secret_key');
    $bucket = get_option('chomneq_s3_bucket');
    $region = get_option('chomneq_s3_region');
    
    if (empty($access_key) || empty($secret_key) || empty($bucket) || empty($region)) {
        error_log('S3 Upload Failed: Missing credentials');
        return false;
    }
    
    // Otimizar imagem antes do upload
    if (strpos($mime_type, 'image/') === 0) {
        $file_path = chomneq_optimize_image($file_path, $mime_type);
    }
    
    // Gerar nome único do arquivo
    $filename = basename($file_path);
    $date_path = date('Y/m');
    $s3_key = "wp-content/uploads/{$date_path}/{$filename}";
    $s3_key_encoded = str_replace('%2F', '/', rawurlencode($s3_key));
    
    // Ler conteúdo do arquivo
    $file_content = file_get_contents($file_path);
    if ($file_content === false) {
        error_log('S3 Upload Failed: Cannot read file');
        return false;
    }
    
    // Criar assinatura AWS v4
    $host = "{$bucket}.s3.{$region}.amazonaws.com";
    $endpoint = "https://{$host}/{$s3_key_encoded}";
    $date = gmdate('Ymd\THis\Z');
    $date_short = gmdate('Ymd');
    
    // Headers
    $content_length = strlen($file_content);
    $headers = array(
        'Host' => $host,
        'Content-Type' => $mime_type,
        'Content-Length' => $content_length,
        'x-amz-content-sha256' => hash('sha256', $file_content),
        'x-amz-date' => $date,
    );
    
    // Criar assinatura
    $canonical_headers = '';
    $signed_headers = '';
    $header_keys = array_keys($headers);
    sort($header_keys);
    
    foreach ($header_keys as $key) {
        if (!is_string($key) || !isset($headers[$key])) {
            continue;
        }
        $canonical_headers .= strtolower($key) . ':' . trim($headers[$key]) . "\n";
        $signed_headers .= strtolower($key) . ';';
    }
    $signed_headers = rtrim($signed_headers, ';');
    
    $payload_hash = hash('sha256', $file_content);
    $canonical_request = "PUT\n/{$s3_key_encoded}\n\n{$canonical_headers}\n{$signed_headers}\n{$payload_hash}";
    
    $scope = "{$date_short}/{$region}/s3/aws4_request";
    $string_to_sign = "AWS4-HMAC-SHA256\n{$date}\n{$scope}\n" . hash('sha256', $canonical_request);
    
    $k_date = hash_hmac('sha256', $date_short, "AWS4{$secret_key}", true);
    $k_region = hash_hmac('sha256', $region, $k_date, true);
    $k_service = hash_hmac('sha256', 's3', $k_region, true);
    $k_signing = hash_hmac('sha256', 'aws4_request', $k_service, true);
    
    $signature = hash_hmac('sha256', $string_to_sign, $k_signing);
    
    $authorization = "AWS4-HMAC-SHA256 Credential={$access_key}/{$scope}, SignedHeaders={$signed_headers}, Signature={$signature}";
    
    // Remover Host do array de headers (wp_remote_request já adiciona)
    unset($headers['Host']);
    
    // Fazer upload
    $response = wp_remote_request($endpoint, array(
        'method' => 'PUT',
        'headers' => array_merge($headers, array(
            'Authorization' => $authorization
        )),
        'body' => $file_content,
        'timeout' => 30
    ));
    
    if (is_wp_error($response)) {
        error_log('S3 Upload Error: ' . $response->get_error_message());
        return false;
    }
    
    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    
    if ($code != 200) {
        error_log("S3 Upload Failed. Response code: {$code}, Body: {$body}");
        return false;
    }
    
    // Retornar URL da imagem
    $cloudfront_url = get_option('chomneq_s3_cloudfront_url');
    if (!empty($cloudfront_url)) {
        return rtrim($cloudfront_url, '/') . '/' . $s3_key;
    }
    
    return "https://{$bucket}.s3.{$region}.amazonaws.com/{$s3_key}";
}

/**
 * Hook para interceptar upload de imagens
 */
function chomneq_handle_upload($upload) {
    if (!get_option('chomneq_s3_enabled')) {
        return $upload;
    }
    
    if (isset($upload['file']) && isset($upload['type'])) {
        $s3_url = chomneq_upload_to_s3($upload['file'], $upload['type']);
        
        if ($s3_url) {
            // Atualizar URL mas MANTER arquivo local para o WordPress processar thumbnails
            $upload['url'] = $s3_url;
            // Não alterar $upload['file'] para permitir geração de thumbnails
        }
    }
    
    return $upload;
}
add_filter('wp_handle_upload', 'chomneq_handle_upload');

/**
 * Upload de thumbnails para S3 após geração
 */
function chomneq_upload_thumbnails_to_s3($metadata, $attachment_id) {
    if (!get_option('chomneq_s3_enabled')) {
        return $metadata;
    }
    
    $upload_dir = wp_upload_dir();
    $file_path = get_attached_file($attachment_id);
    
    // Upload da imagem principal
    if (file_exists($file_path)) {
        $mime_type = get_post_mime_type($attachment_id);
        $s3_url = chomneq_upload_to_s3($file_path, $mime_type);
        
        if ($s3_url) {
            // Atualizar URL no metadata
            update_post_meta($attachment_id, '_s3_url', $s3_url);
            
            // Deletar arquivo local principal
            @unlink($file_path);
        }
    }
    
    // Upload dos thumbnails
    if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
        foreach ($metadata['sizes'] as $size => $size_data) {
            $thumb_path = path_join(dirname($file_path), $size_data['file']);
            
            if (file_exists($thumb_path)) {
                $thumb_s3_url = chomneq_upload_to_s3($thumb_path, $size_data['mime-type']);
                
                if ($thumb_s3_url) {
                    // Armazenar URL do S3 no metadata
                    $metadata['sizes'][$size]['s3_url'] = $thumb_s3_url;
                    
                    // Deletar thumbnail local
                    @unlink($thumb_path);
                }
            }
        }
    }
    
    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'chomneq_upload_thumbnails_to_s3', 10, 2);

/**
 * Modificar URL das imagens para usar S3
 */
function chomneq_attachment_url_to_s3($url, $attachment_id) {
    if (!get_option('chomneq_s3_enabled')) {
        return $url;
    }
    
    $s3_url = get_post_meta($attachment_id, '_s3_url', true);
    
    if (!empty($s3_url)) {
        return $s3_url;
    }
    
    return $url;
}
add_filter('wp_get_attachment_url', 'chomneq_attachment_url_to_s3', 10, 2);

/**
 * Modificar URL dos thumbnails para usar S3
 */
function chomneq_attachment_image_src_to_s3($image, $attachment_id, $size, $icon) {
    if (!get_option('chomneq_s3_enabled')) {
        return $image;
    }
    
    // Validar se $image é um array válido
    if (!is_array($image) || empty($image)) {
        return $image;
    }
    
    // Garantir que temos o índice 0
    if (!array_key_exists(0, $image)) {
        return $image;
    }
    
    // Se $size for array, não processar (pode ser tamanho customizado)
    if (is_array($size)) {
        return $image;
    }
    
    $metadata = wp_get_attachment_metadata($attachment_id);
    
    if ($size === 'full') {
        $s3_url = get_post_meta($attachment_id, '_s3_url', true);
        if (!empty($s3_url)) {
            $image[0] = $s3_url;
        }
    } else {
        // Verificar metadata step by step para PHP 8.5
        if (!is_array($metadata)) {
            return $image;
        }
        
        if (!array_key_exists('sizes', $metadata)) {
            return $image;
        }
        
        if (!is_array($metadata['sizes'])) {
            return $image;
        }
        
        if (!array_key_exists($size, $metadata['sizes'])) {
            return $image;
        }
        
        $size_data = $metadata['sizes'][$size];
        
        if (!is_array($size_data)) {
            return $image;
        }
        
        if (array_key_exists('s3_url', $size_data)) {
            $image[0] = $size_data['s3_url'];
        }
    }
    
    return $image;
}
add_filter('wp_get_attachment_image_src', 'chomneq_attachment_image_src_to_s3', 10, 4);

/**
 * Modificar srcset para usar URLs do S3
 */
function chomneq_attachment_image_srcset_to_s3($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    if (!get_option('chomneq_s3_enabled')) {
        return $sources;
    }
    
    foreach ($sources as $width => $source) {
        // Encontrar o tamanho correspondente
        foreach ($image_meta['sizes'] as $size_name => $size_data) {
            if ($size_data['width'] == $width && isset($size_data['s3_url'])) {
                $sources[$width]['url'] = $size_data['s3_url'];
                break;
            }
        }
    }
    
    return $sources;
}
add_filter('wp_calculate_image_srcset', 'chomneq_attachment_image_srcset_to_s3', 10, 5);

/**
 * Criar páginas necessárias e configurar rotas
 */
function chomneq_create_pages_and_routes() {
    // Criar página "Em Construção" se não existir
    $home_page = get_page_by_path('em-construcao');
    if (!$home_page) {
        $home_page_id = wp_insert_post(array(
            'post_title' => 'Em Construção',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'em-construcao',
            'page_template' => 'page-em-construcao.php'
        ));
        
        if ($home_page_id) {
            update_post_meta($home_page_id, '_wp_page_template', 'page-em-construcao.php');
            
            // Definir como página inicial
            update_option('page_on_front', $home_page_id);
            update_option('show_on_front', 'page');
        }
    } else {
        // Garantir que está definida como página inicial
        update_option('page_on_front', $home_page->ID);
        update_option('show_on_front', 'page');
    }
    
    // Criar página "Chomneq 2025" se não existir (será a página de expositores)
    $chomneq_page = get_page_by_path('chomneq2025');
    if (!$chomneq_page) {
        $chomneq_page_id = wp_insert_post(array(
            'post_title' => 'Chomneq 2025',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'chomneq2025',
            'page_template' => 'page-chomneq2025.php'
        ));
        
        if ($chomneq_page_id) {
            update_post_meta($chomneq_page_id, '_wp_page_template', 'page-chomneq2025.php');
        }
    }
    
    // Forçar flush das regras de rewrite
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'chomneq_create_pages_and_routes');

/**
 * Adicionar rewrite rules customizadas
 */
function chomneq_add_rewrite_rules() {
    // Garantir que /chomneq2025 funcione
    add_rewrite_rule('^chomneq2025/?$', 'index.php?pagename=chomneq2025', 'top');
    add_rewrite_rule('^chomneq2025/(.+)/?$', 'index.php?pagename=chomneq2025/$matches[1]', 'top');
}
add_action('init', 'chomneq_add_rewrite_rules');

/**
 * Registrar Custom Post Type - Expositores
 */
function chomneq_register_expositor_post_type() {
    $labels = array(
        'name' => 'Expositores',
        'singular_name' => 'Expositor',
        'menu_name' => 'Expositores',
        'add_new' => 'Adicionar Novo',
        'add_new_item' => 'Adicionar Novo Expositor',
        'edit_item' => 'Editar Expositor',
        'new_item' => 'Novo Expositor',
        'view_item' => 'Ver Expositor',
        'search_items' => 'Buscar Expositores',
        'not_found' => 'Nenhum expositor encontrado',
        'not_found_in_trash' => 'Nenhum expositor encontrado na lixeira',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-store',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'expositor'),
        'show_in_rest' => false, // DESABILITAR GUTENBERG
        'menu_position' => 5,
    );

    register_post_type('expositor', $args);
}
add_action('init', 'chomneq_register_expositor_post_type');

/**
 * Registrar Taxonomia - Categorias de Expositores
 */
function chomneq_register_categoria_taxonomy() {
    $labels = array(
        'name' => 'Categorias',
        'singular_name' => 'Categoria',
        'search_items' => 'Buscar Categorias',
        'all_items' => 'Todas as Categorias',
        'edit_item' => 'Editar Categoria',
        'update_item' => 'Atualizar Categoria',
        'add_new_item' => 'Adicionar Nova Categoria',
        'new_item_name' => 'Nome da Nova Categoria',
        'menu_name' => 'Categorias',
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'categoria-expositor'),
    );

    register_taxonomy('categoria_expositor', array('expositor'), $args);
}
add_action('init', 'chomneq_register_categoria_taxonomy');

/**
 * Registrar Taxonomia - Regionais
 */
function chomneq_register_regional_taxonomy() {
    $labels = array(
        'name' => 'Regionais',
        'singular_name' => 'Regional',
        'search_items' => 'Buscar Regionais',
        'all_items' => 'Todas as Regionais',
        'edit_item' => 'Editar Regional',
        'update_item' => 'Atualizar Regional',
        'add_new_item' => 'Adicionar Nova Regional',
        'new_item_name' => 'Nome da Nova Regional',
        'menu_name' => 'Regionais',
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'regional'),
    );

    register_taxonomy('regional_expositor', array('expositor'), $args);
}
add_action('init', 'chomneq_register_regional_taxonomy');

/**
 * Registrar Custom Post Type - Igrejas Regionais (para página em construção)
 */
function chomneq_register_igreja_cpt() {
    $labels = array(
        'name' => 'Igrejas Regionais',
        'singular_name' => 'Igreja Regional',
        'menu_name' => 'Igrejas Regionais',
        'add_new' => 'Adicionar Nova',
        'add_new_item' => 'Adicionar Nova Igreja',
        'edit_item' => 'Editar Igreja',
        'new_item' => 'Nova Igreja',
        'view_item' => 'Ver Igreja',
        'search_items' => 'Buscar Igrejas',
        'not_found' => 'Nenhuma igreja encontrada',
        'not_found_in_trash' => 'Nenhuma igreja na lixeira',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-admin-multisite',
        'supports' => array('title', 'thumbnail'),
        'show_in_rest' => false,
        'menu_position' => 20,
        'rewrite' => array('slug' => 'igreja'),
    );

    register_post_type('igreja_regional', $args);
}
add_action('init', 'chomneq_register_igreja_cpt');

/**
 * Registrar Custom Post Type - Atividades/Eventos
 */
function chomneq_register_atividade_cpt() {
    $labels = array(
        'name' => 'Atividades',
        'singular_name' => 'Atividade',
        'menu_name' => 'Atividades',
        'add_new' => 'Adicionar Nova',
        'add_new_item' => 'Adicionar Nova Atividade',
        'edit_item' => 'Editar Atividade',
        'new_item' => 'Nova Atividade',
        'view_item' => 'Ver Atividade',
        'search_items' => 'Buscar Atividades',
        'not_found' => 'Nenhuma atividade encontrada',
        'not_found_in_trash' => 'Nenhuma atividade na lixeira',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => false,
        'menu_position' => 21,
        'rewrite' => array('slug' => 'atividade'),
    );

    register_post_type('atividade', $args);
}
add_action('init', 'chomneq_register_atividade_cpt');

/**
 * Meta Boxes para Igreja Regional
 */
function chomneq_igreja_meta_boxes() {
    add_meta_box(
        'igreja_info',
        'Informações da Igreja',
        'chomneq_igreja_info_callback',
        'igreja_regional',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'chomneq_igreja_meta_boxes');

function chomneq_igreja_info_callback($post) {
    wp_nonce_field('chomneq_save_igreja_meta', 'igreja_meta_nonce');
    
    $instagram = get_post_meta($post->ID, '_igreja_instagram', true);
    $ordem = get_post_meta($post->ID, '_igreja_ordem', true);
    $is_sede = get_post_meta($post->ID, '_igreja_sede', true);
    $pastor = get_post_meta($post->ID, '_igreja_pastor', true);
    $endereco = get_post_meta($post->ID, '_igreja_endereco', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="igreja_pastor">Pastor Líder:</label></th>
            <td>
                <input type="text" id="igreja_pastor" name="igreja_pastor" 
                       value="<?php echo esc_attr($pastor); ?>" 
                       class="regular-text" placeholder="Pr. João Silva">
                <p class="description">Nome do pastor líder da igreja</p>
            </td>
        </tr>
        <tr>
            <th><label for="igreja_endereco">Endereço:</label></th>
            <td>
                <textarea id="igreja_endereco" name="igreja_endereco" 
                          class="large-text" rows="3" 
                          placeholder="Rua Exemplo, 123 - Bairro - Cidade/UF"><?php echo esc_textarea($endereco); ?></textarea>
                <p class="description">Endereço completo da igreja</p>
            </td>
        </tr>
        <tr>
            <th><label for="igreja_instagram">Link do Instagram:</label></th>
            <td>
                <input type="url" id="igreja_instagram" name="igreja_instagram" 
                       value="<?php echo esc_attr($instagram); ?>" 
                       class="regular-text" placeholder="https://instagram.com/ieqparque">
                <p class="description">Cole o link completo do perfil do Instagram da igreja</p>
            </td>
        </tr>
        <tr>
            <th><label for="igreja_ordem">Ordem de Exibição:</label></th>
            <td>
                <input type="number" id="igreja_ordem" name="igreja_ordem" 
                       value="<?php echo esc_attr($ordem); ?>" 
                       class="small-text" min="0" step="1">
                <p class="description">Número menor aparece primeiro (0, 1, 2, 3...)</p>
            </td>
        </tr>
        <tr>
            <th><label for="igreja_sede">Igreja Sede:</label></th>
            <td>
                <input type="checkbox" id="igreja_sede" name="igreja_sede" value="1" <?php checked($is_sede, '1'); ?>>
                <label for="igreja_sede">Marcar esta igreja como sede</label>
                <p class="description">Apenas uma igreja pode ser marcada como sede. A sede terá destaque visual.</p>
            </td>
        </tr>
    </table>
    <?php
}

function chomneq_save_igreja_meta($post_id) {
    if (!isset($_POST['igreja_meta_nonce']) || !wp_verify_nonce($_POST['igreja_meta_nonce'], 'chomneq_save_igreja_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['igreja_pastor'])) {
        update_post_meta($post_id, '_igreja_pastor', sanitize_text_field($_POST['igreja_pastor']));
    }
    
    if (isset($_POST['igreja_endereco'])) {
        update_post_meta($post_id, '_igreja_endereco', sanitize_textarea_field($_POST['igreja_endereco']));
    }
    
    if (isset($_POST['igreja_instagram'])) {
        update_post_meta($post_id, '_igreja_instagram', esc_url_raw($_POST['igreja_instagram']));
    }
    
    if (isset($_POST['igreja_ordem'])) {
        update_post_meta($post_id, '_igreja_ordem', intval($_POST['igreja_ordem']));
    }
    
    // Processar checkbox de sede
    $is_sede = isset($_POST['igreja_sede']) ? '1' : '0';
    
    if ($is_sede === '1') {
        // Remover flag de sede de todas as outras igrejas
        $outras_igrejas = get_posts(array(
            'post_type' => 'igreja_regional',
            'posts_per_page' => -1,
            'post__not_in' => array($post_id),
            'meta_query' => array(
                array(
                    'key' => '_igreja_sede',
                    'value' => '1',
                    'compare' => '='
                )
            )
        ));
        
        foreach ($outras_igrejas as $igreja) {
            update_post_meta($igreja->ID, '_igreja_sede', '0');
        }
    }
    
    update_post_meta($post_id, '_igreja_sede', $is_sede);
}
add_action('save_post_igreja_regional', 'chomneq_save_igreja_meta');

/**
 * Meta Boxes para Atividade
 */
function chomneq_atividade_meta_boxes() {
    add_meta_box(
        'atividade_info',
        'Informações da Atividade',
        'chomneq_atividade_info_callback',
        'atividade',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'chomneq_atividade_meta_boxes');

function chomneq_atividade_info_callback($post) {
    wp_nonce_field('chomneq_save_atividade_meta', 'atividade_meta_nonce');
    
    $data_inicio = get_post_meta($post->ID, '_atividade_data_inicio', true);
    $data_fim = get_post_meta($post->ID, '_atividade_data_fim', true);
    $local = get_post_meta($post->ID, '_atividade_local', true);
    $link = get_post_meta($post->ID, '_atividade_link', true);
    $cta_texto = get_post_meta($post->ID, '_atividade_cta_texto', true);
    $cor = get_post_meta($post->ID, '_atividade_cor', true) ?: '#667eea';
    $ativa = get_post_meta($post->ID, '_atividade_ativa', true);
    $regional_id = get_post_meta($post->ID, '_atividade_regional', true);
    
    // Buscar todas as regionais disponíveis
    $regionais = get_posts(array(
        'post_type' => 'igreja_regional',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    ?>
    <table class="form-table">
        <tr>
            <th><label for="atividade_regional">Regional:</label></th>
            <td>
                <select id="atividade_regional" name="atividade_regional" class="regular-text">
                    <option value="">Selecione uma regional</option>
                    <?php foreach ($regionais as $regional) : ?>
                        <option value="<?php echo esc_attr($regional->ID); ?>" 
                                <?php selected($regional_id, $regional->ID); ?>>
                            <?php echo esc_html($regional->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="description">Selecione a qual regional esta atividade pertence</p>
            </td>
        </tr>
        <tr>
            <th><label for="atividade_data_inicio">Data de Início:</label></th>
            <td>
                <input type="date" id="atividade_data_inicio" name="atividade_data_inicio" 
                       value="<?php echo esc_attr($data_inicio); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="atividade_data_fim">Data de Término:</label></th>
            <td>
                <input type="date" id="atividade_data_fim" name="atividade_data_fim" 
                       value="<?php echo esc_attr($data_fim); ?>" class="regular-text">
                <p class="description">Deixe em branco se for um evento de um único dia</p>
            </td>
        </tr>
        <tr>
            <th><label for="atividade_local">Local:</label></th>
            <td>
                <input type="text" id="atividade_local" name="atividade_local" 
                       value="<?php echo esc_attr($local); ?>" class="regular-text" 
                       placeholder="Ex: Sede Regional, Online, etc.">
            </td>
        </tr>
        <tr>
            <th><label for="atividade_link">Link (opcional):</label></th>
            <td>
                <input type="url" id="atividade_link" name="atividade_link" 
                       value="<?php echo esc_attr($link); ?>" class="regular-text" 
                       placeholder="https://...">
                <p class="description">Link para inscrição, mais informações, etc.</p>
            </td>
        </tr>
        <tr>
            <th><label for="atividade_cta_texto">Texto do Botão:</label></th>
            <td>
                <input type="text" id="atividade_cta_texto" name="atividade_cta_texto" 
                       value="<?php echo esc_attr($cta_texto); ?>" class="regular-text" 
                       placeholder="Saiba Mais">
                <p class="description">Deixe em branco para usar "Saiba Mais" como padrão</p>
            </td>
        </tr>
        <tr>
            <th><label for="atividade_cor">Cor do Card:</label></th>
            <td>
                <input type="color" id="atividade_cor" name="atividade_cor" 
                       value="<?php echo esc_attr($cor); ?>">
                <p class="description">Escolha a cor do gradiente do card</p>
            </td>
        </tr>
        <tr>
            <th><label for="atividade_ativa">Exibir no Site:</label></th>
            <td>
                <label>
                    <input type="checkbox" id="atividade_ativa" name="atividade_ativa" value="1" 
                           <?php checked($ativa, '1'); ?>>
                    Atividade ativa (marque para exibir no site)
                </label>
                <p class="description">Somente atividades ativas e com data futura serão exibidas</p>
            </td>
        </tr>
    </table>
    <?php
}

function chomneq_save_atividade_meta($post_id) {
    if (!isset($_POST['atividade_meta_nonce']) || !wp_verify_nonce($_POST['atividade_meta_nonce'], 'chomneq_save_atividade_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Verificar se está tentando publicar sem imagem destacada
    $post = get_post($post_id);
    if ($post->post_status === 'publish' && !has_post_thumbnail($post_id)) {
        // Impedir a publicação e voltar para rascunho
        remove_action('save_post_atividade', 'chomneq_save_atividade_meta');
        wp_update_post(array(
            'ID' => $post_id,
            'post_status' => 'draft'
        ));
        add_action('save_post_atividade', 'chomneq_save_atividade_meta');
        
        // Adicionar mensagem de erro para o admin
        set_transient('atividade_thumbnail_error_' . $post_id, 'Adicione uma imagem destacada antes de publicar.', 45);
        
        // Redirecionar para evitar loop
        add_filter('redirect_post_location', function($location) {
            return add_query_arg('message', 10, $location);
        });
    }
    
    // Salvar campo ativa (checkbox)
    $ativa = isset($_POST['atividade_ativa']) ? '1' : '0';
    update_post_meta($post_id, '_atividade_ativa', $ativa);
    
    // Salvar campo regional
    if (isset($_POST['atividade_regional'])) {
        $regional_id = intval($_POST['atividade_regional']);
        if ($regional_id > 0) {
            update_post_meta($post_id, '_atividade_regional', $regional_id);
        } else {
            delete_post_meta($post_id, '_atividade_regional');
        }
    }
    
    $fields = array(
        'atividade_data_inicio' => '_atividade_data_inicio',
        'atividade_data_fim' => '_atividade_data_fim',
        'atividade_local' => '_atividade_local',
        'atividade_link' => '_atividade_link',
        'atividade_cta_texto' => '_atividade_cta_texto',
        'atividade_cor' => '_atividade_cor',
    );
    
    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            if ($field === 'atividade_link') {
                update_post_meta($post_id, $meta_key, esc_url_raw($_POST[$field]));
            } else {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post_atividade', 'chomneq_save_atividade_meta');

/**
 * Adicionar coluna de Regional na lista de Atividades
 */
function chomneq_atividade_admin_columns($columns) {
    $new_columns = array();
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['regional'] = 'Regional';
        }
    }
    return $new_columns;
}
add_filter('manage_atividade_posts_columns', 'chomneq_atividade_admin_columns');

/**
 * Exibir conteúdo da coluna Regional
 */
function chomneq_atividade_admin_column_content($column, $post_id) {
    if ($column === 'regional') {
        $regional_id = get_post_meta($post_id, '_atividade_regional', true);
        if ($regional_id) {
            $regional = get_post($regional_id);
            if ($regional) {
                echo '<a href="' . get_edit_post_link($regional_id) . '">' . esc_html($regional->post_title) . '</a>';
            } else {
                echo '<span style="color: #999;">Regional não encontrada</span>';
            }
        } else {
            echo '<span style="color: #999;">Não atribuída</span>';
        }
    }
}
add_action('manage_atividade_posts_custom_column', 'chomneq_atividade_admin_column_content', 10, 2);

/**
 * Tornar coluna Regional ordenável
 */
function chomneq_atividade_sortable_columns($columns) {
    $columns['regional'] = 'regional';
    return $columns;
}
add_filter('manage_edit-atividade_sortable_columns', 'chomneq_atividade_sortable_columns');

/**
 * Adicionar filtro por Regional na lista de Atividades
 */
function chomneq_atividade_admin_filters() {
    global $typenow;
    
    if ($typenow === 'atividade') {
        $regionais = get_posts(array(
            'post_type' => 'igreja_regional',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        ));
        
        $current_regional = isset($_GET['atividade_regional']) ? intval($_GET['atividade_regional']) : 0;
        
        echo '<select name="atividade_regional">';
        echo '<option value="">Todas as Regionais</option>';
        foreach ($regionais as $regional) {
            printf(
                '<option value="%s"%s>%s</option>',
                esc_attr($regional->ID),
                selected($current_regional, $regional->ID, false),
                esc_html($regional->post_title)
            );
        }
        echo '</select>';
    }
}
add_action('restrict_manage_posts', 'chomneq_atividade_admin_filters');

/**
 * Filtrar atividades por Regional
 */
function chomneq_atividade_filter_by_regional($query) {
    global $pagenow, $typenow;
    
    if ($pagenow === 'edit.php' && $typenow === 'atividade' && isset($_GET['atividade_regional']) && $_GET['atividade_regional'] != '') {
        $regional_id = intval($_GET['atividade_regional']);
        $meta_query = array(
            array(
                'key' => '_atividade_regional',
                'value' => $regional_id,
                'compare' => '='
            )
        );
        $query->set('meta_query', $meta_query);
    }
}
add_filter('parse_query', 'chomneq_atividade_filter_by_regional');

/**
 * Exibir mensagem de erro se imagem destacada não foi definida
 */
function chomneq_atividade_thumbnail_error() {
    global $post;
    
    if ($post && $post->post_type === 'atividade') {
        $error = get_transient('atividade_thumbnail_error_' . $post->ID);
        if ($error) {
            echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($error) . '</p></div>';
            delete_transient('atividade_thumbnail_error_' . $post->ID);
        }
    }
}
add_action('admin_notices', 'chomneq_atividade_thumbnail_error');

/**
 * Registrar Taxonomia para Biblioteca de Mídia - Pastas de Expositores
 */
function chomneq_register_media_folder_taxonomy() {
    $labels = array(
        'name' => 'Pastas de Expositores',
        'singular_name' => 'Pasta',
        'search_items' => 'Buscar Pastas',
        'all_items' => 'Todas as Pastas',
        'edit_item' => 'Editar Pasta',
        'update_item' => 'Atualizar Pasta',
        'add_new_item' => 'Adicionar Nova Pasta',
        'new_item_name' => 'Nome da Nova Pasta',
        'menu_name' => 'Pastas',
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'pasta-expositor'),
    );

    register_taxonomy('pasta_expositor', array('attachment'), $args);
}
add_action('init', 'chomneq_register_media_folder_taxonomy');

/**
 * Adicionar filtro de pastas na biblioteca de mídia
 */
function chomneq_add_media_folder_filter() {
    $screen = get_current_screen();
    if ($screen && $screen->id === 'upload') {
        $taxonomy = 'pasta_expositor';
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ));
        
        if ($terms && !is_wp_error($terms)) {
            $current = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            ?>
            <select name="<?php echo esc_attr($taxonomy); ?>" class="postform">
                <option value="">Todas as Pastas</option>
                <?php foreach ($terms as $term) : ?>
                    <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($current, $term->slug); ?>>
                        <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php
        }
    }
}
add_action('restrict_manage_posts', 'chomneq_add_media_folder_filter');

/**
 * Adicionar campo de pasta no modal de upload
 */
function chomneq_add_folder_to_media_modal($form_fields, $post) {
    $terms = wp_get_post_terms($post->ID, 'pasta_expositor');
    $current_term = !empty($terms) && !is_wp_error($terms) ? $terms[0]->term_id : 0;
    
    $all_terms = get_terms(array(
        'taxonomy' => 'pasta_expositor',
        'hide_empty' => false,
    ));
    
    $options = '<option value="0">Selecione uma pasta</option>';
    if ($all_terms && !is_wp_error($all_terms)) {
        foreach ($all_terms as $term) {
            $selected = ($current_term == $term->term_id) ? 'selected' : '';
            $options .= '<option value="' . $term->term_id . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
        }
    }
    
    $form_fields['pasta_expositor'] = array(
        'label' => 'Pasta do Expositor',
        'input' => 'html',
        'html' => '<select name="attachments[' . $post->ID . '][pasta_expositor]" id="attachments-' . $post->ID . '-pasta_expositor">' . $options . '</select>
                   <p class="description">Organize esta mídia em uma pasta de expositor</p>',
    );
    
    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'chomneq_add_folder_to_media_modal', 10, 2);

/**
 * Salvar pasta ao editar mídia
 */
function chomneq_save_media_folder($post, $attachment) {
    if (isset($attachment['pasta_expositor'])) {
        $term_id = intval($attachment['pasta_expositor']);
        if ($term_id > 0) {
            wp_set_post_terms($post['ID'], array($term_id), 'pasta_expositor', false);
        } else {
            wp_set_post_terms($post['ID'], array(), 'pasta_expositor', false);
        }
    }
    return $post;
}
add_filter('attachment_fields_to_save', 'chomneq_save_media_folder', 10, 2);

/**
 * Filtrar biblioteca de mídia no seletor por pasta
 */
function chomneq_filter_media_library_by_folder($query) {
    if (!is_admin()) {
        return $query;
    }
    
    $screen = get_current_screen();
    if ($screen && $screen->id === 'upload') {
        if (isset($_GET['pasta_expositor']) && !empty($_GET['pasta_expositor'])) {
            $query['tax_query'] = array(
                array(
                    'taxonomy' => 'pasta_expositor',
                    'field' => 'slug',
                    'terms' => $_GET['pasta_expositor'],
                )
            );
        }
    }
    
    return $query;
}
add_filter('ajax_query_attachments_args', 'chomneq_filter_media_library_by_folder');

/**
 * Adicionar menu para gerenciar pastas
 */
function chomneq_add_media_folders_menu() {
    add_submenu_page(
        'upload.php',
        'Pastas de Expositores',
        'Pastas',
        'manage_options',
        'edit-tags.php?taxonomy=pasta_expositor&post_type=attachment'
    );
}
add_action('admin_menu', 'chomneq_add_media_folders_menu');

/**
 * Adicionar meta Boxes para Expositores
 */
function chomneq_add_expositor_meta_boxes() {
    add_meta_box(
        'expositor_info',
        'Informações do Expositor',
        'chomneq_expositor_info_callback',
        'expositor',
        'normal',
        'high'
    );
    
    add_meta_box(
        'expositor_gallery',
        'Galeria de Fotos',
        'chomneq_expositor_gallery_callback',
        'expositor',
        'normal',
        'default'
    );
    
    add_meta_box(
        'expositor_qrcode',
        'QR Code da Página',
        'chomneq_expositor_qrcode_callback',
        'expositor',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'chomneq_add_expositor_meta_boxes');

/**
 * Meta Box Callback - Informações do Expositor
 */
function chomneq_expositor_info_callback($post) {
    wp_nonce_field('chomneq_save_expositor_info', 'chomneq_expositor_nonce');
    
    $telefone = get_post_meta($post->ID, '_expositor_telefone', true);
    $whatsapp = get_post_meta($post->ID, '_expositor_whatsapp', true);
    $email = get_post_meta($post->ID, '_expositor_email', true);
    $website = get_post_meta($post->ID, '_expositor_website', true);
    $instagram = get_post_meta($post->ID, '_expositor_instagram', true);
    $facebook = get_post_meta($post->ID, '_expositor_facebook', true);
    $localizacao = get_post_meta($post->ID, '_expositor_localizacao', true);
    $pix = get_post_meta($post->ID, '_expositor_pix', true);
    $pix_qrcode = get_post_meta($post->ID, '_expositor_pix_qrcode', true);
    $banco = get_post_meta($post->ID, '_expositor_banco', true);
    $agencia = get_post_meta($post->ID, '_expositor_agencia', true);
    $conta = get_post_meta($post->ID, '_expositor_conta', true);
    $metodos_pagamento = get_post_meta($post->ID, '_expositor_metodos_pagamento', true);
    $servico_gratuito = get_post_meta($post->ID, '_expositor_servico_gratuito', true);
    
    // Obter regionais
    $regionais = get_terms(array(
        'taxonomy' => 'regional_expositor',
        'hide_empty' => false,
    ));
    $regional_atual = wp_get_post_terms($post->ID, 'regional_expositor', array('fields' => 'ids'));
    $regional_id = !empty($regional_atual) ? $regional_atual[0] : '';
    ?>
    <style>
        .expositor-field { margin-bottom: 15px; }
        .expositor-field label { display: block; font-weight: bold; margin-bottom: 5px; }
        .expositor-field input, .expositor-field textarea, .expositor-field select { width: 100%; padding: 8px; }
        .expositor-field textarea { height: 80px; }
        .field-group { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .qrcode-preview { margin-top: 10px; max-width: 200px; }
        .qrcode-preview img { width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px; }
        .upload-qrcode-btn { margin-top: 5px; }
        .remove-qrcode-btn { margin-top: 5px; color: #a00; cursor: pointer; text-decoration: underline; }
        .campos-pagamento-admin { margin-top: 15px; padding: 15px; background: #f9f9f9; border-radius: 4px; }
        .servico-gratuito-field { background: #e7f3ff; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .servico-gratuito-field input[type="checkbox"] { margin-right: 8px; width: auto; }
        .section-title { margin-top: 25px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #0073aa; color: #0073aa; }
        .add-regional-link { display: inline-block; margin-top: 5px; color: #0073aa; text-decoration: none; }
        .add-regional-link:hover { text-decoration: underline; }
    </style>
    
    <h3 class="section-title">📍 Informações Gerais</h3>
    
    <div class="expositor-field">
        <label for="expositor_regional">Regional (Comunidade de Origem):</label>
        <select id="expositor_regional" name="expositor_regional">
            <option value="">Selecione uma regional</option>
            <?php foreach ($regionais as $regional) : ?>
                <option value="<?php echo esc_attr($regional->term_id); ?>" <?php selected($regional_id, $regional->term_id); ?>>
                    <?php echo esc_html($regional->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">
            Selecione a regional/igreja à qual você pertence. 
            <a href="<?php echo admin_url('edit-tags.php?taxonomy=regional_expositor&post_type=expositor'); ?>" class="add-regional-link" target="_blank">+ Adicionar nova regional</a>
        </p>
    </div>
    
    <div class="expositor-field">
        <label for="expositor_localizacao">Endereço de Atendimento:</label>
        <input type="text" id="expositor_localizacao" name="expositor_localizacao" value="<?php echo esc_attr($localizacao); ?>" placeholder="Ex: Rua ABC, 123 - Bairro, Cidade ou 'Atendimento em diversos locais'">
        <p class="description">Endereço da sua loja/empresa ou indique se atende em múltiplos locais</p>
    </div>
    
    <h3 class="section-title">📞 Contatos</h3>
    
    <div class="expositor-field">
        <label for="expositor_telefone">Telefone:</label>
        <input type="text" id="expositor_telefone" name="expositor_telefone" value="<?php echo esc_attr($telefone); ?>" placeholder="(00) 0000-0000">
    </div>
    
    <div class="expositor-field">
        <label for="expositor_whatsapp">WhatsApp:</label>
        <input type="text" id="expositor_whatsapp" name="expositor_whatsapp" value="<?php echo esc_attr($whatsapp); ?>" placeholder="(00) 00000-0000">
    </div>
    
    <div class="expositor-field">
        <label for="expositor_email">E-mail:</label>
        <input type="email" id="expositor_email" name="expositor_email" value="<?php echo esc_attr($email); ?>" placeholder="contato@exemplo.com">
    </div>
    
    <div class="expositor-field">
        <label for="expositor_website">Website:</label>
        <input type="url" id="expositor_website" name="expositor_website" value="<?php echo esc_attr($website); ?>" placeholder="https://exemplo.com">
    </div>
    
    <h3 class="section-title">📱 Redes Sociais</h3>
    
    <div class="field-group">
        <div class="expositor-field">
            <label for="expositor_instagram">Instagram:</label>
            <input type="text" id="expositor_instagram" name="expositor_instagram" value="<?php echo esc_attr($instagram); ?>" placeholder="@usuario">
        </div>
        
        <div class="expositor-field">
            <label for="expositor_facebook">Facebook:</label>
            <input type="text" id="expositor_facebook" name="expositor_facebook" value="<?php echo esc_attr($facebook); ?>" placeholder="facebook.com/usuario">
        </div>
    </div>
    
    <h3 class="section-title">💰 Informações de Pagamento</h3>
    
    <div class="expositor-field servico-gratuito-field">
        <label>
            <input type="checkbox" id="expositor_servico_gratuito" name="expositor_servico_gratuito" value="1" <?php checked($servico_gratuito, '1'); ?>>
            Este produto/serviço é gratuito (não cobra dos clientes)
        </label>
    </div>
    
    <div id="campos-pagamento-admin" class="campos-pagamento-admin" style="<?php echo ($servico_gratuito === '1') ? 'display:none;' : ''; ?>">
    
    <div class="expositor-field">
        <label for="expositor_metodos_pagamento">Métodos de Pagamento Aceitos:</label>
        <input type="text" id="expositor_metodos_pagamento" name="expositor_metodos_pagamento" value="<?php echo esc_attr($metodos_pagamento); ?>" placeholder="Ex: Dinheiro, PIX, Cartão de Crédito, Débito (separe por vírgula)">
    </div>
    
    <div class="expositor-field">
        <label for="expositor_pix">Chave PIX:</label>
        <input type="text" id="expositor_pix" name="expositor_pix" value="<?php echo esc_attr($pix); ?>" placeholder="CPF, E-mail, Telefone ou Chave Aleatória">
    </div>
    
    <div class="expositor-field">
        <label for="expositor_pix_qrcode">QR Code PIX:</label>
        <input type="hidden" id="expositor_pix_qrcode" name="expositor_pix_qrcode" value="<?php echo esc_attr($pix_qrcode); ?>">
        <button type="button" class="button upload-qrcode-btn">Enviar QR Code</button>
        <?php if ($pix_qrcode): ?>
            <div class="qrcode-preview">
                <img src="<?php echo esc_url(wp_get_attachment_url($pix_qrcode)); ?>" alt="QR Code PIX">
                <div><span class="remove-qrcode-btn">Remover QR Code</span></div>
            </div>
        <?php else: ?>
            <div class="qrcode-preview" style="display:none;">
                <img src="" alt="QR Code PIX">
                <div><span class="remove-qrcode-btn">Remover QR Code</span></div>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="field-group">
        <div class="expositor-field">
            <label for="expositor_banco">Banco:</label>
            <input type="text" id="expositor_banco" name="expositor_banco" value="<?php echo esc_attr($banco); ?>" placeholder="Nome do Banco">
        </div>
        
        <div class="expositor-field">
            <label for="expositor_agencia">Agência:</label>
            <input type="text" id="expositor_agencia" name="expositor_agencia" value="<?php echo esc_attr($agencia); ?>" placeholder="0000">
        </div>
    </div>
    
    <div class="expositor-field">
        <label for="expositor_conta">Conta:</label>
        <input type="text" id="expositor_conta" name="expositor_conta" value="<?php echo esc_attr($conta); ?>" placeholder="00000-0">
    </div>
    
    </div><!-- #campos-pagamento-admin -->
    <?php
}

/**
 * Meta Box Callback - Galeria
 */
function chomneq_expositor_gallery_callback($post) {
    $gallery = get_post_meta($post->ID, 'expositor_gallery', true);
    $gallery_ids = !empty($gallery) ? explode(',', $gallery) : array();
    ?>
    <style>
        .gallery-preview { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 10px; 
            margin-top: 15px; 
        }
        .gallery-preview-item { 
            position: relative; 
            width: 100px; 
            height: 100px; 
            border: 2px solid #ddd; 
            border-radius: 4px; 
            overflow: hidden;
        }
        .gallery-preview-item img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }
        .gallery-preview-item .remove-image { 
            position: absolute; 
            top: 5px; 
            right: 5px; 
            background: #e74c3c; 
            color: white; 
            border: none; 
            border-radius: 50%; 
            width: 25px; 
            height: 25px; 
            cursor: pointer; 
            font-size: 16px; 
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .gallery-preview-item .remove-image:hover { 
            background: #c0392b; 
        }
        .add-gallery-images { 
            background: #0073aa; 
            color: white; 
            border: none; 
            padding: 10px 20px; 
            cursor: pointer; 
            border-radius: 4px; 
            font-size: 14px;
        }
        .add-gallery-images:hover { 
            background: #005a87; 
        }
    </style>
    
    <div class="expositor-field">
        <label>Galeria de Fotos dos Produtos:</label>
        <p class="description">Clique no botão abaixo para selecionar ou fazer upload de imagens para a galeria.</p>
        
        <button type="button" class="add-gallery-images">
            📷 Adicionar/Gerenciar Imagens
        </button>
        
        <input type="hidden" id="expositor_gallery" name="expositor_gallery" value="<?php echo esc_attr($gallery); ?>">
        
        <div class="gallery-preview">
            <?php foreach ($gallery_ids as $img_id) : 
                $img_id = trim($img_id);
                if (empty($img_id)) continue;
                $img_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                if ($img_url) :
            ?>
                <div class="gallery-preview-item" data-id="<?php echo esc_attr($img_id); ?>">
                    <img src="<?php echo esc_url($img_url); ?>" alt="Imagem da galeria">
                    <button type="button" class="remove-image" data-id="<?php echo esc_attr($img_id); ?>">×</button>
                </div>
            <?php 
                endif;
            endforeach; ?>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var galleryFrame;
        var galleryIds = [];
        
        // Função para inicializar quando o campo estiver pronto
        function initGallery() {
            var $field = $('input[name="expositor_gallery"]').last();
            
            if ($field.length === 0) {
                return false;
            }
            
            var initialValue = $field.attr('value') || $field.val();
            
            if (initialValue) {
                galleryIds = initialValue.split(',').map(function(id) { 
                    return id.trim(); 
                }).filter(function(id) { 
                    return id !== '' && id !== '0'; 
                });
            }
            
            return true;
        }
        
        // Tentar inicializar várias vezes até conseguir
        var attempts = 0;
        var initInterval = setInterval(function() {
            attempts++;
            if (initGallery() || attempts > 50) {
                clearInterval(initInterval);
                if (attempts > 50) {
                    console.error('[INIT] Falha ao inicializar após 50 tentativas');
                }
            }
        }, 100);
        
        // Abrir seletor de mídia
        $('.add-gallery-images').on('click', function(e) {
            e.preventDefault();
            
            // Sempre criar novo frame para garantir seleção atualizada
            galleryFrame = wp.media({
                title: 'Selecionar Imagens para Galeria',
                button: {
                    text: 'Adicionar à Galeria'
                },
                multiple: true,
                library: {
                    type: 'image'
                }
            });
            
            // Pré-selecionar imagens já adicionadas
            galleryFrame.on('open', function() {
                var selection = galleryFrame.state().get('selection');
                
                galleryIds.forEach(function(id) {
                    if (id && id !== '0') {
                        var attachment = wp.media.attachment(id);
                        attachment.fetch();
                        selection.add(attachment ? [attachment] : []);
                    }
                });
            });
            
            // Quando imagens forem selecionadas
            galleryFrame.on('select', function() {
                var attachments = galleryFrame.state().get('selection').toJSON();
                
                galleryIds = [];
                $('.gallery-preview').empty();
                
                attachments.forEach(function(attachment) {
                    galleryIds.push(attachment.id.toString());
                    var thumbUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                    addImageToPreview(attachment.id, thumbUrl);
                });
                
                var idsString = galleryIds.join(',');
                var $field = $('input[name="expositor_gallery"]');
                $field.val(idsString);
                $field.attr('value', idsString);
                $field.prop('value', idsString);
            });
            
            galleryFrame.open();
        });
        
        // Função para adicionar imagem à preview
        function addImageToPreview(id, url) {
            var html = '<div class="gallery-preview-item" data-id="' + id + '">' +
                      '<img src="' + url + '" alt="Imagem da galeria">' +
                      '<button type="button" class="remove-image" data-id="' + id + '">×</button>' +
                      '</div>';
            $('.gallery-preview').append(html);
        }
        
        // Remover imagem individual
        $(document).on('click', '.remove-image', function(e) {
            e.preventDefault();
            var imageId = $(this).data('id').toString();
            
            $(this).closest('.gallery-preview-item').fadeOut(300, function() {
                $(this).remove();
                
                // Atualizar array de IDs
                galleryIds = galleryIds.filter(function(id) {
                    return id.toString() !== imageId;
                });
                
                var idsString = galleryIds.join(',');
                var $field = $('input[name="expositor_gallery"]');
                $field.val(idsString);
                $field.attr('value', idsString);
                $field.prop('value', idsString);
            });
        });
        
        // Upload QR Code PIX
        $(document).on('click', '.upload-qrcode-btn', function(e) {
            e.preventDefault();
            
            var frame = wp.media({
                title: 'Selecionar QR Code PIX',
                button: {
                    text: 'Usar esta imagem'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });
            
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                $('#expositor_pix_qrcode').val(attachment.id);
                $('.qrcode-preview img').attr('src', attachment.url);
                $('.qrcode-preview').show();
            });
            
            frame.open();
        });
        
        // Remover QR Code
        $(document).on('click', '.remove-qrcode-btn', function(e) {
            e.preventDefault();
            $('#expositor_pix_qrcode').val('');
            $('.qrcode-preview').hide();
            $('.qrcode-preview img').attr('src', '');
        });
        
        // Toggle campos de pagamento baseado no checkbox de serviço gratuito
        $('#expositor_servico_gratuito').on('change', function() {
            if ($(this).is(':checked')) {
                $('#campos-pagamento-admin').slideUp();
            } else {
                $('#campos-pagamento-admin').slideDown();
            }
        });
    });
    </script>
    <?php
}

/**
 * Meta Box Callback - QR Code
 */
function chomneq_expositor_qrcode_callback($post) {
    $post_status = get_post_status($post->ID);
    $permalink = get_permalink($post->ID);
    ?>
    <style>
        .qrcode-admin-container {
            text-align: center;
            padding: 1rem;
        }
        .btn-gerar-qrcode-admin {
            background: #9C27B0;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-bottom: 1rem;
        }
        .btn-gerar-qrcode-admin:hover {
            background: #7B1FA2;
        }
        .qrcode-info {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.5rem;
        }
    </style>
    
    <?php if ($post_status === 'publish'): ?>
        <div class="qrcode-admin-container">
            <button type="button" class="btn-gerar-qrcode-admin" onclick="gerarQRCodeAdmin('<?php echo esc_js($permalink); ?>', '<?php echo esc_js($post->post_title); ?>')">
                📱 Gerar QR Code
            </button>
            <p class="qrcode-info">Gere um QR Code para a página pública deste expositor</p>
        </div>
        
        <!-- Modal QR Code Admin -->
        <div id="modal-qrcode-admin" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 100000; align-items: center; justify-content: center; overflow-y: auto; padding: 1rem;">
            <div style="background: white; padding: 2rem; border-radius: 8px; max-width: 650px; width: 90%; text-align: center; margin: auto;">
                <h3 style="margin: 0 0 1.5rem 0;">📱 QR Code da Página</h3>
                
                <div id="qrcode-container-admin" style="display: flex; justify-content: center; margin: 2rem 0;">
                    <div id="qrcode-admin" style="padding: 1.5rem; background: white; border: 3px solid #333; border-radius: 12px; display: inline-block;"></div>
                </div>
                
                <p style="color: #666; margin-bottom: 0.5rem; font-size: 0.9rem;">
                    <strong id="qrcode-title-admin"></strong>
                </p>
                <p style="color: #666; margin-bottom: 1.5rem; font-size: 0.85rem;">
                    Resolução: 512x512px (ideal para impressão em A4)
                </p>
                
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="baixarQRCodeAdmin()" style="padding: 0.75rem 1.5rem; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        ⬇️ Baixar QR Code
                    </button>
                    <button type="button" onclick="imprimirQRCodeAdmin()" style="padding: 0.75rem 1.5rem; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        🖨️ Imprimir
                    </button>
                    <button type="button" onclick="fecharModalQRCodeAdmin()" style="padding: 0.75rem 1.5rem; border: 2px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script>
        var qrcodeObjAdmin = null;
        var currentPostTitle = '';
        
        function gerarQRCodeAdmin(url, title) {
            currentPostTitle = title;
            document.getElementById('qrcode-admin').innerHTML = '';
            document.getElementById('qrcode-title-admin').textContent = title;
            
            qrcodeObjAdmin = new QRCode(document.getElementById('qrcode-admin'), {
                text: url,
                width: 512,
                height: 512,
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
            
            document.getElementById('modal-qrcode-admin').style.display = 'flex';
        }
        
        function fecharModalQRCodeAdmin() {
            document.getElementById('modal-qrcode-admin').style.display = 'none';
        }
        
        function baixarQRCodeAdmin() {
            var canvas = document.querySelector('#qrcode-admin canvas');
            if (canvas) {
                var link = document.createElement('a');
                link.download = 'qrcode-' + currentPostTitle.toLowerCase().replace(/[^a-z0-9]+/g, '-') + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            }
        }
        
        function imprimirQRCodeAdmin() {
            var canvas = document.querySelector('#qrcode-admin canvas');
            if (!canvas) return;
            
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>QR Code - ' + currentPostTitle + '</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('body { margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }');
            printWindow.document.write('@media print { @page { size: A4; margin: 2cm; } body { margin: 0; } img { max-width: 100%; height: auto; } }');
            printWindow.document.write('</style></head><body>');
            printWindow.document.write('<img src="' + canvas.toDataURL() + '" />');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            
            setTimeout(function() {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            }, 250);
        }
        
        // Fechar modal ao clicar fora
        document.addEventListener('click', function(e) {
            var modal = document.getElementById('modal-qrcode-admin');
            if (e.target === modal) {
                fecharModalQRCodeAdmin();
            }
        });
        </script>
    <?php else: ?>
        <div class="qrcode-admin-container">
            <p class="qrcode-info" style="color: #d63638;">
                ⚠️ Publique o expositor para gerar o QR Code
            </p>
        </div>
    <?php endif; ?>
    <?php
}

/**
 * Salvar Meta Boxes
 */
function chomneq_save_expositor_meta($post_id) {
    // Verificar nonce
    if (!isset($_POST['chomneq_expositor_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['chomneq_expositor_nonce'], 'chomneq_save_expositor_info')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Salvar regional (taxonomia)
    if (isset($_POST['expositor_regional'])) {
        $regional_id = intval($_POST['expositor_regional']);
        if ($regional_id > 0) {
            wp_set_post_terms($post_id, array($regional_id), 'regional_expositor');
        } else {
            wp_set_post_terms($post_id, array(), 'regional_expositor');
        }
    }

    $fields = array(
        'expositor_localizacao',
        'expositor_telefone',
        'expositor_whatsapp',
        'expositor_email',
        'expositor_website',
        'expositor_instagram',
        'expositor_facebook',
        'expositor_pix',
        'expositor_pix_qrcode',
        'expositor_banco',
        'expositor_agencia',
        'expositor_conta',
        'expositor_metodos_pagamento',
        'expositor_gallery',
    );
    
    // Salvar checkbox de serviço gratuito
    $servico_gratuito = isset($_POST['expositor_servico_gratuito']) ? '1' : '0';
    update_post_meta($post_id, '_expositor_servico_gratuito', $servico_gratuito);

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);
            $meta_key = ($field === 'expositor_gallery') ? $field : '_' . $field;
            update_post_meta($post_id, $meta_key, $value);
        }
    }
}
add_action('save_post_expositor', 'chomneq_save_expositor_meta');

/**
 * Enviar notificação por email quando um novo expositor for criado
 */
function chomneq_notify_new_expositor($post_id, $post, $update) {
    // Log para debug
    error_log("chomneq_notify_new_expositor chamado - Post ID: {$post_id}, Update: " . ($update ? 'sim' : 'não') . ", Status: {$post->post_status}, Type: {$post->post_type}");
    
    // Verificar se é um expositor
    if ($post->post_type !== 'expositor') {
        error_log("Não é expositor, abortando");
        return;
    }
    
    // Não enviar notificação para updates, apenas novos posts
    if ($update) {
        error_log("É update, não enviando email");
        return;
    }
    
    // Verificar se é um expositor pendente
    if ($post->post_status !== 'pending') {
        error_log("Status não é pending (é {$post->post_status}), não enviando email");
        return;
    }
    
    // Verificar se não é autosave ou revisão
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        error_log("É autosave ou revisão, abortando");
        return;
    }
    
    error_log("Todas as validações passaram, preparando email");
    
    // Obter informações do expositor
    $expositor_nome = get_the_title($post_id);
    $expositor_email = get_post_meta($post_id, '_expositor_email', true);
    $expositor_telefone = get_post_meta($post_id, '_expositor_telefone', true);
    $expositor_localizacao = get_post_meta($post_id, '_expositor_localizacao', true);
    
    // Obter categorias
    $categorias = get_the_terms($post_id, 'categoria_expositor');
    $categorias_texto = '';
    if ($categorias && !is_wp_error($categorias)) {
        $categorias_nomes = array_map(function($cat) {
            return $cat->name;
        }, $categorias);
        $categorias_texto = implode(', ', $categorias_nomes);
    }
    
    // Obter regionais
    $regionais = get_the_terms($post_id, 'regional_expositor');
    $regionais_texto = '';
    if ($regionais && !is_wp_error($regionais)) {
        $regionais_nomes = array_map(function($reg) {
            return $reg->name;
        }, $regionais);
        $regionais_texto = implode(', ', $regionais_nomes);
    }
    
    // Email do administrador (pegar do WordPress)
    $admin_email = get_option('admin_email');
    error_log("Email do admin: {$admin_email}");
    
    // Montar o assunto
    $assunto = '[CHOMNEQ] Novo Expositor Aguardando Aprovação - ' . $expositor_nome;
    
    // Montar o corpo do email
    $mensagem = "Um novo expositor foi cadastrado e está aguardando aprovação:\n\n";
    $mensagem .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    $mensagem .= "INFORMAÇÕES DO EXPOSITOR:\n\n";
    $mensagem .= "Nome: " . $expositor_nome . "\n";
    
    if (!empty($expositor_email)) {
        $mensagem .= "Email: " . $expositor_email . "\n";
    }
    
    if (!empty($expositor_telefone)) {
        $mensagem .= "Telefone: " . $expositor_telefone . "\n";
    }
    
    if (!empty($expositor_localizacao)) {
        $mensagem .= "Localização: " . $expositor_localizacao . "\n";
    }
    
    if (!empty($categorias_texto)) {
        $mensagem .= "Categoria(s): " . $categorias_texto . "\n";
    }
    
    if (!empty($regionais_texto)) {
        $mensagem .= "Regional(is): " . $regionais_texto . "\n";
    }
    
    $mensagem .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    $mensagem .= "Para revisar e aprovar este expositor, acesse:\n";
    $mensagem .= admin_url('post.php?post=' . $post_id . '&action=edit') . "\n\n";
    $mensagem .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    $mensagem .= "Esta é uma notificação automática do sistema CHOMNEQ.\n";
    
    // Headers do email
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: CHOMNEQ <' . $admin_email . '>'
    );
    
    // Enviar email
    $email_enviado = wp_mail($admin_email, $assunto, $mensagem, $headers);
    
    if ($email_enviado) {
        error_log("Email enviado com sucesso para {$admin_email}");
    } else {
        error_log("ERRO: Falha ao enviar email para {$admin_email}");
    }
}
add_action('wp_insert_post', 'chomneq_notify_new_expositor', 10, 3);

/**
 * Enqueue Scripts e Styles
 */
function chomneq_enqueue_scripts() {
    // Adicionar versão baseada no timestamp do arquivo para cache busting
    $theme_version = wp_get_theme()->get('Version') ?: filemtime(get_template_directory() . '/style.css');
    wp_enqueue_style('chomneq-style', get_stylesheet_uri(), array(), $theme_version);
}
add_action('wp_enqueue_scripts', 'chomneq_enqueue_scripts');

/**
 * Enqueue scripts para o admin (necessário para o media uploader)
 */
function chomneq_admin_enqueue_scripts($hook) {
    global $post_type;
    
    if ($post_type == 'expositor' && ($hook == 'post.php' || $hook == 'post-new.php')) {
        wp_enqueue_media();
    }
    
    // Adicionar script de pastas na biblioteca de mídia
    if ($hook == 'upload.php' || $post_type == 'expositor') {
        wp_enqueue_script(
            'chomneq-media-folders',
            get_template_directory_uri() . '/js/media-folders.js',
            array('jquery', 'media-views'),
            '1.0.0',
            true
        );
        
        wp_localize_script('chomneq-media-folders', 'chomneqMedia', array(
            'nonce' => wp_create_nonce('chomneq_media_folders')
        ));
    }
}
add_action('admin_enqueue_scripts', 'chomneq_admin_enqueue_scripts');

/**
 * Registrar meta field para REST API (compatibilidade com Gutenberg)
 */
function chomneq_register_gallery_meta() {
    register_post_meta('expositor', 'expositor_gallery', array(
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => '__return_true',
        'default' => '',
    ));
}
add_action('init', 'chomneq_register_gallery_meta', 99);

/**
 * Função auxiliar para obter categorias do expositor
 */
function chomneq_get_expositor_categorias($post_id) {
    $terms = get_the_terms($post_id, 'categoria_expositor');
    if ($terms && !is_wp_error($terms)) {
        return $terms;
    }
    return array();
}

/**
 * Função auxiliar para contar expositores
 */
function chomneq_count_expositores() {
    $count = wp_count_posts('expositor');
    return $count->publish;
}

/**
 * Função auxiliar para contar categorias
 */
function chomneq_count_categorias() {
    $terms = get_terms(array(
        'taxonomy' => 'categoria_expositor',
        'hide_empty' => false,
    ));
    return is_array($terms) ? count($terms) : 0;
}

/**
 * AJAX: Obter lista de pastas de mídia
 */
function chomneq_ajax_get_media_folders() {
    $folders = get_terms(array(
        'taxonomy' => 'pasta_expositor',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC'
    ));
    
    if (is_wp_error($folders)) {
        wp_send_json_error('Erro ao carregar pastas');
    }
    
    wp_send_json_success($folders);
}
add_action('wp_ajax_get_media_folders', 'chomneq_ajax_get_media_folders');

/**
 * AJAX: Criar nova pasta de mídia
 */
function chomneq_ajax_create_media_folder() {
    check_ajax_referer('chomneq_media_folders', 'nonce');
    
    if (!current_user_can('upload_files')) {
        wp_send_json_error('Sem permissão');
    }
    
    $folder_name = sanitize_text_field($_POST['name']);
    
    if (empty($folder_name)) {
        wp_send_json_error('Nome da pasta é obrigatório');
    }
    
    $result = wp_insert_term($folder_name, 'pasta_expositor');
    
    if (is_wp_error($result)) {
        wp_send_json_error($result->get_error_message());
    }
    
    wp_send_json_success(array(
        'term_id' => $result['term_id'],
        'message' => 'Pasta criada com sucesso'
    ));
}
add_action('wp_ajax_create_media_folder', 'chomneq_ajax_create_media_folder');

/**
 * Criar role personalizada de Expositor
 */
function chomneq_create_expositor_role() {
    if (!get_role('expositor')) {
        add_role(
            'expositor',
            'Expositor',
            array(
                'read' => true,
                'edit_posts' => true,
                'delete_posts' => false,
                'upload_files' => true,
            )
        );
    }
}
add_action('init', 'chomneq_create_expositor_role');

/**
 * Criar página de cadastro automaticamente
 */
function chomneq_create_cadastro_page() {
    // Verificar se a página já existe
    $page_check = get_page_by_path('cadastro-expositor');
    
    if (!$page_check) {
        $page_data = array(
            'post_title' => 'Cadastro de Expositor',
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_name' => 'cadastro-expositor',
            'page_template' => 'page-cadastro-expositor.php'
        );
        
        $page_id = wp_insert_post($page_data);
        
        if ($page_id) {
            update_post_meta($page_id, '_wp_page_template', 'page-cadastro-expositor.php');
        }
    }
}
add_action('after_switch_theme', 'chomneq_create_cadastro_page');

/**
 * AJAX: Salvar expositor do frontend
 */
function chomneq_ajax_salvar_expositor_frontend() {
    // Log para debug
    error_log('AJAX chamado - salvar_expositor_frontend');
    error_log('POST data: ' . print_r($_POST, true));
    
    // Verificar nonce
    if (!isset($_POST['expositor_nonce']) || !wp_verify_nonce($_POST['expositor_nonce'], 'salvar_expositor_frontend')) {
        error_log('Erro: Nonce inválido');
        wp_send_json_error('Erro de segurança');
    }
    
    // Verificar se usuário está logado
    if (!is_user_logged_in()) {
        error_log('Erro: Usuário não logado');
        wp_send_json_error('Você precisa estar logado');
    }
    
    $current_user = wp_get_current_user();
    
    // Verificar se é expositor ou admin
    if (!in_array('expositor', $current_user->roles) && !current_user_can('administrator')) {
        wp_send_json_error('Você não tem permissão para realizar esta ação');
    }
    
    $expositor_id = intval($_POST['expositor_id']);
    $is_edit = $expositor_id > 0;
    
    // Validar campos obrigatórios
    if (empty($_POST['titulo'])) {
        wp_send_json_error('O nome do negócio é obrigatório');
    }
    
    if (empty($_POST['descricao'])) {
        wp_send_json_error('A descrição é obrigatória');
    }
    
    if (empty($_POST['categoria'])) {
        wp_send_json_error('A categoria é obrigatória');
    }
    
    if (empty($_POST['whatsapp'])) {
        wp_send_json_error('O WhatsApp é obrigatório');
    }
    
    // Se está editando, verificar se o post pertence ao usuário
    if ($is_edit) {
        $post_author = get_post_field('post_author', $expositor_id);
        if ($post_author != $current_user->ID && !current_user_can('administrator')) {
            wp_send_json_error('Você não pode editar este cadastro');
        }
    }
    
    // Determinar status do post
    $post_status = 'pending'; // Default para novos posts
    
    if ($is_edit) {
        // Se está editando, verificar o status atual
        $current_status = get_post_field('post_status', $expositor_id);
        
        // Se já foi aprovado (publish), manter como publish
        // Se ainda está pending, manter como pending
        $post_status = ($current_status === 'publish') ? 'publish' : 'pending';
    }
    
    // Preparar dados do post
    $post_data = array(
        'post_title' => sanitize_text_field($_POST['titulo']),
        'post_content' => wp_kses_post($_POST['descricao']),
        'post_type' => 'expositor',
        'post_status' => $post_status,
        'post_author' => $current_user->ID,
    );
    
    if ($is_edit) {
        $post_data['ID'] = $expositor_id;
        $result = wp_update_post($post_data);
    } else {
        $result = wp_insert_post($post_data);
    }
    
    if (is_wp_error($result)) {
        wp_send_json_error('Erro ao salvar: ' . $result->get_error_message());
    }
    
    $expositor_id = $is_edit ? $expositor_id : $result;
    
    // Salvar categoria
    if (!empty($_POST['categoria'])) {
        wp_set_post_terms($expositor_id, array(intval($_POST['categoria'])), 'categoria_expositor');
    }
    
    // Salvar regional
    if (!empty($_POST['regional']) && $_POST['regional'] !== '') {
        if ($_POST['regional'] === 'nova' && !empty($_POST['nova_regional'])) {
            // Criar nova regional
            $nova_regional = sanitize_text_field($_POST['nova_regional']);
            $term = wp_insert_term($nova_regional, 'regional_expositor');
            
            if (!is_wp_error($term)) {
                wp_set_post_terms($expositor_id, array($term['term_id']), 'regional_expositor');
            }
        } else {
            $regional_id = intval($_POST['regional']);
            if ($regional_id > 0) {
                wp_set_post_terms($expositor_id, array($regional_id), 'regional_expositor');
            }
        }
    }
    
    // Salvar meta fields
    $meta_fields = array(
        '_expositor_localizacao' => 'localizacao',
        '_expositor_telefone' => 'telefone',
        '_expositor_whatsapp' => 'whatsapp',
        '_expositor_email' => 'email',
        '_expositor_website' => 'website',
        '_expositor_instagram' => 'instagram',
        '_expositor_facebook' => 'facebook',
        '_expositor_pix' => 'pix',
        '_expositor_banco' => 'banco',
        '_expositor_agencia' => 'agencia',
        '_expositor_conta' => 'conta',
        '_expositor_metodos_pagamento' => 'metodos_pagamento',
    );
    
    foreach ($meta_fields as $meta_key => $post_key) {
        if (isset($_POST[$post_key])) {
            update_post_meta($expositor_id, $meta_key, sanitize_text_field($_POST[$post_key]));
        }
    }
    
    // Salvar checkbox de serviço gratuito
    $servico_gratuito = isset($_POST['servico_gratuito']) ? '1' : '0';
    update_post_meta($expositor_id, '_expositor_servico_gratuito', $servico_gratuito);
    
    // Upload de imagem destacada
    if (!empty($_FILES['imagem_destaque']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $attachment_id = media_handle_upload('imagem_destaque', $expositor_id);
        if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($expositor_id, $attachment_id);
        }
    }
    
    // Upload de QR Code PIX
    if (!empty($_FILES['pix_qrcode']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $attachment_id = media_handle_upload('pix_qrcode', $expositor_id);
        if (!is_wp_error($attachment_id)) {
            update_post_meta($expositor_id, '_expositor_pix_qrcode', $attachment_id);
        }
    }
    
    // Upload de galeria de imagens
    if (!empty($_FILES['galeria_imagens']['name'][0])) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        
        $gallery_ids = array();
        
        // Manter IDs existentes
        $existing_gallery = get_post_meta($expositor_id, 'expositor_gallery', true);
        if (!empty($existing_gallery)) {
            $gallery_ids = explode(',', $existing_gallery);
        }
        
        $files = $_FILES['galeria_imagens'];
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                );
                
                $_FILES = array('upload' => $file);
                $attachment_id = media_handle_upload('upload', $expositor_id);
                
                if (!is_wp_error($attachment_id)) {
                    $gallery_ids[] = $attachment_id;
                }
            }
        }
        
        if (!empty($gallery_ids)) {
            update_post_meta($expositor_id, 'expositor_gallery', implode(',', $gallery_ids));
        }
    }
    
    $message = $is_edit 
        ? 'Cadastro atualizado com sucesso! Aguarde a aprovação da equipe.' 
        : 'Cadastro enviado com sucesso! Aguarde a aprovação da equipe.';
    
    wp_send_json_success(array(
        'message' => $message,
        'expositor_id' => $expositor_id
    ));
}
add_action('wp_ajax_salvar_expositor_frontend', 'chomneq_ajax_salvar_expositor_frontend');
add_action('wp_ajax_nopriv_salvar_expositor_frontend', 'chomneq_ajax_salvar_expositor_frontend');

/**
 * Restringir acesso de expositores apenas aos próprios posts
 */
function chomneq_restrict_expositor_posts($query) {
    if (is_admin() && $query->is_main_query() && !current_user_can('administrator')) {
        $current_user = wp_get_current_user();
        if (in_array('expositor', $current_user->roles)) {
            global $pagenow;
            if ($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'expositor') {
                $query->set('author', $current_user->ID);
            }
        }
    }
}
add_action('pre_get_posts', 'chomneq_restrict_expositor_posts');

/**
 * Remover menu items para expositores no admin
 */
function chomneq_remove_admin_menus_for_expositor() {
    $current_user = wp_get_current_user();
    if (in_array('expositor', $current_user->roles)) {
        // Remover menus desnecessários
        remove_menu_page('index.php'); // Dashboard
        remove_menu_page('edit.php'); // Posts
        remove_menu_page('edit.php?post_type=expositor'); // Expositores
        remove_menu_page('upload.php'); // Mídia
        remove_menu_page('edit.php?post_type=elementor_library'); // Modelos (Elementor)
        remove_menu_page('edit-comments.php'); // Comentários
        remove_menu_page('tools.php'); // Ferramentas
        remove_menu_page('plugins.php'); // Plugins
        remove_menu_page('themes.php'); // Temas
        remove_menu_page('users.php'); // Usuários
        remove_menu_page('options-general.php'); // Configurações
        
        // Remover submenu "Recolher menu" se existir
        remove_submenu_page('index.php', 'recolher-menu');
    }
}
add_action('admin_menu', 'chomneq_remove_admin_menus_for_expositor', 999);

/**
 * Remover itens da barra de admin do WordPress para expositores
 */
function chomneq_remove_admin_bar_items_for_expositor($wp_admin_bar) {
    $user = wp_get_current_user();
    
    if (in_array('expositor', $user->roles)) {
        // Remover itens do menu esquerdo
        $wp_admin_bar->remove_node('wp-logo'); // Logo WordPress
        $wp_admin_bar->remove_node('site-name'); // Nome do site
        $wp_admin_bar->remove_node('updates'); // Atualizações
        $wp_admin_bar->remove_node('comments'); // Comentários
        $wp_admin_bar->remove_node('new-content'); // + Novo
        $wp_admin_bar->remove_node('new-post'); // Novo post
        $wp_admin_bar->remove_node('new-media'); // Nova mídia
        $wp_admin_bar->remove_node('new-page'); // Nova página
        $wp_admin_bar->remove_node('new-user'); // Novo usuário
        $wp_admin_bar->remove_node('new-expositor'); // Novo expositor
        
        // Remover busca
        $wp_admin_bar->remove_node('search');
        
        // Manter apenas o menu do usuário (direita)
        // Isso permite acesso ao perfil
    }
}
add_action('admin_bar_menu', 'chomneq_remove_admin_bar_items_for_expositor', 999);

/**
 * Adicionar botão de gerar QR Codes em massa na listagem de expositores
 */
function chomneq_add_bulk_qrcode_button() {
    global $current_screen;
    
    if ($current_screen->post_type == 'expositor' && $current_screen->id == 'edit-expositor') {
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.wrap h1.wp-heading-inline').after('<a href="#" id="gerar-qrcodes-massa" class="page-title-action" style="background: #F6F7F7; border-color: #104B78;">📱 Gerar QR Codes em Massa</a>');
            
            $('#gerar-qrcodes-massa').on('click', function(e) {
                e.preventDefault();
                
                if (confirm('Deseja gerar QR Codes de todos os expositores publicados? Isso pode levar alguns instantes.')) {
                    var $btn = $(this);
                    $btn.text('⏳ Gerando...').css('opacity', '0.6');
                    
                    $.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'gerar_qrcodes_massa'
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(blob, status, xhr) {
                            var filename = 'qrcodes-expositores.zip';
                            var disposition = xhr.getResponseHeader('Content-Disposition');
                            if (disposition && disposition.indexOf('filename=') !== -1) {
                                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches != null && matches[1]) { 
                                    filename = matches[1].replace(/['"]/g, '');
                                }
                            }
                            
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);
                            a.remove();
                            
                            $btn.text('✓ Download Concluído!').css('background', '#4CAF50');
                            setTimeout(function() {
                                $btn.text('📱 Gerar QR Codes em Massa').css({'background': '#9C27B0', 'opacity': '1'});
                            }, 3000);
                        },
                        error: function() {
                            alert('Erro ao gerar QR Codes. Tente novamente.');
                            $btn.text('📱 Gerar QR Codes em Massa').css('opacity', '1');
                        }
                    });
                }
            });
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'chomneq_add_bulk_qrcode_button');

/**
 * AJAX: Gerar QR Codes em massa
 */
function chomneq_ajax_gerar_qrcodes_massa() {
    if (!current_user_can('edit_posts')) {
        wp_die('Sem permissão');
    }
    
    // Buscar todos os expositores publicados
    $expositores = get_posts(array(
        'post_type' => 'expositor',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    
    if (empty($expositores)) {
        wp_die('Nenhum expositor publicado encontrado');
    }
    
    // Criar diretório temporário
    $upload_dir = wp_upload_dir();
    $temp_dir = $upload_dir['basedir'] . '/qrcodes-temp-' . time();
    wp_mkdir_p($temp_dir);
    
    // Gerar QR Code para cada expositor
    foreach ($expositores as $expositor) {
        $permalink = get_permalink($expositor->ID);
        $titulo = sanitize_file_name($expositor->post_title);
        
        // Gerar QR Code com título usando biblioteca PHP
        $qr_image_path = chomneq_generate_qrcode_with_title($permalink, $titulo, $temp_dir);
    }
    
    // Criar arquivo ZIP
    $zip_filename = 'qrcodes-expositores-' . date('Y-m-d-His') . '.zip';
    $zip_path = $upload_dir['basedir'] . '/' . $zip_filename;
    
    $zip = new ZipArchive();
    if ($zip->open($zip_path, ZipArchive::CREATE) !== TRUE) {
        wp_die('Erro ao criar arquivo ZIP');
    }
    
    // Adicionar todos os arquivos PNG ao ZIP
    $files = glob($temp_dir . '/*.png');
    foreach ($files as $file) {
        $zip->addFile($file, basename($file));
    }
    
    $zip->close();
    
    // Limpar diretório temporário
    array_map('unlink', $files);
    rmdir($temp_dir);
    
    // Enviar arquivo ZIP para download
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zip_filename . '"');
    header('Content-Length: ' . filesize($zip_path));
    readfile($zip_path);
    
    // Remover arquivo ZIP
    unlink($zip_path);
    
    exit;
}
add_action('wp_ajax_gerar_qrcodes_massa', 'chomneq_ajax_gerar_qrcodes_massa');

/**
 * Gerar QR Code com título usando GD Library
 */
function chomneq_generate_qrcode_with_title($url, $titulo, $output_dir) {
    // Usar API externa para gerar QR Code (mais confiável que biblioteca PHP)
    $qr_size = 512;
    $qr_api_url = 'https://api.qrserver.com/v1/create-qr-code/?size=' . $qr_size . 'x' . $qr_size . '&data=' . urlencode($url) . '&format=png&ecc=H';
    
    // Baixar imagem do QR Code
    $qr_image_data = @file_get_contents($qr_api_url);
    if (!$qr_image_data) {
        return false;
    }
    
    $qr_image = imagecreatefromstring($qr_image_data);
    if (!$qr_image) {
        return false;
    }
    
    // Criar imagem final com espaço para o título
    $margin = 40;
    $title_height = 80;
    $final_width = $qr_size + ($margin * 2);
    $final_height = $qr_size + ($margin * 2) + $title_height;
    
    $final_image = imagecreatetruecolor($final_width, $final_height);
    $white = imagecolorallocate($final_image, 255, 255, 255);
    $black = imagecolorallocate($final_image, 0, 0, 0);
    
    // Preencher fundo branco
    imagefill($final_image, 0, 0, $white);
    
    // Copiar QR Code para o centro
    imagecopy($final_image, $qr_image, $margin, $margin, 0, 0, $qr_size, $qr_size);
    
    // Adicionar título abaixo do QR Code
    $font_size = 20;
    $font_file = null;
    
    // Tentar usar fonte do sistema
    $possible_fonts = array(
        '/System/Library/Fonts/Supplemental/Arial.ttf', // macOS
        '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf', // Linux
        'C:/Windows/Fonts/arial.ttf' // Windows
    );
    
    foreach ($possible_fonts as $font) {
        if (file_exists($font)) {
            $font_file = $font;
            break;
        }
    }
    
    if ($font_file) {
        // Calcular posição centralizada do texto
        $bbox = imagettfbbox($font_size, 0, $font_file, $titulo);
        $text_width = abs($bbox[4] - $bbox[0]);
        $x = ($final_width - $text_width) / 2;
        $y = $qr_size + ($margin * 2) + 45;
        
        imagettftext($final_image, $font_size, 0, $x, $y, $black, $font_file, $titulo);
    } else {
        // Fallback: usar fonte padrão do GD (menor qualidade)
        $x = ($final_width - (strlen($titulo) * 9)) / 2;
        $y = $qr_size + ($margin * 2) + 30;
        imagestring($final_image, 5, $x, $y, $titulo, $black);
    }
    
    // Salvar imagem
    $filename = $output_dir . '/' . $titulo . '.png';
    imagepng($final_image, $filename);
    
    // Liberar memória
    imagedestroy($qr_image);
    imagedestroy($final_image);
    
    return $filename;
}

/**
 * Redirecionar expositores para página de cadastro após login
 */
function chomneq_redirect_expositor_after_login($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('expositor', $user->roles)) {
            // Redirecionar para a página de cadastro
            $cadastro_page = get_page_by_path('cadastro-expositor');
            if ($cadastro_page) {
                return get_permalink($cadastro_page->ID);
            }
            return home_url('/cadastro-expositor');
        }
    }
    return $redirect_to;
}
add_filter('login_redirect', 'chomneq_redirect_expositor_after_login', 999, 3);

/**
 * Bloquear acesso ao wp-admin para expositores
 */
function chomneq_block_expositor_admin_access() {
    if (is_admin() && !wp_doing_ajax()) {
        $user = wp_get_current_user();
        if (in_array('expositor', $user->roles)) {
            $cadastro_page = get_page_by_path('cadastro-expositor');
            if ($cadastro_page) {
                wp_redirect(get_permalink($cadastro_page->ID));
            } else {
                wp_redirect(home_url('/cadastro-expositor'));
            }
            exit;
        }
    }
}
add_action('admin_init', 'chomneq_block_expositor_admin_access');

/**
 * AJAX: Criar nova categoria de expositor
 */
function chomneq_ajax_criar_categoria_expositor() {
    check_ajax_referer('criar_categoria', 'nonce');
    
    if (!is_user_logged_in()) {
        wp_send_json_error('Você precisa estar logado');
    }
    
    $current_user = wp_get_current_user();
    if (!in_array('expositor', $current_user->roles) && !current_user_can('administrator')) {
        wp_send_json_error('Você não tem permissão para criar categorias');
    }
    
    $nome = sanitize_text_field($_POST['nome']);
    $pai = intval($_POST['pai']);
    
    if (empty($nome)) {
        wp_send_json_error('Nome da categoria é obrigatório');
    }
    
    $args = array(
        'parent' => $pai
    );
    
    $term = wp_insert_term($nome, 'categoria_expositor', $args);
    
    if (is_wp_error($term)) {
        wp_send_json_error($term->get_error_message());
    }
    
    $term_obj = get_term($term['term_id'], 'categoria_expositor');
    
    wp_send_json_success(array(
        'term_id' => $term_obj->term_id,
        'name' => $term_obj->name,
        'parent' => $term_obj->parent
    ));
}
add_action('wp_ajax_criar_categoria_expositor', 'chomneq_ajax_criar_categoria_expositor');

/**
 * AJAX: Curtir/Descurtir Expositor
 */
function chomneq_ajax_like_expositor() {
    $expositor_id = intval($_POST['expositor_id']);
    
    if (!$expositor_id) {
        wp_send_json_error('ID inválido');
    }
    
    // Verificar se o post existe
    $post = get_post($expositor_id);
    if (!$post || $post->post_type !== 'expositor') {
        wp_send_json_error('Expositor não encontrado');
    }
    
    // Obter contagem atual de likes
    $likes_count = get_post_meta($expositor_id, '_expositor_likes', true);
    $likes_count = $likes_count ? intval($likes_count) : 0;
    
    // Verificar se usuário está logado
    $user_id = get_current_user_id();
    $has_liked = false;
    
    if ($user_id) {
        // Usuário logado: verificar via user meta
        $liked_expositores = get_user_meta($user_id, '_liked_expositores', true);
        $liked_expositores = $liked_expositores ? $liked_expositores : array();
        $has_liked = in_array($expositor_id, $liked_expositores);
        
        if ($has_liked) {
            // Descurtir
            $likes_count = max(0, $likes_count - 1);
            update_post_meta($expositor_id, '_expositor_likes', $likes_count);
            
            // Remover do array de curtidas do usuário
            $liked_expositores = array_diff($liked_expositores, array($expositor_id));
            update_user_meta($user_id, '_liked_expositores', array_values($liked_expositores));
            
            wp_send_json_success(array(
                'liked' => false,
                'likes_count' => $likes_count,
                'message' => 'Curtida removida'
            ));
        } else {
            // Curtir
            $likes_count++;
            update_post_meta($expositor_id, '_expositor_likes', $likes_count);
            
            // Adicionar ao array de curtidas do usuário
            $liked_expositores[] = $expositor_id;
            update_user_meta($user_id, '_liked_expositores', $liked_expositores);
            
            wp_send_json_success(array(
                'liked' => true,
                'likes_count' => $likes_count,
                'message' => 'Obrigado por curtir!'
            ));
        }
    } else {
        // Usuário não logado: verificar via cookie
        $cookie_name = 'expositor_liked_' . $expositor_id;
        $has_liked = isset($_COOKIE[$cookie_name]);
        
        if ($has_liked) {
            // Descurtir
            $likes_count = max(0, $likes_count - 1);
            update_post_meta($expositor_id, '_expositor_likes', $likes_count);
            
            // Remover cookie (setando para expirar no passado)
            setcookie($cookie_name, '', time() - 3600, '/');
            
            wp_send_json_success(array(
                'liked' => false,
                'likes_count' => $likes_count,
                'message' => 'Curtida removida'
            ));
        } else {
            // Curtir
            $likes_count++;
            update_post_meta($expositor_id, '_expositor_likes', $likes_count);
            
            // Definir cookie por 1 ano
            setcookie($cookie_name, '1', time() + (365 * 24 * 60 * 60), '/');
            
            wp_send_json_success(array(
                'liked' => true,
                'likes_count' => $likes_count,
                'message' => 'Obrigado por curtir!'
            ));
        }
    }
}
add_action('wp_ajax_like_expositor', 'chomneq_ajax_like_expositor');
add_action('wp_ajax_nopriv_like_expositor', 'chomneq_ajax_like_expositor'); // Permitir usuários não logados

/**
 * Adicionar JavaScript para o sistema de curtidas
 */
function chomneq_enqueue_like_scripts() {
    // Garantir que jQuery está carregado
    wp_enqueue_script('jquery');
    
    // Adicionar script inline de curtidas
    wp_add_inline_script('jquery', "
    jQuery(document).ready(function($) {
        console.log('Sistema de curtidas carregado');
        
        $(document).on('click', '.btn-like', function(e) {
            e.preventDefault();
            
            var button = $(this);
            var expositorId = button.data('expositor-id');
            var heartIcon = button.find('.heart-icon');
            var likesCount = button.find('.likes-count');
            
            console.log('Clicou no coração do expositor:', expositorId);
            
            // Desabilitar botão durante a requisição
            button.prop('disabled', true);
            
            $.ajax({
                url: '" . admin_url('admin-ajax.php') . "',
                type: 'POST',
                data: {
                    action: 'like_expositor',
                    expositor_id: expositorId
                },
                success: function(response) {
                    console.log('Resposta do servidor:', response);
                    
                    if (response.success) {
                        // Atualizar contagem
                        likesCount.text(response.data.likes_count);
                        
                        // Atualizar ícone e classe
                        if (response.data.liked) {
                            heartIcon.text('❤️');
                            button.addClass('liked').data('liked', '1');
                        } else {
                            heartIcon.text('🤍');
                            button.removeClass('liked').data('liked', '0');
                        }
                    } else {
                        alert('Erro: ' + response.data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro AJAX:', error);
                    alert('Erro ao processar curtida. Tente novamente.');
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });
    });
    ");
}
add_action('wp_enqueue_scripts', 'chomneq_enqueue_like_scripts');

/**
 * Habilitar comentários para o CPT expositor
 */
function chomneq_enable_expositor_comments() {
    add_post_type_support('expositor', 'comments');
}
add_action('init', 'chomneq_enable_expositor_comments');

/**
 * Permitir comentários de usuários não logados
 */
function chomneq_allow_anonymous_comments($open, $post_id) {
    $post = get_post($post_id);
    if ($post && $post->post_type === 'expositor') {
        return true;
    }
    return $open;
}
add_filter('comments_open', 'chomneq_allow_anonymous_comments', 10, 2);

/**
 * AJAX: Adicionar comentário
 */
function chomneq_ajax_add_comment() {
    // Proteção contra flood: verificar rate limiting via transient
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient_key = 'comment_flood_' . md5($ip);
    
    if (get_transient($transient_key)) {
        wp_send_json_error('Aguarde alguns segundos antes de comentar novamente.');
    }
    
    // Validar dados
    $post_id = intval($_POST['post_id']);
    $author_name = sanitize_text_field($_POST['author_name']);
    $author_email = sanitize_email($_POST['author_email']);
    $comment_content = sanitize_textarea_field($_POST['comment_content']);
    $comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
    $parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
    
    // Validações
    if (empty($author_name) || strlen($author_name) < 2) {
        wp_send_json_error('Nome deve ter pelo menos 2 caracteres.');
    }
    
    if (empty($author_email) || !is_email($author_email)) {
        wp_send_json_error('E-mail inválido.');
    }
    
    if (empty($comment_content) || strlen($comment_content) < 6) {
        wp_send_json_error('Comentário deve ter pelo menos 6 caracteres.');
    }
    
    if (strlen($comment_content) > 1000) {
        wp_send_json_error('Comentário muito longo (máximo 1000 caracteres).');
    }
    
    // Remover links do comentário (proteção anti-spam)
    $comment_content = preg_replace('/(https?:\/\/[^\s]+)/i', '[link removido]', $comment_content);
    $comment_content = preg_replace('/www\.[^\s]+/i', '[link removido]', $comment_content);
    
    // Edição de comentário existente
    if ($comment_id > 0) {
        $existing_comment = get_comment($comment_id);
        
        if (!$existing_comment) {
            wp_send_json_error('Comentário não encontrado.');
        }
        
        // Verificar se o usuário pode editar (via cookie de identificação)
        $cookie_name = 'comment_author_' . $comment_id;
        $stored_hash = isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : '';
        $expected_hash = md5($existing_comment->comment_author_email . $existing_comment->comment_author_IP);
        
        if ($stored_hash !== $expected_hash) {
            wp_send_json_error('Você não tem permissão para editar este comentário.');
        }
        
        // Atualizar comentário
        $update = wp_update_comment(array(
            'comment_ID' => $comment_id,
            'comment_content' => $comment_content,
            'comment_author' => $author_name,
            'comment_author_email' => $author_email,
        ));
        
        if ($update) {
            wp_send_json_success(array(
                'message' => 'Comentário atualizado com sucesso!',
                'comment_id' => $comment_id,
                'is_edit' => true
            ));
        } else {
            wp_send_json_error('Erro ao atualizar comentário.');
        }
    } else {
        // Novo comentário
        $commentdata = array(
            'comment_post_ID' => $post_id,
            'comment_author' => $author_name,
            'comment_author_email' => $author_email,
            'comment_author_url' => '',
            'comment_content' => $comment_content,
            'comment_type' => 'comment',
            'comment_parent' => $parent_id,
            'user_id' => get_current_user_id(),
            'comment_author_IP' => $ip,
            'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
            'comment_approved' => 1,
        );
        
        $new_comment_id = wp_insert_comment($commentdata);
        
        if ($new_comment_id) {
            // Definir cookie para permitir edição posterior (válido por 30 dias)
            $cookie_hash = md5($author_email . $ip);
            setcookie('comment_author_' . $new_comment_id, $cookie_hash, time() + (30 * 24 * 60 * 60), '/');
            
            // Rate limiting: bloquear novos comentários por 10 segundos
            set_transient($transient_key, true, 10);
            
            // Buscar o comentário criado
            $comment = get_comment($new_comment_id);
            
            wp_send_json_success(array(
                'message' => 'Comentário adicionado com sucesso!',
                'comment_id' => $new_comment_id,
                'comment' => array(
                    'id' => $new_comment_id,
                    'author' => $comment->comment_author,
                    'content' => $comment->comment_content,
                    'date' => get_comment_date('d/m/Y H:i', $new_comment_id),
                    'can_edit' => true
                )
            ));
        } else {
            wp_send_json_error('Erro ao adicionar comentário.');
        }
    }
}
add_action('wp_ajax_add_expositor_comment', 'chomneq_ajax_add_comment');
add_action('wp_ajax_nopriv_add_expositor_comment', 'chomneq_ajax_add_comment');

/**
 * AJAX: Deletar comentário
 */
function chomneq_ajax_delete_comment() {
    $comment_id = intval($_POST['comment_id']);
    $comment = get_comment($comment_id);
    
    if (!$comment) {
        wp_send_json_error('Comentário não encontrado.');
    }
    
    // Verificar permissão via cookie
    $cookie_name = 'comment_author_' . $comment_id;
    $stored_hash = isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : '';
    $expected_hash = md5($comment->comment_author_email . $comment->comment_author_IP);
    
    if ($stored_hash !== $expected_hash && !current_user_can('moderate_comments')) {
        wp_send_json_error('Você não tem permissão para deletar este comentário.');
    }
    
    if (wp_delete_comment($comment_id, true)) {
        // Remover cookie
        setcookie($cookie_name, '', time() - 3600, '/');
        wp_send_json_success('Comentário deletado com sucesso!');
    } else {
        wp_send_json_error('Erro ao deletar comentário.');
    }
}
add_action('wp_ajax_delete_expositor_comment', 'chomneq_ajax_delete_comment');
add_action('wp_ajax_nopriv_delete_expositor_comment', 'chomneq_ajax_delete_comment');

/**
 * Função para exibir comentário com respostas aninhadas
 */
function chomneq_display_comment($comment, $depth = 0) {
    $comment_id = $comment->comment_ID;
    $can_edit = false;
    
    // Verificar se usuário pode editar via cookie
    $cookie_name = 'comment_author_' . $comment_id;
    if (isset($_COOKIE[$cookie_name])) {
        $stored_hash = $_COOKIE[$cookie_name];
        $expected_hash = md5($comment->comment_author_email . $comment->comment_author_IP);
        $can_edit = ($stored_hash === $expected_hash);
    }
    
    // Admin sempre pode editar/deletar
    if (current_user_can('moderate_comments')) {
        $can_edit = true;
    }
    
    $margin_left = $depth > 0 ? '1px' : '0';
    $is_reply = $depth > 0;
    $border_left = $depth > 0 ? 'border-left: 3px solid #9C27B0;' : '';
    ?>
    <div class="comment-item <?php echo $is_reply ? 'comment-reply' : ''; ?>" 
         id="comment-<?php echo $comment_id; ?>" 
         style="background: <?php echo $is_reply ? '#f8f9fa' : 'white'; ?>; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem; margin-top: 12px; margin-bottom: 0.75rem; margin-left: <?php echo $margin_left; ?>; <?php echo $border_left; ?>">
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
            <div>
                <strong style="font-size: 1.05rem; color: var(--primary-color);">
                    <?php echo esc_html($comment->comment_author); ?>
                    <?php if ($is_reply) : ?>
                        <span style="font-size: 0.85rem; color: #666; font-weight: normal;">respondeu</span>
                    <?php endif; ?>
                </strong>
                <br>
                <small style="color: #666;">
                    <?php echo get_comment_date('d/m/Y H:i', $comment_id); ?>
                </small>
            </div>
            
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <button class="btn-reply-comment" data-comment-id="<?php echo $comment_id; ?>"
                        data-author="<?php echo esc_attr($comment->comment_author); ?>"
                        style="background: #9C27B0; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">
                    💬 Responder
                </button>
                
                <?php if ($can_edit) : ?>
                    <button class="btn-edit-comment" data-comment-id="<?php echo $comment_id; ?>"
                            data-author="<?php echo esc_attr($comment->comment_author); ?>"
                            data-email="<?php echo esc_attr($comment->comment_author_email); ?>"
                            data-content="<?php echo esc_attr($comment->comment_content); ?>"
                            style="background: #3498db; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">
                        ✏️ Editar
                    </button>
                    <button class="btn-delete-comment" data-comment-id="<?php echo $comment_id; ?>"
                            style="background: #e74c3c; color: white; border: none; padding: 0.4rem 0.8rem; border-radius: 4px; cursor: pointer; font-size: 0.85rem;">
                        🗑️ Deletar
                    </button>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="comment-content" style="color: #333; line-height: 1.6;">
            <?php echo nl2br(esc_html($comment->comment_content)); ?>
        </div>
        
        <?php
        // Buscar respostas (comentários filhos)
        $replies = get_comments(array(
            'parent' => $comment_id,
            'status' => 'approve',
            'order' => 'ASC'
        ));
        
        if ($replies && $depth < 3) : // Limitar a 3 níveis de aninhamento
            foreach ($replies as $reply) {
                chomneq_display_comment($reply, $depth + 1);
            }
        endif;
        ?>
    </div>
    <?php
}

/**
 * ============================================================================
 * PÁGINA DE CONFIGURAÇÕES - EM CONSTRUÇÃO
 * ============================================================================
 */

/**
 * Adicionar página de configurações no menu admin
 */
function chomneq_add_page_settings_menu() {
    add_menu_page(
        'Configurações da Página',
        'Página em Construção',
        'manage_options',
        'chomneq-page-settings',
        'chomneq_page_settings_page',
        'dashicons-admin-generic',
        65
    );
}
add_action('admin_menu', 'chomneq_add_page_settings_menu');

/**
 * Enfileirar scripts necessários para o Media Uploader
 */
function chomneq_enqueue_page_settings_scripts($hook) {
    // Carregar apenas na página de configurações
    if ($hook !== 'toplevel_page_chomneq-page-settings') {
        return;
    }
    
    // Enfileirar media uploader
    wp_enqueue_media();
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'chomneq_enqueue_page_settings_scripts');

/**
 * Renderizar página de configurações
 */
function chomneq_page_settings_page() {
    // Verificar permissões
    if (!current_user_can('manage_options')) {
        wp_die(__('Você não tem permissão para acessar esta página.'));
    }
    
    // Salvar configurações
    if (isset($_POST['chomneq_page_settings_nonce']) && wp_verify_nonce($_POST['chomneq_page_settings_nonce'], 'chomneq_save_page_settings')) {
        
        // Salvar imagem da hero
        if (isset($_POST['hero_background_image'])) {
            update_option('chomneq_hero_background_image', intval($_POST['hero_background_image']));
        }
        
        echo '<div class="notice notice-success is-dismissible"><p>Configurações salvas com sucesso!</p></div>';
    }
    
    // Buscar valores atuais
    $hero_bg_image_id = get_option('chomneq_hero_background_image', '');
    $hero_bg_image_url = $hero_bg_image_id ? wp_get_attachment_image_url($hero_bg_image_id, 'full') : '';
    
    ?>
    <div class="wrap">
        <h1>⚙️ Configurações da Página em Construção</h1>
        <p>Gerencie o conteúdo e aparência da página em construção.</p>
        
        <form method="post" action="">
            <?php wp_nonce_field('chomneq_save_page_settings', 'chomneq_page_settings_nonce'); ?>
            
            <div style="background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h2>🖼️ Imagem de Background da Hero</h2>
                <p style="color: #666;">Escolha uma imagem para o fundo da seção hero (topo da página).</p>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label>Imagem de Background:</label>
                        </th>
                        <td>
                            <div style="margin-bottom: 15px;">
                                <input type="hidden" id="hero_background_image" name="hero_background_image" value="<?php echo esc_attr($hero_bg_image_id); ?>" />
                                
                                <div id="hero_image_preview" style="margin-bottom: 10px;">
                                    <?php if ($hero_bg_image_url) : ?>
                                        <img src="<?php echo esc_url($hero_bg_image_url); ?>" style="max-width: 500px; height: auto; border-radius: 8px; border: 2px solid #ddd;" />
                                    <?php else : ?>
                                        <div style="background: #f0f0f0; padding: 40px; text-align: center; border-radius: 8px; border: 2px dashed #ccc;">
                                            <p style="color: #999; margin: 0;">Nenhuma imagem selecionada</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <button type="button" class="button button-primary" id="upload_hero_image_button">
                                    📤 Selecionar Imagem
                                </button>
                                <?php if ($hero_bg_image_url) : ?>
                                    <button type="button" class="button" id="remove_hero_image_button">
                                        🗑️ Remover Imagem
                                    </button>
                                <?php endif; ?>
                            </div>
                            <p class="description">
                                Recomendado: imagem horizontal com pelo menos 1920x1080px para melhor qualidade.
                            </p>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary button-hero" value="💾 Salvar Configurações">
                </p>
            </div>
        </form>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#upload_hero_image_button').on('click', function(e) {
            e.preventDefault();
            
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }
            
            mediaUploader = wp.media({
                title: 'Escolher Imagem de Background',
                button: {
                    text: 'Usar esta imagem'
                },
                multiple: false,
                library: {
                    type: 'image'
                }
            });
            
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('#hero_background_image').val(attachment.id);
                $('#hero_image_preview').html('<img src="' + attachment.url + '" style="max-width: 500px; height: auto; border-radius: 8px; border: 2px solid #ddd;" />');
                
                // Mostrar botão de remover
                if ($('#remove_hero_image_button').length === 0) {
                    $('#upload_hero_image_button').after('<button type="button" class="button" id="remove_hero_image_button" style="margin-left: 10px;">🗑️ Remover Imagem</button>');
                }
            });
            
            mediaUploader.open();
        });
        
        $(document).on('click', '#remove_hero_image_button', function(e) {
            e.preventDefault();
            $('#hero_background_image').val('');
            $('#hero_image_preview').html('<div style="background: #f0f0f0; padding: 40px; text-align: center; border-radius: 8px; border: 2px dashed #ccc;"><p style="color: #999; margin: 0;">Nenhuma imagem selecionada</p></div>');
            $(this).remove();
        });
    });
    </script>
    
    <style>
        .button-hero {
            font-size: 16px !important;
            padding: 12px 24px !important;
            height: auto !important;
        }
    </style>
    <?php
}

/**
 * ============================================================================
 * SISTEMA DE ATUALIZAÇÃO VIA GITHUB
 * ============================================================================
 */

/**
 * Obter GitHub URI do style.css
 */
function chomneq_get_github_config() {
    $theme = wp_get_theme();
    $stylesheet_path = $theme->get_stylesheet_directory() . '/style.css';
    
    if (!file_exists($stylesheet_path)) {
        return array('uri' => '', 'branch' => 'master');
    }
    
    $style_content = file_get_contents($stylesheet_path);
    
    // Extrair GitHub Theme URI
    preg_match('/GitHub Theme URI:\s*(.+)/i', $style_content, $uri_matches);
    $github_uri = !empty($uri_matches[1]) ? trim($uri_matches[1]) : '';
    
    // Extrair GitHub Branch
    preg_match('/GitHub Branch:\s*(.+)/i', $style_content, $branch_matches);
    $github_branch = !empty($branch_matches[1]) ? trim($branch_matches[1]) : 'master';
    
    return array(
        'uri' => $github_uri,
        'branch' => $github_branch
    );
}

/**
 * Verificar atualizações do tema no GitHub
 */
function chomneq_check_theme_update($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }
    
    $theme = wp_get_theme();
    $theme_slug = $theme->get_stylesheet();
    $current_version = $theme->get('Version');
    
    // Obter informações do GitHub do style.css
    $github_config = chomneq_get_github_config();
    $github_uri = $github_config['uri'];
    $github_branch = $github_config['branch'];
    
    if (empty($github_uri)) {
        return $transient;
    }
    
    // Buscar última release do GitHub
    $api_url = "https://api.github.com/repos/{$github_uri}/releases/latest";
    
    $response = wp_remote_get($api_url, array(
        'timeout' => 10,
        'headers' => array(
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'WordPress/' . get_bloginfo('version') . '; ' . get_bloginfo('url')
        )
    ));
    
    if (is_wp_error($response)) {
        return $transient;
    }
    
    $release_data = json_decode(wp_remote_retrieve_body($response), true);
    
    if (empty($release_data['tag_name'])) {
        return $transient;
    }
    
    $latest_version = ltrim($release_data['tag_name'], 'v');
    
    // Comparar versões
    if (version_compare($current_version, $latest_version, '<')) {
        $package_url = "https://github.com/{$github_uri}/archive/refs/tags/{$release_data['tag_name']}.zip";
        
        $transient->response[$theme_slug] = array(
            'theme' => $theme_slug,
            'new_version' => $latest_version,
            'url' => "https://github.com/{$github_uri}",
            'package' => $package_url,
            'requires' => '6.0',
            'requires_php' => '7.4',
        );
    }
    
    return $transient;
}
add_filter('pre_set_site_transient_update_themes', 'chomneq_check_theme_update');

/**
 * Adicionar informações extras na tela de atualização
 */
function chomneq_theme_update_info($false, $action, $response) {
    if (empty($response->theme) || $action !== 'theme_information') {
        return $false;
    }
    
    $theme = wp_get_theme($response->theme);
    $github_config = chomneq_get_github_config();
    $github_uri = $github_config['uri'];
    
    if (empty($github_uri)) {
        return $false;
    }
    
    $api_url = "https://api.github.com/repos/{$github_uri}/releases/latest";
    
    $api_response = wp_remote_get($api_url, array(
        'timeout' => 10,
        'headers' => array(
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'WordPress/' . get_bloginfo('version') . '; ' . get_bloginfo('url')
        )
    ));
    
    if (is_wp_error($api_response)) {
        return $false;
    }
    
    $release_data = json_decode(wp_remote_retrieve_body($api_response), true);
    
    if (empty($release_data)) {
        return $false;
    }
    
    $info = new stdClass();
    $info->name = $theme->get('Name');
    $info->slug = $response->theme;
    $info->version = ltrim($release_data['tag_name'], 'v');
    $info->author = $theme->get('Author');
    $info->homepage = "https://github.com/{$github_uri}";
    $info->download_link = "https://github.com/{$github_uri}/archive/refs/tags/{$release_data['tag_name']}.zip";
    $info->sections = array(
        'description' => $theme->get('Description'),
        'changelog' => isset($release_data['body']) ? nl2br($release_data['body']) : 'Confira as mudanças no GitHub.',
    );
    
    return $info;
}
add_filter('themes_api', 'chomneq_theme_update_info', 10, 3);

/**
 * Renomear pasta do tema após instalação
 * O GitHub cria uma pasta com o nome "repo-versao", precisamos renomear para o slug correto
 */
function chomneq_rename_theme_folder($response, $hook_extra, $result) {
    global $wp_filesystem;
    
    $theme = wp_get_theme();
    $theme_slug = $theme->get_stylesheet();
    $github_config = chomneq_get_github_config();
    $github_uri = $github_config['uri'];
    
    if (empty($github_uri)) {
        return $response;
    }
    
    // Extrair nome do repositório
    $repo_parts = explode('/', $github_uri);
    $repo_name = end($repo_parts);
    
    // Caminho da instalação
    $theme_directory = $result['destination'];
    $proper_destination = WP_CONTENT_DIR . '/themes/' . $theme_slug;
    
    // Se a pasta tem nome diferente do slug, renomear
    if ($theme_directory !== $proper_destination && strpos($theme_directory, $repo_name) !== false) {
        $wp_filesystem->move($theme_directory, $proper_destination, true);
        $result['destination'] = $proper_destination;
        $result['destination_name'] = $theme_slug;
    }
    
    return $response;
}
add_filter('upgrader_post_install', 'chomneq_rename_theme_folder', 10, 3);

/**
 * Limpar cache de atualizações manualmente (útil para debug)
 */
function chomneq_clear_theme_update_cache() {
    delete_site_transient('update_themes');
}
// Descomentar para forçar verificação: add_action('admin_init', 'chomneq_clear_theme_update_cache');

