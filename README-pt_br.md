# Email Processor API

Este projeto consiste em uma API RESTful desenvolvida em Laravel para processar, armazenar e manipular conteúdo de e-mails. Ele extrai o corpo dos e-mails em texto simples e armazena os dados relevantes em um banco de dados MySQL. A API possui funcionalidades para listar, criar, editar e deletar registros de e-mails processados.

## Funcionalidades

- Listar todos os e-mails processados
- Criar um novo e-mail processado
- Atualizar os dados de um e-mail existente
- Excluir (soft delete) um e-mail processado
- Processamento do conteúdo dos e-mails (extração de corpo do e-mail em texto puro)

## Pré-requisitos

Antes de rodar o projeto localmente, você precisará ter as seguintes ferramentas instaladas em sua máquina:

- [PHP 8.x](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://dev.mysql.com/downloads/installer/)
- [Node.js](https://nodejs.org/en/) e [npm](https://www.npmjs.com/)
- [Laravel 11.x](https://laravel.com/docs/11.x)

## Passos para rodar o projeto localmente

### 1. Clonar o repositório

Abra o terminal e execute o comando:

```bash
git clone https://github.com/humbertobz/email-processor-api.git
```

Em seguida, entre no diretório do projeto:

```bash
cd email-processor-api
```

### 2. Instalar as dependências do projeto

No diretório do projeto, execute o comando para instalar as dependências do PHP usando o Composer:

```bash
composer install
```

### 3. Configurar o banco de dados

Crie um banco de dados MySQL e configure as credenciais no arquivo .env. Renomeie o arquivo .env.example para .env:

```bash
cp .env.example .env
```

Edite o arquivo .env e configure as seguintes variáveis para refletir seu ambiente local:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_seu_banco_de_dados
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Gerar a chave da aplicação

Execute o seguinte comando para gerar a chave do Laravel:

```bash
php artisan key:generate
```

### 5. Migrar o banco de dados

Rode as migrações para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

### 6. Rodar o servidor local

Agora, para rodar o servidor de desenvolvimento, execute o seguinte comando:

```bash
php artisan serve
```

O projeto estará disponível em http://localhost:8000.

### 7. (Opcional) Configurar agendamento para processar e-mails periodicamente

Se você desejar agendar o processamento de e-mails periodicamente, configure o cron no seu sistema para rodar o comando abaixo:

```bash
* * * * * cd /caminho/para/projeto && php artisan schedule:run >> /dev/null 2>&1
```

Isso garante que o comando agendado será executado automaticamente conforme configurado no Kernel.php.

### Endpoints da API

Aqui estão os principais endpoints da API:

| Método HTTP | Endpoint | Descrição |
| ----------- | -------- | --------- |
| `GET` | `/api/emails` | Retorna todos os e-mails processados |
| `POST` | `/api/emails` | Cria um novo e-mail processado |
| `GET` | `/api/emails/{id}` | Retorna um e-mail processado pelo ID |
| `PUT` | `/api/emails/{id}` | Atualiza os dados de um e-mail existente |
| `DELETE` | `/api/emails/{id}` | Exclui (soft delete) um e-mail processado |

### Exemplo de Requisição POST para criar um novo e-mail

```bash
curl -X POST http://localhost:8000/api/emails \
-H "Content-Type: application/json" \
-d '{
    "affiliate_id": 123,
    "envelope": "envelope_data",
    "from": "sender@example.com",
    "subject": "Test Subject",
    "email": "raw_email_payload",
    "to": "recipient@example.com",
    "timestamp": 1628076800
}'
```
