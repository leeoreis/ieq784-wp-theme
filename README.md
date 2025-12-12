# Portal da Região 784 - IEQ Rio de Janeiro

![Version](https://img.shields.io/badge/version-1.3.0-blue.svg)
![WordPress](https://img.shields.io/badge/wordpress-6.0%2B-blue.svg)
![PHP](https://img.shields.io/badge/php-8.0%2B-purple.svg)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-green.svg)
![SEO](https://img.shields.io/badge/SEO-optimized-success.svg)

Portal oficial da Região 784 da Igreja do Evangelho Quadrangular no Rio de Janeiro. Sistema completo para gerenciamento de igrejas regionais, catálogo de expositores e agenda de atividades, com otimizações avançadas de SEO e performance.

## ✨ Funcionalidades

### 🔍 SEO e Marketing Digital
- **Meta tags otimizadas** para Google
- **Open Graph** completo (Facebook, WhatsApp, LinkedIn)
- **Twitter Cards** configuradas
- **Schema.org JSON-LD** (Church + WebSite)
- **Geo tags** para SEO local (Rio de Janeiro)
- **Canonical URLs** automáticas
- **robots.txt** otimizado
- **Sitemap XML** hint

### 📍 Igrejas Regionais
- Cadastro completo de igrejas regionais
- Informações de pastor líder e endereço
- Integração com Instagram
- Sistema de marcação de igreja sede
- Ordenação customizável
- Cards modernos com imagem full-width

### 🛍️ Catálogo de Expositores (Chomneq)
- Custom Post Type para expositores
- Taxonomias: Categorias, Regionais e Pastas de Mídia
- Sistema de aprovação de posts
- Filtros avançados de busca
- Redirecionamento automático após login
- Proteção de acesso ao admin

### 🗓️ Agenda Regional
- Gestão de atividades e eventos
- Campos customizados (datas, local, links, CTA)
- Sistema de filtros por data com modal interativo
- Sistema de filtros por regional
- Atribuição de atividades às regionais
- Cards visuais com imagens destacadas
- Status de ativação/desativação

### ☁️ Integração AWS S3 + CloudFront
- Upload automático de imagens para S3
- Otimização de imagens (resize + compressão)
- Sincronização de miniaturas
- Suporte a CloudFront CDN
- Assinatura AWS v4
- Interface administrativa completa

### 📧 Notificações
- Email automático para novos cadastros de expositores
- Detalhes completos no corpo do email
- Sistema de logging para debug

### ⚙️ Gerenciamento de Conteúdo
- Página administrativa para configurações
- Upload de imagem de background da hero
- Interface intuitiva com preview

### 🔄 Sistema de Atualização Automática
- Atualizações via GitHub releases
- Notificação no painel WordPress
- Instalação com um clique
- Changelog integrado

## 📋 Requisitos

- WordPress 6.0 ou superior
- PHP 7.4 ou superior
- MySQL 5.7 ou superior

## 🚀 Instalação

### Via WordPress Admin (Recomendado)

1. Faça login no painel do WordPress
2. Vá em **Aparência > Temas**
3. O tema verificará automaticamente por atualizações
4. Clique em **Atualizar** quando disponível

### Instalação Manual

1. Baixe a última release: [Releases](../../releases/latest)
2. No painel WordPress, vá em **Aparência > Temas > Adicionar novo > Enviar tema**
3. Faça upload do arquivo ZIP
4. Ative o tema

### Via Git (Desenvolvimento)

```bash
cd wp-content/themes/
git clone https://github.com/SEU-USUARIO/SEU-REPOSITORIO.git ieq-784-with-chomneq
```

## 🔧 Configuração

### AWS S3 (Opcional)

1. Vá em **Configurações S3** no admin do WordPress
2. Preencha suas credenciais AWS:
   - Access Key ID
   - Secret Access Key
   - Bucket Name
   - Region
3. (Opcional) Configure CloudFront CDN URL
4. Salve as configurações

### Página em Construção

1. Vá em **Página em Construção** no menu admin
2. Faça upload da imagem de background da hero
3. Salve as alterações

### Regionais e Atividades

1. Crie suas igrejas regionais em **Igreja Regional**
2. Adicione atividades em **Atividades**
3. Associe cada atividade a uma regional
4. Configure datas e informações

## 📦 Custom Post Types

### Igreja Regional
- Campos: Pastor, Endereço, Instagram, Ordem, Sede
- Suporta imagem destacada

### Expositor
- Campos: Email, Telefone, WhatsApp, Localização, etc.
- Taxonomias: Categorias, Regionais, Pastas
- Sistema de aprovação

### Atividade
- Campos: Data início/fim, Local, Link, CTA, Cor
- Atribuição de regional
- Status ativo/inativo

## 🎨 Personalização

O tema é totalmente customizável através do admin do WordPress. Nenhuma edição de código é necessária para operações básicas.
- Paginação automática

## 🚀 Instalação

1. Acesse o painel do WordPress
2. Vá em **Aparência > Temas**
3. O tema **Chomneq Template** já está instalado
4. Clique em **Ativar**

## 📝 Como Usar

### Ativar o Tema

1. No painel do WordPress, vá em **Aparência > Temas**
2. Ative o tema **Chomneq Template**
3. Após ativar, vá em **Configurações > Links Permanentes** e clique em **Salvar** para atualizar as URLs

### Criar Categorias

1. No painel, vá em **Expositores > Categorias**
2. Adicione categorias como:
   - Alimentação
   - Artesanato
   - Moda e Acessórios
   - Beleza e Estética
   - Tecnologia
   - Serviços
   - etc.

### Cadastrar Expositores

1. No painel, vá em **Expositores > Adicionar Novo**
2. Preencha:
   - **Título:** Nome do expositor/empresa
   - **Conteúdo:** Descrição detalhada do negócio
   - **Imagem Destacada:** Logo ou foto principal
   - **Categorias:** Selecione a categoria apropriada
   - **Informações do Expositor:** Preencha todos os campos de contato e pagamento
   - **Galeria de Fotos:** Adicione IDs das imagens (ver instruções abaixo)

### Adicionar Galeria de Fotos

1. Vá em **Mídia > Biblioteca**
2. Faça upload das fotos dos produtos
3. Clique em cada imagem
4. Na URL do navegador, copie o número do ID (ex: `post=123`)
5. No cadastro do expositor, cole os IDs separados por vírgula
   - Exemplo: `123,124,125,126`

### Configurar Página Inicial

1. Crie uma nova página chamada "Início"
2. No editor, selecione o template "Página Inicial"
3. Vá em **Configurações > Leitura**
4. Selecione "Uma página estática" e escolha "Início"

## 🐛 Problemas Conhecidos

Nenhum no momento. Reporte issues em: [Issues](../../issues)

## 📝 Changelog

### [1.1.0] - 2025-12-11

#### Adicionado
- Sistema de gerenciamento de conteúdo da página em construção
- Upload de imagem de background da hero via admin
- Sistema de atualização automática via GitHub
- Filtros combinados de data e regional para atividades
- Modal interativo para seleção de filtros
- Logo SVG do Instagram nos cards de regionais
- Campos de Pastor e Endereço nas regionais
- Cards modernos com imagem full-width para regionais

#### Melhorado
- Design dos cards de igreja regional
- Interface de filtros de atividades
- Experiência do usuário no admin

### [1.0.6] - 2025-12-XX
- Versão anterior com funcionalidades base

## 👤 Autor

**Leonardo Reis**
- LinkedIn: [leeoreis](https://www.linkedin.com/in/leeoreis/)

## 📄 Licença

Este projeto está licenciado sob a GPL v2 ou posterior.

## 🤝 Contribuindo

Contribuições são bem-vindas! Por favor:

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📞 Suporte

Para suporte, abra uma [issue](../../issues) ou entre em contato via LinkedIn.

---

Desenvolvido com ❤️ para IEQ Região 784

4. Em "Sua página inicial exibe", selecione "Uma página estática"
5. Escolha "Início" como página inicial

### Configurar Menu

1. Vá em **Aparência > Menus**
2. Crie um novo menu
3. Adicione links como:
   - Início
   - Expositores (link personalizado para `/expositor/`)
   - Categorias
4. Atribua ao local "Menu Principal"

## 🎯 Estrutura de Arquivos

```
chomneq-template/
├── style.css                          # Estilos principais
├── functions.php                      # Funções do tema
├── header.php                         # Cabeçalho
├── footer.php                         # Rodapé
├── index.php                          # Página inicial
├── single-expositor.php               # Página individual do expositor
├── archive-expositor.php              # Arquivo de expositores
├── taxonomy-categoria_expositor.php   # Arquivo de categoria
├── screenshot.png                     # Screenshot do tema
├── js/
│   └── filter.js                     # Scripts de filtros e interações
└── template-parts/
    └── content-expositor-card.php    # Template do card
```

## 🎨 Customização de Cores

No arquivo `style.css`, altere as variáveis CSS:

```css
:root {
    --primary-color: #2c3e50;      /* Cor principal */
    --secondary-color: #3498db;     /* Cor secundária */
    --accent-color: #e74c3c;        /* Cor de destaque */
    --success-color: #27ae60;       /* Cor de sucesso */
}
```

## 📱 Responsividade

O tema é totalmente responsivo e se adapta a:
- Desktops (1200px+)
- Tablets (768px - 1199px)
- Smartphones (até 767px)

## ⚡ Recursos Especiais

### Copiar Chave PIX
Clique na chave PIX para copiar automaticamente para a área de transferência.

### Lightbox de Galeria
Clique nas imagens da galeria para visualizar em tela cheia.

### Animações
Cards aparecem suavemente ao fazer scroll pela página.

### WhatsApp Direto
Link direto para WhatsApp formatado corretamente para Brasil (+55).

## 🔧 Requisitos

- WordPress 5.0 ou superior
- PHP 7.4 ou superior
- MySQL 5.7 ou superior

## 📞 Suporte

Para dúvidas ou problemas, entre em contato com o desenvolvedor.

## 📄 Licença

GNU General Public License v2 or later

---

**Desenvolvido para Feira de Empreendedorismo Chomneq IEQ**
