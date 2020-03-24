<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## Introdução

Este projeto o ajudará a montar um ambiente de desenvolvimento **[Laravel](https://laravel.com/)** utilizando o **Docker**. O mesmo contém os principios básicos para produzir um projeto **[Laravel](https://laravel.com/)** além de flexibilizar a criação de *Modules* e o padrão *Service* *and* *Repositorie*.

## Instalação

Para começar a utiliza-lo é necessário realizar um [clone](https://github.com/VianaGerson/laravel6-docker-repository.git) em sua máquina. Feito esse procedimento irá aparecer uma pasta com o nome `laravel6-docker-repository/`. Entre dentro do diretorio *backend* `cd laravel6-docker-repository/backend` e execute: 

```
cp .env.example .env
```

Logo em seguida saia da pasta backend para poder levantar os containers `cd ../`. Feito isso execute:

```
docker-compose up --build -d
```

Após executar este comando você estará subindo um ambiente de desenvolvimento com as seguintes ferramentas:

| Ferramenta            | Versão   |
| ----------------------| -------- |
| PHP                   | ^7.2     |
| Postgres              | 11.7     |
| Nginx                 | Alpine   |


## Acessando ambiente de desenvolvimento

Quando certificar-se que todos os containers subiram corretamente, é necessário entrar dentro da máquina que o docker criou. Para realizar tal tarefa é preciso executar o seguinte comando:

``` 
docker-compose exec backend bash 
```

Esse comando fará com que você entre dentro do ambiente de desenvolvimento criado, possibilitando-o ter acesso aos comandos que o composer irá disponibilizar. Como é um projeto novo, é requisito executar o comando abaixo para atualizar todas as dependências do projeto.

```
composer update
```

## Liberar permissão de escrita

É necessário executar os comandos abaixo para poder ter acesso de leitura e escrita nos arquivos do projeto. Isso é obrigatório fazer, porque o docker por padrão irá procurar um usuário root dentro do container, então você acessa o container como root e executa os seguintes comandos.
```
chown -Rf 1000:1000 .
chown -Rf www-data:www-data storage/
```
Apartir de agora você irá acessar o container com o comando:
```
docker-compose exec -u user backend bash
```

## Configurando autenticação
O projeto já vem com o modulo de Auth implementado, basta configurá-lo seguindo as instruções abaixo:

* Migrar a estrutura de dados do passport
```
php artisan migrate
```
* Ao implantar o Passport nos servidores de produção pela primeira vez, você provavelmente precisará executar o comando `passport:keys`. Este comando gera as chaves de criptografia que o Passport precisa para gerar o token de acesso. As chaves geradas geralmente não são mantidas no controle de origem. OBS: para executar este comando você tem que acessar o container como root.
```
php artisan passport:keys
```
* Antes que seu aplicativo possa emitir tokens por meio da concessão de senha, você precisará criar um cliente de concessão de senha, para isso execute o seguinte comando.
```
php artisan passport:client --password
```
* Depois de criar um cliente de concessão de senha, você pode solicitar um token de acesso emitindo uma solicitação `POST` para a rota `oauth\token` com o endereço de e-mail e a senha do usuário e o provedor de autenticação. Lembre-se de que essa rota já está registrada pelo método `Passport::routes`, não sendo necessário defini-la manualmente. Se o pedido for bem sucedida, você receberá um e na resposta JSON com `access_token` e `refresh_token` a partir do servidor

```
{
	"username": <username>,
	"password": <password>,
	"grant_type" : "password",
	"client_id": <client_id>,
	"client_secret" : <cleint_secret>,
	"scope": "",
	"provider": <provider>
}
```

## Testando Projeto

Para realizar o teste se o projeto realmente está rodando abra o ***browser*** e acesse: [localhost:8080](localhost:8080)

## Criando Primeiro Modulo

Supondo que você está dentro da pasta backend, execute `cd Modules/` isso o levará para o diretório de modulos e o habilitará a criar suas aplicações modulares. Para visualizar todos os comandos referentes aos  modulos basta digitar

```
php artisan 
```

![](https://i.imgur.com/GJ4BntP.png)


Isso irá lhe mostrar a lista de comandos para se trabalhar utilizando modulos. Para criar seu primeiro modulo execute:

```
php artisan module:make NomeDoModulo
```

Entre dentre da pasta **NomeDoModulo** e poderá trabalhar como um projeto que pode ser facilmente integrado com outros  modulos ou caso preferir pode trabalhar como um projeto a parte.

## Criando Service and Repositorie

Para criar o padrão *Service and Repository* execute o seguinte comando:
> Nota: É necessário estar no diretório ***app*** para executar os comandos do ***artisan***

```
php artisan module:make-repository NomeRepository -s NomeModelo NomeDoModulo
```

Executando esse comando você irá criar um repositorio com base no modelo que você já tenha previamente criado dentro do modulo, e criará em seguida o serviço referente ao seu repositorio. Vale ressaltar que tanto o *repository* quanto o *service* podem ser criados de forma separada, os comando estão na lista que a figura acima mostra. Para visualizar os arquivos criados digite `cd /Modules/NomeDoModulo`. Logo verá que foi criado um pasta chamada **Repositories** e outra **Services**.

## Observações 

Para realizar os prcodimentosé necessário ter o [Docker](https://docs.docker.com/install/) e [Docker Composer](https://docs.docker.com/compose/install/) instalado em sua máquina.

## Considerações Finais

Este tutorial teve como principio descrever como colocar no ar um ambiente de desenvolvimento Laravel o mais rápido possivel, vale ressaltar que não foi esclarecido comandos, tecnologias ou afins porque não era o objetivo do mesmo.

    
## Links utilizados como base
    
Modulos : [laravel-modules](https://medium.com/@destinyajax/how-to-build-modular-applications-in-laravel-the-plug-n-play-approach-part-1-13a87f7de06)
              
Repositorios: [repository-patern](https://blog.schoolofnet.com/trabalhando-com-repository-no-laravel/)
        
Authenticação: [auth-guards](https://pusher.com/tutorials/multiple-authentication-guards-laravel)

```

