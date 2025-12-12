# Changelog

Todas as mudanças notáveis neste projeto serão documentadas neste arquivo.

O formato é baseado em [Keep a Changelog](https://keepachangelog.com/pt-BR/1.0.0/),
e este projeto adere ao [Semantic Versioning](https://semver.org/lang/pt-BR/).

## [1.1.0] - 2025-12-11

### Adicionado
- Sistema de gerenciamento de conteúdo da página em construção
- Página administrativa "Página em Construção" no menu WordPress
- Upload de imagem de background para a hero section
- Preview de imagem em tempo real na interface admin
- Sistema de atualização automática via GitHub Releases
- Verificação automática de atualizações do tema
- Notificação de atualização no painel WordPress
- Filtros combinados de data E regional para atividades
- Modal interativo para seleção de filtros (substituindo dropdowns)
- Botão "Limpar Filtros" que aparece quando filtros estão ativos
- Logo SVG do Instagram nos cards de regionais (substituindo emoji)
- Campo "Pastor Líder" no cadastro de igrejas regionais
- Campo "Endereço" (textarea) no cadastro de igrejas regionais
- Overlay escuro na hero para melhor legibilidade do texto
- Documentação completa de deploy e versionamento (DEPLOY.md)
- Arquivo .gitignore configurado
- README.md atualizado com todas as funcionalidades

### Melhorado
- Design dos cards de igreja regional (agora com imagem full-width)
- Cards de regional seguem mesmo padrão visual das atividades
- Interface de filtros de atividades (modal ao invés de dropdowns)
- Experiência do usuário na seleção de filtros
- Responsividade dos filtros em mobile
- Organização do código de filtros JavaScript
- Header da igreja regional com gradiente e sobreposição
- Layout dos cards de regional com flexbox
- Espaçamento e proporções visuais

### Corrigido
- Erro "wp.media is not a function" no Media Uploader
- Enfileiramento correto de scripts WordPress
- Carregamento do jQuery na página de configurações

### Alterado
- Versão atualizada de 1.0.6 para 1.1.0
- Cards de igreja de circular para retangular com imagem full-width
- Sistema de filtros de botões/dropdown para modal interativo
- Estrutura CSS do hero para suportar background-image

## [1.0.6] - 2025-XX-XX

### Funcionalidades Base
- Custom Post Type: Igreja Regional
- Custom Post Type: Expositor
- Custom Post Type: Atividade
- Taxonomias: Categoria Expositor, Regional Expositor, Pasta Expositor
- Integração AWS S3 + CloudFront
- Otimização automática de imagens
- Sistema de aprovação de posts
- Email de notificação para novos expositores
- Filtros de data para atividades
- Login redirects para role expositor
- Bloqueio de acesso ao wp-admin para expositores
- Página template "Em Construção"
- Sistema de comentários hierárquico
- Interface administrativa para S3

### Design
- Cards responsivos para expositores
- Cards para igrejas regionais
- Cards para atividades
- Hero section animada
- Sistema de grid responsivo
- Lightbox para galerias

---

## Template de Release

```markdown
## [X.Y.Z] - YYYY-MM-DD

### Adicionado
- Nova funcionalidade

### Melhorado
- Melhoria existente

### Corrigido
- Bug corrigido

### Alterado
- Mudança de comportamento

### Removido
- Funcionalidade removida

### Segurança
- Correção de vulnerabilidade
```

---

**Legenda:**
- `Adicionado` para novas funcionalidades
- `Melhorado` para melhorias em funcionalidades existentes
- `Corrigido` para correções de bugs
- `Alterado` para mudanças em funcionalidades existentes
- `Removido` para funcionalidades removidas
- `Segurança` para correções de vulnerabilidades

[1.1.0]: https://github.com/SEU-USUARIO/SEU-REPOSITORIO/compare/v1.0.6...v1.1.0
[1.0.6]: https://github.com/SEU-USUARIO/SEU-REPOSITORIO/releases/tag/v1.0.6
