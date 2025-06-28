# AutoWeb

AutoWeb é um sistema web interno desenvolvido para a empresa fictícia CtrlCar, com o objetivo de facilitar o gerenciamento de veículos, clientes, vendedores e vendas. O sistema permite o cadastro e controle das operações da revenda de forma centralizada, com autenticação de usuários e geração de relatórios gerenciais.

## 👨‍🏫 Orientador
Prof. Antônio Maria Pereira de Resende
Universidade Federal de Lavras - UFLA
2025

> Projeto desenvolvido para o Trabalho Prático Final da disciplina **GCC188 - Engenharia de Software** da Universidade Federal de Lavras.

<div align="center">
    <img src="https://img.shields.io/badge/Laravel-10-red" alt="Licença Educacional">
    <img src="https://img.shields.io/badge/Licença-Educacional-green" alt="Licença Educacional">
</div>

---

## 💻 TECNOLOGIAS UTILIZADAS

| Tecnologia       | Versão     | Descrição                           |
|------------------|------------|--------------------------------------|
| PHP              | 8.2+       | Linguagem principal do backend       |
| Laravel          | 10.x       | Framework PHP para desenvolvimento web |
| MySQL            | 8.x        | Banco de dados relacional            |
| Composer         | 2.x        | Gerenciador de dependências PHP      |
| HTML             | 5          | Linguagem de marcação usada no frontend      |
| CSS              | 3          | Folhas de estilo para estilização visual     |
| Blade            | Laravel 10 | Motor de templates nativo do Laravel         |

---

## ⚙️ Instalação e Configuração

```bash
# Clone o repositório
git clone https://github.com/SEU_USUARIO/NOME_DO_REPOSITORIO.git

# Acesse o diretório do projeto
cd NOME_DO_REPOSITORIO

# Inicialize o sail
sail up -d

# Instale as dependências
sail npm i

# Rode as migrations do banco
sail artisan migrate

# Rode a geração das chaves
sail artisan key:generate

# Rode os seeders do banco
 sail artisan migrate:fresh --seed

#Para carregar a instância do frontend do projeto
sail npm run dev


```
## 🛠️ Padronização de Commits

| Tipo de Commit | Prefixo                  | Descrição                                                                                                   |
| -----------    | ------------------------ | ----------------------------------------------------------------------------------------------------------- |
| `feat`         | feat:                    | Funcionalidade nova                                                                                         | 
| `fix`          | fix:                     | Correção de bug                                                                                             | 
| `docs`         | docs:                    | Mudança apenas em documentação                                                                              | 
| `style`        | style:                   | Alterações que não afetam lógica: espaços, ponto e vírgula, etc.                                            | 
| `refactor`     | refactor:                | Alteração no código que não corrige bug nem adiciona funcionalidade                                         |  
| `test`         | test:                    | Apenas adição/modificação de testes                                                                         |  
| `chore`        | chore:                   | Tarefas de manutenção, sem impacto direto no código de produção                                             | 

## 📋 Branches
- **`main`**: Branch principal do projeto, estável e pronta para deploy
- **`develop`**: Branch dedicada ao desenvolvimento de funcionalidades  
- **`test`**: Branch dedicada ao teste de funcionalidades

Criação de branches:
- Crie novas branches a partir da develop para funcionalidades ou correções.
- Nomeie usando hífens. Exemplos:
  - `dev-criando-crud-veículos`  
  - `dev-criando-crud-clientes`
 
## 🛠️ Boas práticas de programação adotadas
- Comentar código: adicionar comentários para auxiliar na compreensão e separação de trechos de código.
- Nomear funções de maneira intuitiva: criar nomes para as funções de modo a permitir uma compreensão inicial do que se trata a função.
- Indentar o código: fazer a indentação no corpo de uma estrutura.
- Legibilidade de comandos: separar os comandos longos em várias linhas, quebrando-as em pontos que façam sentido.
- Tratar erros e exceções adequadamente: implementar mecanismos de tratamento de erros (como try/catch ou verificações de condições) para evitar falhas inesperadas e tornar o sistema mais robusto e seguro.
- Utilizar controle de versão (como Git): manter o histórico das alterações no código usando sistemas de versionamento. Isso facilita o trabalho em equipe, o rastreamento de mudanças e a reversão em caso de erros.
