# 📚 Sistema de Cadastro de Livros

Projeto desenvolvido com **PHP 8.3**, **Laravel 12**, **Vite** e **Bootstrap**, com o objetivo de gerenciar o cadastro de **livros**, **autores** e **assuntos**.

---

## ⚙️ Tecnologias Utilizadas

- **PHP 8.3**
- **Laravel 12**
- **Vite** (para assets frontend)
- **Bootstrap 5**
- **MySQL** ou outro banco de sua preferência

---

## 🚀 Funcionalidades

- Cadastro de livros com:
  - Título
  - Autor
  - Assunto
- Gerenciamento de autores (CRUD)
- Gerenciamento de assuntos (CRUD)
- Interface amigável com Bootstrap

---

## 🛠️ Requisitos

Antes de iniciar, verifique se você tem instalado:

- PHP 8.3
- Composer
- Node.js e npm
- Make (no Linux ou WSL, ou configure make no Windows)

---

## 📦 Instalação

```bash
# Clone o repositório
git clone https://gitlab.com/seu-usuario/nome-do-repositorio.git
cd nome-do-repositorio

# Instale as dependências do PHP
composer install

# Instale as dependências do frontend
npm install

# Copie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Configure o banco de dados no arquivo .env

# Rode as migrações
php artisan migrate

# Inicie o projeto
make start
