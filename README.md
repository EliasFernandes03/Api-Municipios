# 🌍 API de Municípios - Laravel + Docker + WSL2

Este projeto fornece uma API em Laravel para listagem de municípios brasileiros por UF (estado), executando em ambiente Docker e WSL2.

---

## ✅ Requisitos

Certifique-se de ter as seguintes ferramentas instaladas e funcionando corretamente:

- [WSL2 (Windows Subsystem for Linux)](https://learn.microsoft.com/pt-br/windows/wsl/install)
- [Docker Desktop](https://www.docker.com/products/docker-desktop)
- [Docker Compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com)

> ⚠️ O Docker Desktop deve estar configurado para usar o WSL2.

---

## 🚀 Instruções passo a passo

### 1. Clone o repositório

Abra o terminal e execute:

```bash
git clone https://github.com/seu-usuario/api-municipios.git
cd api-municipios

```

### 2. Copie o arquivo de variáveis de ambiente

O Laravel utiliza um arquivo `.env` para definir variáveis de ambiente. Copie o exemplo fornecido e cole no .env para criar sua própria configuração:

```bash
.env.example .env
```

### 3. Suba os containers com Docker Compose 

```bash
docker compose up -d --build
```

### 4.  Acesse o container PHP

```bash
docker exec -it setup-laravel_php bash
```
### 5. Instale as dependências PHP (Laravel)

```bash
composer install
```

### 5. Gere a chave da aplicação

```bash
php artisan key:generate
``` 

##  Rotas: Listagem de Cidades

###  `GET /api/cities`

Retorna uma lista paginada de cidades. Permite filtrar por UF (Unidade Federativa).

---

###  Parâmetros de Query

| Nome       | Tipo     | Obrigatório | Descrição                                                                 |
|------------|----------|-------------|---------------------------------------------------------------------------|
| `uf`       | `string` | Sim         | Sigla da Unidade Federativa (Ex: `SP`, `RJ`, `MG`). Deve ter exatamente 2 letras e ser uma UF válida do Brasil. |
| `page`     | `int`    | Não         | Número da página que deseja consultar. Deve ser maior ou igual a 1.      |
| `per_page` | `int`    | Não         | Quantidade de registros por página (mínimo 1, máximo 100).               |

---

###  Exemplo de Requisição

```http
GET /api/cities?uf=SP&page=1&per_page=10
```

###  `GET /consulta-municipios`

Renderiza uma página web com interface para consulta de municípios brasileiros por UF (estado).

---

###  Descrição

Esta rota exibe uma interface gráfica (frontend) onde o usuário pode:

- Selecionar uma UF (estado brasileiro)
- Submeter uma requisição para buscar os municípios da UF escolhida


---

###  Tipo de resposta

A resposta dessa rota é uma **página HTML** (view Blade Laravel).

---

###  View retornada

```blade
resources/views/cities.blade.php
```

##  Executando Testes (Unitários e de Integração)

O projeto possui testes automatizados para garantir a qualidade do código, tanto para validações unitárias quanto para o comportamento completo da aplicação (testes de integração).

---

###  Pré-requisitos

- Containers já devem estar em execução:
  
```bash
docker compose up -d
```

###  Executar os testes


### Acesse o container PHP

```bash
docker exec -it setup-laravel_php bash
```

### Execute os testes unitários

```bash
php artisan test tests/Unit
```

### Execute os testes de integração

```bash
php artisan test tests/Feature
```

##  Deploy em Produção

O deploy desta aplicação foi realizado utilizando a plataforma [Render](https://render.com), que permite a execução de aplicações Laravel com suporte a Docker.

---

###  URL de Produção

Você pode acessar a API publicada na seguinte URL:
```
https://api-municipios.onrender.com/consulta-municipios
```
