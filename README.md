# CodeIgniter 4 - Sistema de Gestão de Vagas de Emprego


## Sobre
Sistema de Gestão de Vagas de Emprego criado para o Teste para candidatos à vaga de Desenvolvedor PHP Pleno.

- Livremente Inspirado em: https://github.com/dotlib/teste-desenvolvedor-php/blob/master/teste-pleno.md
- Não me candidatei à vaga. Apenas resolvi implemntar o desafio em Codeigniter 4 a fim de refinar meu conhecimentos acerca do Framework. 


## Instalação

`composer create-project luciocodeigniter/ci4-vacancies-test-dev` 


## Configurando


### 1. Configurando o arquivo .env
Renomeie o arquivo env-exemple para `.env`

### 2. Defina o ambiente de desenvolvimento
```sh
CI_ENVIRONMENT = development
```

### 3. Defina sua URL base e remova o `index` da url
```sh
app.baseURL = 'http://vacancies-test-dev.test/' # Utilizado Laragon que já cria o Virtualhost e adiciona no arquivo de hosts
app.indexPage = ''
```


### 4. Crie seu banco de dados e adicione as informações do banco no arquivo .env
```sh
database.default.hostname = localhost
database.default.database = vacancies-test-dev
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
```

### 4. Crie as tabelas no banco de dados rodando o seguinte comando a partir da raiz do projeto
```sh
php spark migrate
```

### 5. Semeie os dados iniciais rodando o seguinte comando a partir da raiz do projeto
```sh
php spark db:seed InitialDataSeeder


Com o apache e o MySql iniciados no Laragon, acesse a URL no navegador:
http://vacancies-test-dev.test/

Credenciais admin:

E-mail: admin@admin.com
Senha: 123456
```


## Requisitos do servidor

É necessário PHP versão 8.0 ou superior, com as seguintes extensões instaladas:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) se você planeja usar a biblioteca HTTP\CURLRequest

Além disso, certifique-se de que as seguintes extensões estejam habilitadas em seu PHP:

- json (habilitado por padrão - não desligue)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (ativado por padrão - não desligue)
