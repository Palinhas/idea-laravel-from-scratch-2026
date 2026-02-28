# 🚀 Guia de Setup do Projeto Laravel Localmente

## Passos para Recriar o Projeto Localmente

### 1️⃣ **Instalar Dependências PHP (Composer)**
```bash
composer install
```
Isso vai instalar todas as dependências PHP listadas no `composer.json`.

---

### 2️⃣ **Criar Arquivo `.env`**
```bash
copy .env.example .env
```
Ou manualmente copiar o arquivo `.env.example` para `.env`.

---

### 3️⃣ **Gerar Chave da Aplicação**
```bash
php artisan key:generate
```
Isso vai gerar uma `APP_KEY` aleatória no arquivo `.env`.

---

### 4️⃣ **Executar Migrações do Banco de Dados**
```bash
php artisan migrate --force
```
Isso vai criar as tabelas no banco de dados.

---

### 5️⃣ **Instalar Dependências Node.js (npm)**
```bash
npm install
```
Isso vai instalar todas as dependências frontend (Vite, Tailwind CSS, etc).

---

### 6️⃣ **Compilar Assets Frontend**
```bash
npm run build
```
Isso vai compilar os arquivos CSS e JavaScript.

---

### 7️⃣ **Seeders (Opcional - Para Popular o Banco com Dados de Teste)**
```bash
php artisan db:seed
```
Isso vai popular o banco de dados com dados de teste.

---

## ⚡ **Método Rápido: Usar o Script Setup**

Se preferir executar tudo de uma vez, use o script configurado:

```bash
composer run setup
```

Este comando executará automaticamente:
- `composer install`
- Copiar `.env.example` para `.env`
- `php artisan key:generate`
- `php artisan migrate --force`
- `npm install`
- `npm run build`

---

## 🔧 **Alternativas para Desenvolvimento**

### Desenvolvimento em Tempo Real (Hot Reload)
Se você está desenvolvendo, use o Vite em modo desenvolvimento:

```bash
npm run dev
```

Isso vai iniciar o servidor de desenvolvimento com hot reload para seus arquivos CSS e JavaScript.

### Executar o Servidor PHP
Em outro terminal, execute:

```bash
php artisan serve
```

Isso vai iniciar o servidor em `http://localhost:8000`.

---

## 📋 **Verificar se Tudo está OK**

### Testar a Aplicação
```bash
php artisan tinker
```
Isso abre um console interativo onde você pode testar a aplicação.

### Executar Testes
```bash
./vendor/bin/pest
```

---

## 🗄️ **Configuração do Banco de Dados**

Por padrão, o projeto está configurado para usar **SQLite**. Se você quiser usar outro banco (MySQL, PostgreSQL, etc), edite o arquivo `.env`:

### Para MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

Depois execute as migrações:
```bash
php artisan migrate
```

---

## 🔑 **Resumo dos Passos Principais**

| Passo | Comando | Descrição |
|-------|---------|-----------|
| 1 | `composer install` | Instalar dependências PHP |
| 2 | `copy .env.example .env` | Criar arquivo de configuração |
| 3 | `php artisan key:generate` | Gerar chave da app |
| 4 | `php artisan migrate --force` | Criar tabelas no BD |
| 5 | `npm install` | Instalar dependências frontend |
| 6 | `npm run build` | Compilar assets |

---

## ✅ **Pronto!**

Agora você pode acessar a aplicação em `http://localhost:8000` (após executar `php artisan serve`).

Bom desenvolvimento! 🎉

