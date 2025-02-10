# 📌 Laravel URL Shortener - Docker

Este projeto é um encurtador de URLs desenvolvido com Laravel, utilizando Docker para gerenciamento de ambiente.

## 🛠️ Tecnologias Utilizadas

- **PHP** (Executado em um container Docker)
- **Laravel** (Framework PHP)
- **MySQL 8.0** (Banco de dados relacional)
- **Redis** (Cache e filas de tarefas)
- **Docker e Docker Compose** (Gerenciamento de containers)

## 🚀 Como Executar o Projeto

### 1️⃣ Pré-requisitos

Antes de iniciar, certifique-se de ter instalado em sua máquina:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### 2️⃣ Clonar o Repositório

```bash
git clone https://github.com/Tjaos/curtUrl.git
cd curtUrl
```

### 3️⃣ Configurar o Arquivo `.env`

Crie um arquivo `.env` na raiz do projeto com as configurações adequadas. Você pode copiar o modelo disponível:

```bash
cp .env.example .env
```

Atualize as variáveis de ambiente do banco de dados no `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=encurtador_url
DB_USERNAME=root
DB_PASSWORD=root
```

### 4️⃣ Construir e Subir os Containers

```bash
docker-compose up -d --build
```

### 5️⃣ Instalar as Dependências do Laravel

Acesse o container da aplicação e instale as dependências:

```bash
docker exec -it laravel-app bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
exit
```

### 6️⃣ Acessar a Aplicação

Agora, a aplicação estará disponível em:

```
http://localhost:8000
```

### 7️⃣ Parar os Containers

Para parar os serviços Docker, utilize o comando:

```bash
docker-compose down
```

## 📂 Estrutura do Projeto

```plaintext
.
├── docker-compose.yml   # Configuração dos serviços Docker
├── Dockerfile           # Configuração do ambiente Laravel/PHP
├── .env.example         # Arquivo de configuração de ambiente
├── app/                 # Código-fonte do Laravel
├── database/            # Migrations e Seeds
├── public/              # Arquivos públicos (CSS, JS, imagens)
└── ...
```

## 🐳 Containers Criados

| Serviço  | Container        | Porta Local |
|----------|------------------|------------|
| Laravel  | laravel-app      | 8000       |
| MySQL    | laravel-mysql    | 3307       |
| Redis    | laravel-redis    | 6379       |

## 📜 Licença

Este projeto está sob a licença MIT. Sinta-se à vontade para modificá-lo e utilizá-lo conforme necessário.

---
Desenvolvido por [Seu Nome](https://github.com/seu-usuario) 🚀

