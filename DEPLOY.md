# 🚀 Guia de Deploy e Versionamento

## 📋 Pré-requisitos

1. Git instalado
2. Conta no GitHub
3. Repositório criado no GitHub

## 🔧 Configuração Inicial

### 1. Atualizar informações do tema no `style.css`

Substitua `SEU-USUARIO/SEU-REPOSITORIO` pelo caminho real do seu repositório:

```css
GitHub Theme URI: usuario/nome-do-repo
GitHub Branch: main
```

### 2. Inicializar repositório Git (se ainda não foi feito)

```bash
cd wp-content/themes/ieq-784-with-chomneq
git init
git add .
git commit -m "feat: initial commit - version 1.1.0"
```

### 3. Conectar ao repositório remoto

```bash
git remote add origin https://github.com/SEU-USUARIO/SEU-REPOSITORIO.git
git branch -M main
git push -u origin main
```

## 📦 Processo de Release

### Passo 1: Atualizar Versão

Edite `style.css` e atualize o número da versão:

```css
Version: 1.1.0
```

### Passo 2: Atualizar Changelog

Edite `README.md` e adicione as mudanças na seção Changelog:

```markdown
### [1.1.0] - 2025-12-11

#### Adicionado
- Nova funcionalidade X
- Nova funcionalidade Y

#### Corrigido
- Bug Z
```

### Passo 3: Commit das Mudanças

```bash
git add .
git commit -m "release: version 1.1.0"
git push origin main
```

### Passo 4: Criar Tag

```bash
git tag -a v1.1.0 -m "Release version 1.1.0"
git push origin v1.1.0
```

### Passo 5: Criar Release no GitHub

1. Vá até o repositório no GitHub
2. Clique em **Releases** > **Create a new release**
3. Selecione a tag `v1.1.0`
4. Título: `Release 1.1.0`
5. Descrição: Cole o changelog desta versão
6. Marque **Set as the latest release**
7. Clique em **Publish release**

## 🔄 Verificar Atualização no WordPress

1. Acesse o painel WordPress
2. Vá em **Aparência > Temas**
3. Aguarde alguns segundos (o WordPress verifica atualizações)
4. Você verá uma notificação de atualização disponível
5. Clique em **Atualizar agora**

> **Nota:** O WordPress verifica atualizações a cada 12 horas. Para forçar verificação imediata, você pode:
> - Limpar cache do navegador
> - Ou adicionar temporariamente no `functions.php`:
>   ```php
>   add_action('admin_init', 'chomneq_clear_theme_update_cache');
>   ```
>   (Lembre-se de remover depois!)

## 📝 Padrão de Versionamento Semântico

Usamos [Semantic Versioning](https://semver.org/lang/pt-BR/):

- **MAJOR** (X.0.0): Mudanças incompatíveis na API
- **MINOR** (0.X.0): Novas funcionalidades compatíveis
- **PATCH** (0.0.X): Correções de bugs

Exemplos:
- `1.0.0` → `2.0.0`: Breaking changes
- `1.0.0` → `1.1.0`: Nova funcionalidade
- `1.0.0` → `1.0.1`: Correção de bug

## 🏷️ Convenção de Mensagens de Commit

Seguimos o padrão [Conventional Commits](https://www.conventionalcommits.org/pt-br/):

- `feat:` Nova funcionalidade
- `fix:` Correção de bug
- `docs:` Mudanças na documentação
- `style:` Formatação, espaços, etc
- `refactor:` Refatoração de código
- `test:` Adição ou correção de testes
- `chore:` Tarefas de build, configs, etc
- `release:` Nova versão

Exemplos:
```bash
git commit -m "feat: adicionar filtro por regional"
git commit -m "fix: corrigir erro no upload de imagens"
git commit -m "docs: atualizar README com novas instruções"
```

## 🔍 Troubleshooting

### Atualização não aparece no WordPress

1. Verifique se o `GitHub Theme URI` está correto no `style.css`
2. Verifique se a tag foi criada corretamente: `git tag`
3. Verifique se a release está publicada no GitHub
4. Forçe verificação de atualizações (veja acima)
5. Verifique logs do WordPress em `wp-content/debug.log`

### Erro 404 ao baixar tema

- Certifique-se de que o repositório é **público** ou configure access token

### Pasta do tema com nome errado após instalação

- O sistema automaticamente renomeia para o slug correto
- Se persistir, verifique a função `chomneq_rename_theme_folder` em `functions.php`

## 📚 Recursos Adicionais

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Releases](https://docs.github.com/pt/repositories/releasing-projects-on-github)
- [WordPress Theme Update API](https://developer.wordpress.org/themes/advanced-topics/theme-updates/)
- [Semantic Versioning](https://semver.org/)

## ✅ Checklist de Release

- [ ] Versão atualizada em `style.css`
- [ ] Changelog atualizado em `README.md`
- [ ] Código testado localmente
- [ ] Commit e push para `main`
- [ ] Tag criada e pushada
- [ ] Release criada no GitHub
- [ ] Atualização verificada no WordPress

---

**Dica:** Crie um script bash para automatizar o processo de release! 🚀
