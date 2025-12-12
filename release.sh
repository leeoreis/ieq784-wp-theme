#!/bin/bash

# Script de Release Automático para IEQ 784 Theme
# Uso: ./release.sh [major|minor|patch]

set -e

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Função para exibir mensagens
msg_info() {
    echo -e "${GREEN}ℹ️  $1${NC}"
}

msg_warn() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

msg_error() {
    echo -e "${RED}❌ $1${NC}"
    exit 1
}

# Verificar se está no diretório correto
if [ ! -f "style.css" ]; then
    msg_error "Execute este script na raiz do tema (onde está o style.css)"
fi

# Verificar se há mudanças não commitadas
if [ -n "$(git status --porcelain)" ]; then
    msg_warn "Existem mudanças não commitadas. Faça commit primeiro!"
    git status --short
    exit 1
fi

# Obter versão atual do style.css
CURRENT_VERSION=$(grep "Version:" style.css | head -1 | awk '{print $2}')
msg_info "Versão atual: $CURRENT_VERSION"

# Determinar nova versão
if [ -z "$1" ]; then
    msg_error "Uso: ./release.sh [major|minor|patch]"
fi

IFS='.' read -ra VERSION_PARTS <<< "$CURRENT_VERSION"
MAJOR="${VERSION_PARTS[0]}"
MINOR="${VERSION_PARTS[1]}"
PATCH="${VERSION_PARTS[2]}"

case $1 in
    major)
        MAJOR=$((MAJOR + 1))
        MINOR=0
        PATCH=0
        ;;
    minor)
        MINOR=$((MINOR + 1))
        PATCH=0
        ;;
    patch)
        PATCH=$((PATCH + 1))
        ;;
    *)
        msg_error "Tipo inválido. Use: major, minor ou patch"
        ;;
esac

NEW_VERSION="$MAJOR.$MINOR.$PATCH"
msg_info "Nova versão: $NEW_VERSION"

# Confirmar
read -p "Continuar com a release v$NEW_VERSION? (s/N) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Ss]$ ]]; then
    msg_warn "Release cancelada"
    exit 0
fi

# Atualizar versão no style.css
msg_info "Atualizando style.css..."
sed -i.bak "s/Version: $CURRENT_VERSION/Version: $NEW_VERSION/" style.css
rm style.css.bak

# Commit da mudança de versão
msg_info "Criando commit..."
git add style.css
git commit -m "release: version $NEW_VERSION"

# Criar tag
msg_info "Criando tag v$NEW_VERSION..."
git tag -a "v$NEW_VERSION" -m "Release version $NEW_VERSION"

# Push
msg_info "Fazendo push para o repositório..."
BRANCH=$(git rev-parse --abbrev-ref HEAD)
git push origin "$BRANCH"
git push origin "v$NEW_VERSION"

msg_info "✅ Release v$NEW_VERSION criada com sucesso!"
echo ""
msg_info "Próximos passos:"
echo "1. Acesse: https://github.com/SEU-USUARIO/SEU-REPOSITORIO/releases/new"
echo "2. Selecione a tag: v$NEW_VERSION"
echo "3. Adicione o changelog da versão"
echo "4. Publique a release"
echo ""
msg_info "Após publicar, o WordPress detectará a atualização automaticamente!"
