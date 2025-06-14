# Regras de Verificação e Análise de Requisitos

## Características dos requisitos:

Os requisitos funcionais devem ser precedidos de RF (como RF01), enquanto que os requisitos não funcionais devem ser precedidos de RFN (como RFN01)

- Padrão de Prioridade: Os requisitos do sistema são classificados segundo sua importância para o projeto:
    - **Essencial**: Requisito imprescindível para o funcionamento do sistema. Sua ausência compromete o propósito central da aplicação.
    - **Importante**: Requisito cuja ausência não torna o sistema inoperante, mas impacta significativamente a conformidade entre o sistema planejado e o entregue. Deve ser priorizado assim que os requisitos essenciais forem atendidos.
    - **Desejável**: Requisito que não integra a estrutura central da aplicação. Sua implementação agrega valor ou melhora a experiência do usuário, sendo executada quando não houver pendências de requisitos essenciais ou importantes.
      
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

### 2. O requisito dever ser objetivo, se restringindo a comunicar o seu papel

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
