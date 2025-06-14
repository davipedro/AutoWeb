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

# Instale as dependências PHP
composer install

# Instale as dependências frontend (se aplicável)
npm install && npm run dev

# Copie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure o banco de dados no .env
# DB_DATABASE=nome_do_banco
# DB_USERNAME=seu_usuario
# DB_PASSWORD=sua_senha

# Rode as migrations
php artisan migrate

# Inicie o servidor local
php artisan serve

```
## ⚙️ Padronização de Commits


