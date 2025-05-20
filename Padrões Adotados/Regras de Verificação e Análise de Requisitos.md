# Regras de Verificação e Análise de Requisitos

## Características dos requisitos:

Os requisitos funcionais devem ser precedidos de RF (como RF01), enquanto que os requisitos não funcionais devem ser precedidos de RFN (como RFN01)

- **Padrão de prioridade**: os requisitos devem ser classificados segundo sua importancia para o projeto:
    - Alta: Requisito imprescindível, parte central da aplicação
    - Média: Importante, priorizado caso não haja nenhum requisito de alta prioridade
    - Baixa: Desejável, mas não essencial

- **Padrão de commits**: Todos os commits realizados no repositório devem seguir a convenção Conventional Commits, garantindo clareza no histórico de versões, facilitando automações como geração de changelogs e rastreabilidade de alterações.

> Formato:
```
<tipo>: <descrição sucinta>
```

Exemplos principais:

- **feat**: adicionar suporte à criação de flashcards via IA <br>
*(Funcionalidade nova)*

- **fix**: corrigir erro ao salvar marcações de vídeo <br>
*(Correção de bug)*

- **docs**: atualizar README com instruções de instalação <br>
*(Mudança apenas em documentação)*

- **style**: padronizar indentação no componente de revisão <br>
*(Alterações que não afetam lógica: espaços, ponto e vírgula, etc.)*

- **refactor**: reorganizar estrutura do módulo de estudo <br>
*(Alteração no código que não corrige bug nem adiciona funcionalidade)* 

- **test**: adicionar testes unitários para o componente de dashboard <br>
*(Apenas adição/modificação de testes)*

- **chore**: atualizar dependências do projeto <br>
(Tarefas de manutenção, sem impacto direto no código de produção)

## Regras de Requisitos:
### 1. Requisitos devem ter menor granularidade possível

### Exemplos: <br>
✅ Correto: <br>
> O software DEVE permitir o registro dos clientes da empresa <br>
> O software não DEVE permitir o registro de dois clientes com o mesmo CNPJ <br>

❌ Incorreto:
> O software DEVE permitir o registro dos clientes da empresa E não DEVE permitir o registro de dois clientes com o mesmo CNPJ

### 2. Não utilizar frases grandes

### Exemplos: <br>
✅ Correto: <br>
> O software DEVE permitir o registro dos clientes da empresa <br>

❌ Incorreto:
> O software DEVE permitir o registro dos clientes da nossa estimada empresa <br>

### 2. Não deve haver ambiguidade

### Exemplos: <br>
❌ Incorreto:
> O software DEVE notificar a presença de aviões inimigos que tenham uma missão não conhecida ou com potencial para entrar no espaço aéreo restrito dentro de cinco minutos disparado um alerta <br>

✅ Correto: <br>
> O software DEVE notificar a presença de aviões [**inimigos**] E [**que tenham uma missão não conhecida**] E [**com potencial para entrar no espaço aéreo restrito dentro de cinco minutos**] disparado um alerta <br> 