# CakeGRID

## Instalação

1. Baixe o código

2. Atualize as dependências rodando o comando `composer install`

3. Mude as permissões dos diretórios logs e temp:

`$ setfacl -d -m u::rwX,g::rwX,o::rwX -R logs/`
`$ setfacl -d -m u::rwX,g::rwX,o::rwX -R tmp/`

4. Configure o banco de dados no arquivo `app/config/app.php`.

3. Execute o `bin/cake bake instalacao seu_email sua_senha`, este comando irá configurar o usuário administrador.
