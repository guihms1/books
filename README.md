# 🚀 Aplicação Laravel 11 com Docker e MySQL

## 📋 Descrição

Esta é uma aplicação desenvolvida com **Laravel 11** e **PHP 8.2**, utilizando o servidor **Apache**. O banco de dados utilizado é o **MySQL**.

O projeto é configurado para ser executado em containers **Docker**, facilitando o ambiente de desenvolvimento com o uso do **Docker Compose**.

---

## 🛠️ Pré-requisitos

Antes de iniciar a aplicação, certifique-se de ter os seguintes softwares instalados em sua máquina:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

---

## 🚀 Subindo a aplicação

### 1. Configurar o ambiente

Antes de iniciar os containers, é necessário configurar o arquivo de ambiente `.env`:

- Faça uma cópia do arquivo `.env.example` e renomeie-o para `.env`:

```bash
cp .env.example .env
```

---

### 2. Construir e iniciar os containers

Com o **Docker Compose**, você pode construir e iniciar os containers da aplicação com um único comando:

```bash
docker compose -f .docker/dev/docker-compose.yml up --build -d
```

### Explicação do comando:

- **`docker compose`**: Comando para usar o Docker Compose.
- **`-f .docker/dev/docker-compose.yml`**: Especifica o caminho do arquivo `docker-compose.yml`.
- **`--build`**: Reconstrói as imagens dos containers.
- **`-d`**: Executa os containers em modo _detached_ (em segundo plano).

---

## 🔧 Estrutura dos Serviços

A aplicação utiliza os seguintes serviços:

| Serviço        | Descrição                            | Porta (Acesso externo) |
|----------------|--------------------------------------|------------------------|
| **PHP-Apache** | Container principal com PHP 8.2 e Apache | `localhost:8080`       |
| **MySQL**      | Banco de dados MySQL                | `localhost:3333`       |

---

## 🐳 Comandos Úteis

- **Parar os containers**:
  ```bash
  docker compose -f .docker/dev/docker-compose.yml down
  ```

- **Ver os logs dos containers**:
  ```bash
  docker compose -f .docker/dev/docker-compose.yml logs -f
  ```

---

## 🌐 Acessando a Aplicação

Após subir os containers, a aplicação estará disponível em:

- **Frontend (Laravel)**: [http://localhost:8080](http://localhost:8080)
- **Banco de Dados (MySQL)**: Porta **3333**

---

## 📦 Tecnologias Utilizadas

- **PHP 8.2** com Apache
- **Laravel 11**
- **MySQL**
- **Docker** e **Docker Compose**

---

## 🧪 Testando a Aplicação

Para rodar os testes, utilize o comando:

```bash
docker exec -it books-app php artisan test
```
