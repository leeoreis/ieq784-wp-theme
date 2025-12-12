# 📊 Google Analytics 4 - Eventos Personalizados

## Visão Geral

Sistema completo de tracking de eventos para análise de comportamento dos usuários no Portal da Região 784.

---

## 🎯 Eventos Rastreados

### 1. **Interação com Filtros** (`filter_interaction`)

Dispara quando usuário interage com filtros de atividades/regionais.

**Parâmetros:**
- `filter_type`: Tipo de filtro (date, regional, date_open, regional_open, clear_all)
- `filter_value`: Valor selecionado (ex: "3_months", ID da regional)
- `element_text`: Texto do botão clicado
- `page_title`: Título da página
- `page_type`: Tipo de conteúdo (page, post, etc)
- `page_url`: URL da página

**Exemplo de uso no GA4:**
- Ver quais períodos são mais consultados (1 mês vs 6 meses)
- Identificar regionais mais buscadas
- Taxa de uso de filtros combinados

---

### 2. **Clique em Atividade** (`atividade_click`)

Dispara quando usuário clica em "Saiba Mais" de uma atividade.

**Parâmetros:**
- `atividade_name`: Nome da atividade
- `link_url`: URL de destino
- `element_text`: Texto do botão (CTA customizado)
- `page_title`, `page_type`, `page_url`

**Exemplo de uso no GA4:**
- Atividades mais clicadas
- Taxa de conversão para páginas externas
- CTR de diferentes textos de CTA

---

### 3. **Clique em Instagram** (`instagram_click`)

Dispara quando usuário clica no Instagram de uma igreja regional.

**Parâmetros:**
- `igreja_name`: Nome da igreja
- `instagram_url`: URL do Instagram
- `page_title`, `page_type`, `page_url`

**Exemplo de uso no GA4:**
- Igrejas com maior engajamento social
- Taxa de cliques para redes sociais
- Origem geográfica dos cliques (se configurado)

---

### 4. **Botão Chomneq 2025** (`chomneq_button_click`)

Dispara quando usuário clica no botão principal "Ver os Expositores".

**Parâmetros:**
- `button_text`: Texto do botão
- `destination`: URL de destino
- `page_title`, `page_type`, `page_url`

**Exemplo de uso no GA4:**
- Taxa de conversão para página de expositores
- Efetividade do CTA principal
- Origem dos visitantes do Chomneq

---

### 5. **Links Externos** (`external_link_click`)

Dispara quando usuário clica em qualquer link externo ao site.

**Parâmetros:**
- `link_url`: URL completa do link
- `link_text`: Texto do link
- `link_domain`: Domínio de destino
- `page_title`, `page_type`, `page_url`

**Exemplo de uso no GA4:**
- Principais sites externos acessados
- Links mais populares
- Taxa de saída por domínio

---

### 6. **Cliques em Botões Genéricos** (`button_click`)

Dispara em botões não categorizados especificamente.

**Parâmetros:**
- `button_text`: Texto do botão
- `button_class`: Classes CSS
- `button_id`: ID do elemento
- `page_title`, `page_type`, `page_url`

---

### 7. **Profundidade de Scroll** (`scroll_depth`)

Dispara quando usuário atinge marcos de rolagem: 25%, 50%, 75%, 100%.

**Parâmetros:**
- `scroll_depth_percentage`: Porcentagem alcançada (25, 50, 75, 100)
- `page_title`, `page_type`, `page_url`

**Exemplo de uso no GA4:**
- Conteúdo mais lido completamente
- Taxa de leitura por tipo de página
- Identificar onde usuários param de ler

---

### 8. **Tempo na Página** (`time_on_page`)

Dispara em marcos de tempo: 30s, 60s, 120s (2min), 300s (5min).

**Parâmetros:**
- `time_seconds`: Segundos decorridos
- `time_label`: Label amigável (ex: "2min", "30s")
- `page_title`, `page_type`, `page_url`

**Exemplo de uso no GA4:**
- Páginas com maior tempo de engajamento
- Taxa de leitura profunda
- Identificar conteúdo valioso

---

### 9. **Abertura de Modais** (`modal_open`)

Dispara quando usuário abre modais de filtros.

**Parâmetros:**
- `modal_type`: Tipo do modal (date_filter, regional_filter)
- `page_title`, `page_type`, `page_url`

**Exemplo de uso no GA4:**
- Taxa de uso de filtros
- Preferência por tipo de filtro
- Engajamento com funcionalidades

---

### 10. **Busca no Site** (`search`)

Dispara quando usuário realiza uma busca.

**Parâmetros:**
- `search_term`: Termo pesquisado
- `page_title`, `page_type`, `page_url`

**Exemplo de uso no GA4:**
- Termos mais buscados
- Identificar conteúdo faltante
- Melhorar navegação baseado em buscas

---

## 📈 Como Visualizar no Google Analytics 4

### 1. **Tempo Real**
- GA4 → Relatórios → Tempo Real
- Ver eventos acontecendo agora
- Útil para testar implementação

### 2. **Eventos**
- GA4 → Relatórios → Engajamento → Eventos
- Ver todos os eventos disparados
- Métricas de contagem e conversões

### 3. **Criar Relatórios Personalizados**
```
GA4 → Explorar → Criar nova exploração
- Dimensões: event_name, page_title, filter_type, etc
- Métricas: event_count, users, sessions
- Segmentos: Por regional, por tipo de evento, etc
```

### 4. **Conversões**
```
GA4 → Configurar → Eventos
- Marcar eventos importantes como conversões
- Sugestões: chomneq_button_click, atividade_click, scroll_depth (100%)
```

---

## 🔍 Debug e Testes

### Ver eventos no Console do Navegador:
1. Abra DevTools (F12)
2. Vá na aba Console
3. Interaja com o site
4. Veja logs: `GA4 Event: [nome_do_evento] {parâmetros}`

### Ver dataLayer:
```javascript
// No console do navegador
console.log(dataLayer);
```

### Testar evento manualmente:
```javascript
// No console do navegador
gtag('event', 'test_event', {
  test_param: 'test_value'
});
```

---

## 💡 Exemplos de Análises Possíveis

### 1. **Funil de Conversão para Chomneq 2025**
```
Pageviews → Scroll 50% → Filter Usage → Chomneq Button Click
```

### 2. **Engajamento com Igrejas Regionais**
```
Igreja Card View → Instagram Click → Taxa de conversão por igreja
```

### 3. **Qualidade do Conteúdo**
```
Scroll Depth + Time on Page → Identificar melhores páginas
```

### 4. **Efetividade de Filtros**
```
Filter Modal Open → Filter Selection → Atividade Click
```

---

## 🚀 Próximos Passos Recomendados

1. **Configurar Conversões** em eventos chave
2. **Criar Públicos** baseado em comportamento
3. **Configurar Alertas** para quedas/picos anormais
4. **Integrar com Google Search Console** para SEO
5. **Criar Relatórios Automatizados** semanais/mensais

---

## 📝 Notas Técnicas

- **Performance**: Script carrega no `wp_footer` (não bloqueia renderização)
- **Debug**: Logs no console apenas em desenvolvimento
- **Privacidade**: Não coleta dados pessoais sensíveis
- **Compatibilidade**: Funciona com GA4 Universal Analytics

---

**Documentação criada em**: 12 de dezembro de 2025  
**Versão do tema**: 1.3.9+  
**Desenvolvedor**: Leonardo Reis dos Santos
