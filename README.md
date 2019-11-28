# CakeGRID

## Instalação

1. Baixe o código

2. Atualize as dependências rodando o comando?
```sh
$ composer install
```

3. Se estiver usando LINUX, mude as permissões dos diretórios logs e temp:

```sh
$ setfacl -d -m u::rwX,g::rwX,o::rwX -R logs/
$ setfacl -d -m u::rwX,g::rwX,o::rwX -R tmp/
```
Este comando irá dar permissões de acesso ao diretório `logs` e `tmp`.

4. Configure `defaultLocale` com o valor `pt_BR`, `defaultTimeZone` com `America/Sao_Paulo` e ainda `SECURITY_SALT` no arquivo `app/config/app.php`.

Você pode copiar do arquivo app.default.php

5. Ainda neste mesmo arquivo configure o banco de dados na tag `Datasources/default`, se necessário criar o banco, acesso o console do mariaDB e digite:

```sh
> CREATE DATABASE cakegrid_bd CHARACTER SET utf8;
> GRANT ALL PRIVILEGES ON cakegrid_bd.* TO cakegrid_us@localhost IDENTIFIED BY 'cakegrid_67' WITH GRANT OPTION;
> FLUSH PRIVILEGES;
```
Esteja a vontade para alterar o nome do banco, senha e usuário, mas lembre-se de fazer o mesmo no arquivo `app/config/app.php`.

Agora rode o migrations para criar as tabelas da aplicação: 
```sh
$ bin/cake migrations migrate
```

se tiver algum problema tente rodar:
```sh
$ bin/cake migrations rollback
```

para verificar o status:
```sh
$ bin/cake migrations status`
```

Ao final desta operação o banco terá a tabela usuários e municipios criadas e ainda a tabela municípios populada com todos os municípios do Brasil.

6. Para terminar a instalação execute o comando abaixo para instalar o usuário Administrador:

```sh
$ bin/cake instalacao seu_email sua_senha
```

```sh
$ bin/cake cache clear_all
```

7. Acesse o link pelo browser, algo como: http://localhost/~seu-usuario/cakegrid
