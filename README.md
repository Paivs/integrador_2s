# Projeto Integrador

Base simples para projetos PHP com Apache e MySQL 8.4. Cada grupo deve criar um fork deste repositório e desenvolver sua aplicação dentro de `app/`.

## Requisitos

- Docker com o comando `docker compose`
- Git

## Executar no computador

1. Copie o arquivo de configuração:

   ```bash
   cp .env.example .env
   ```

2. Inicie os containers:

   ```bash
   docker compose up -d --build
   ```

3. Acesse a aplicação em <http://localhost:8080>.

4. Confira o estado:

   ```bash
   docker compose ps
   ```

O código da aplicação fica em `app/`, começando por `app/index.php`. Toda página PHP deve carregar `app/init.php`. Esse arquivo inicia a sessão, abre a conexão PDO em `$pdo` e disponibiliza as funções do CRUD.

Os arquivos de banco ficam em `app/banco/`:

- `database.php`: cria a conexão usando as variáveis do ambiente;
- `crud.php`: oferece as funções `create`, `readAll`, `read`, `update` e `delete`.

O script SQL inicial fica em `database/schema.sql` e é incorporado à imagem do banco durante o build.

A extensão `pdo_mysql` já vem instalada e habilitada na imagem PHP do projeto.

O arquivo `compose.override.yaml` publica a porta apenas no computador do aluno. O Coolify utiliza somente `compose.yaml` e expõe a aplicação pelo domínio configurado no painel.

> O arquivo `database/schema.sql` só é executado quando o volume do banco é criado pela primeira vez.

As senhas do banco também são definidas na primeira criação do volume. Se elas forem alteradas posteriormente no `.env`, será necessário restaurar os valores anteriores ou recriar o banco. O comando abaixo apaga todos os dados locais do banco:

```bash
docker compose down -v
docker compose up -d --build
```

Volumes criados anteriormente com MariaDB também devem ser removidos antes de iniciar o MySQL, pois os arquivos internos dos dois bancos não são compatíveis.

## Áreas do CarCare

O sistema possui dois tipos de acesso:

- **cliente:** cadastra os próprios veículos, solicita uma manutenção e acompanha o status;
- **funcionário:** consulta todos os clientes, cadastra serviços e peças e atualiza o status das manutenções.

Toda solicitação criada pelo cliente recebe automaticamente o status `Solicitado`.
Somente um funcionário pode alterar para `Agendado`, `Em andamento`,
`Concluído` ou `Cancelado`.

### Primeiro funcionário

Por segurança, nenhuma senha é salva no GitHub. Depois de preparar o banco,
acesse `http://localhost:8080/cadastro-funcionario.php` e crie a primeira
conta da oficina. Essa página deixa de aceitar cadastros assim que o primeiro
funcionário é criado.

As contas criadas pela opção **Criar conta** do login são sempre clientes.

## Atualizar um banco que já existe

Se o projeto já estava funcionando antes da separação entre cliente e funcionário,
não apague o volume. Execute a migração uma única vez:

```powershell
docker compose cp .\database\migracao-perfis.sql db:/tmp/migracao-perfis.sql
docker compose exec db sh -c 'mysql --default-character-set=utf8mb4 -uroot -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE" < /tmp/migracao-perfis.sql'
```

Depois, atualize a página no navegador. A migração preserva os veículos e as
manutenções existentes.

## Comandos úteis

```bash
docker compose up -d --build  # inicia o ambiente
docker compose logs -f        # acompanha os logs
docker compose ps             # mostra os containers
docker compose down           # encerra o ambiente
```

## Organização da turma

- Um fork por grupo.
- Alterações devem ser enviadas para a branch `main` do fork.
- Nunca envie o arquivo `.env` ao Git.
- Cada fork é cadastrado como uma aplicação independente no Coolify.

Consulte [docs/alunos.md](docs/alunos.md) para o fluxo de trabalho e [docs/deploy-coolify.md](docs/deploy-coolify.md) para a publicação.
