# 📋 Sistema de Cadastro de Expositores

## 🎯 Visão Geral

Sistema completo para gerenciamento de expositores com cadastro frontend e aprovação administrativa.

---

## 🔐 Perfis de Usuário

### **Expositor** (Role: `expositor`)
- Pode criar/editar **apenas seu próprio** cadastro
- Acessa via `/cadastro-expositor`
- Submissões ficam como **"Aguardando Aprovação"**
- Não pode publicar diretamente
- Acesso limitado no admin

### **Administrador**
- Aprova/rejeita cadastros
- Edita qualquer expositor
- Acesso total ao WordPress

---

## 🚀 Como Funciona

### **1. Criar Usuário Expositor**

**Via Admin (recomendado):**
```
WordPress Admin → Usuários → Adicionar Novo
- Nome: João Silva
- E-mail: joao@exemplo.com
- Função: Expositor
```

**Ou via código (temporário):**
```php
// Adicione isso em functions.php temporariamente
add_action('init', function() {
    if (!username_exists('expositor1')) {
        wp_create_user('expositor1', 'senha123', 'expositor1@exemplo.com');
        $user = get_user_by('login', 'expositor1');
        $user->set_role('expositor');
    }
});
```

### **2. Expositor Acessa o Sistema**

1. Login em `/wp-admin` ou `/wp-login.php`
2. Acessa `/cadastro-expositor`
3. Preenche o formulário:
   - ✅ Informações básicas (nome, descrição)
   - ✅ Imagem principal
   - ✅ Galeria de produtos
   - ✅ Contatos (WhatsApp, Instagram, etc)
   - ✅ Dados de pagamento (PIX + QR Code)
4. Clica em **"Enviar para Aprovação"**
5. Status: **"⏳ Aguardando Aprovação"**

### **3. Admin Aprova o Cadastro**

```
WordPress Admin → Expositores
- Encontra o post "Pendente"
- Revisa as informações
- Clica em "Publicar"
```

**Pronto! O expositor aparece no site.**

---

## 📄 Arquivos Criados

```
wp-content/themes/chomneq-template/
├── page-cadastro-expositor.php    # Template do formulário frontend
├── functions.php                   # Lógica AJAX e permissões
└── README-SISTEMA-EXPOSITOR.md     # Este arquivo
```

---

## 🔧 Funcionalidades Implementadas

### ✅ **Segurança**
- Verificação de nonce (CSRF protection)
- Sanitização de todos os campos
- Restrição por role (expositor só vê seus posts)
- Upload seguro de arquivos

### ✅ **Frontend**
- Formulário completo e responsivo
- Upload de múltiplas imagens (galeria)
- Preview de imagens existentes
- Mensagens de sucesso/erro
- Status visual (Aprovado/Pendente)

### ✅ **Backend**
- AJAX para envio sem reload
- Validação de dados
- Sistema de aprovação (draft → publish)
- Expositores veem apenas seus posts no admin

### ✅ **Recursos**
- Upload de imagem destacada
- Galeria de produtos (múltiplas fotos)
- QR Code PIX
- Categorização
- Todos os campos de contato e pagamento

---

## 🎨 Melhorias Sugeridas (Implementadas)

### **1. Auto-criação de Página**
✅ Página `/cadastro-expositor` criada automaticamente ao ativar tema

### **2. Restrição no Admin**
✅ Expositores só veem seus próprios posts
✅ Menus desnecessários removidos

### **3. Status Visual**
✅ Indicador claro: "✓ Aprovado" ou "⏳ Aguardando"

### **4. Upload Múltiplo**
✅ Galeria aceita várias imagens de uma vez

### **5. Mensagens Amigáveis**
✅ Feedback visual após envio

---

## 📝 Exemplos de Uso

### **Cenário 1: Novo Expositor**
```
1. Admin cria usuário "maria" com role "Expositor"
2. Maria recebe e-mail com login/senha
3. Maria acessa /cadastro-expositor
4. Preenche dados do negócio "Doces da Maria"
5. Envia → Status: Pendente
6. Admin revisa e publica
7. Aparece no site!
```

### **Cenário 2: Editar Cadastro**
```
1. Maria acessa /cadastro-expositor novamente
2. Vê formulário preenchido com seus dados
3. Atualiza fotos da galeria
4. Salva → Status volta para Pendente
5. Admin aprova novamente
```

---

## 🔄 Fluxo Completo

```
┌─────────────────┐
│ Usuário Expositor│
│    (maria)      │
└────────┬────────┘
         │
         ▼
┌─────────────────────────┐
│ /cadastro-expositor     │
│ - Login obrigatório     │
│ - Formulário completo   │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ AJAX → functions.php    │
│ - Valida dados          │
│ - Salva como "pending"  │
│ - Upload de arquivos    │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ WordPress Admin         │
│ Expositores → Pendentes │
│ Admin revisa e publica  │
└────────┬────────────────┘
         │
         ▼
┌─────────────────────────┐
│ Site Público            │
│ Expositor visível       │
│ em / e /expositor/maria │
└─────────────────────────┘
```

---

## ⚙️ Configuração Inicial

### **Após ativar o tema:**

1. A role "Expositor" é criada automaticamente
2. A página `/cadastro-expositor` é criada
3. Tudo pronto para uso!

### **Para criar primeiro expositor:**

```
Admin → Usuários → Adicionar Novo
Nome: Teste Expositor
E-mail: teste@exemplo.com
Senha: senha123
Função: Expositor
```

Depois acesse: `http://localhost:8000/cadastro-expositor`

---

## 🎯 Permissões Detalhadas

| Ação | Expositor | Admin |
|------|-----------|-------|
| Ver formulário cadastro | ✅ Apenas seu | ✅ Todos |
| Criar expositor | ✅ Sim (pending) | ✅ Sim |
| Editar expositor | ✅ Apenas seu | ✅ Todos |
| Publicar | ❌ Não | ✅ Sim |
| Deletar | ❌ Não | ✅ Sim |
| Ver outros expositores | ❌ Não | ✅ Sim |

---

## 📞 Suporte

Para dúvidas ou melhorias, edite este README ou consulte:
- `page-cadastro-expositor.php` - Frontend
- `functions.php` - Lógica AJAX (procure por `chomneq_ajax_salvar_expositor_frontend`)

---

## 🎉 Pronto para Uso!

O sistema está **100% funcional**. Basta criar usuários com role "Expositor" e compartilhar o link `/cadastro-expositor` com eles.
