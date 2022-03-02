## Autenticando na api

Envie uma requisição POST para o endpoint `http://ci4-vacancies-test-dev.test/api/login` com credencias válidas e veja resposta:

```sh

{
    "message": "Login Succesful",
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJJc3N1ZXIgb2YgdGhlIEpXVCIsImF1ZCI6IkF1ZGllbmNlIHRoYXQgdGhlIEpXVCIsInN1YiI6IlN1YmplY3Qgb2YgdGhlIEpXVCIsImlhdCI6MTY0NjI0OTE4MywiZXhwIjoxNjQ2MjUyNzgzLCJlbWFpbCI6ImF0b3JwQHdlbGNoLmluZm8ifQ.d3XvXz9N5W_TJgw9cvf5B0LPOGTiaWhmvEwZ2KQoQao",
    "token_type": "bearer"
}


```


## Criando uma conta

Envie uma requisição ` POST ` para o endpoint `http://ci4-vacancies-test-dev.test/api/register` com credencias válidas e veja resposta:

```sh

{
    "status": 201,
    "message": "Account created successfully! We have sent the link to your email email@email.com so that you can activate your account."
}


```

## Recuperando user

Envie uma requisição ` GET ` para o endpoint `http://ci4-vacancies-test-dev.test/api/user`


## Rotas do admin

### Candidates
Para listar os cadidatos, envie uma requisição ` GET ` para o endpoint abaixo:

- http://ci4-vacancies-test-dev.test/api/cadidates


Para recuperar um cadidato específico, envie uma requisição ` GET ` para o endpoint abaixo, informando o ID do do candidato:

- http://ci4-vacancies-test-dev.test/api/cadidates/1


Para criar um cadidato, envie uma requisição ``` POST ``` para o endpoint abaixo:

- http://ci4-vacancies-test-dev.test/api/cadidates

```sh 

Campos obrigatórios:

string name
string email
string password
string password_confirmation

```

Para atualizar um cadidato, envie uma requisição ``` PUT/PATCH ``` para o endpoint abaixo, informando o ID:

- http://ci4-vacancies-test-dev.test/api/cadidates/1


Para excluir um cadidato, envie uma requisição ``` DELETE ``` para o endpoint abaixo, informando o ID:

- http://ci4-vacancies-test-dev.test/api/cadidates/1


### Vacancies

Para listar as vagas de emprego, envie uma requisição ``` GET ``` para o endpoint abaixo:

- http://ci4-vacancies-test-dev.test/api/vacancies


Para recuperar uma vaga de emprego específica, envie uma requisição ``` GET ``` para o endpoint abaixo:

- http://ci4-vacancies-test-dev.test/api/vacancies/1


Para criar uma vaga de emprego, envie uma requisição ``` POST ``` para o endpoint abaixo:

- http://ci4-vacancies-test-dev.test/api/vacancies

```sh 

Campos obrigatórios:

string title
string description
string type - FR (Freelancer) ou CLT (Pessoa Física) ou PJ (Pessoa Jurídica)
string is_paused (0,1)

```

Para atualizar uma vaga de emprego, envie uma requisição ``` PUT/PATCH ``` para o endpoint abaixo, informando o ID:

- http://ci4-vacancies-test-dev.test/api/vacancies/1


Para excluir uma vaga de emprego, envie uma requisição ``` DELETE ``` para o endpoint abaixo, informando o ID:

- http://ci4-vacancies-test-dev.test/api/vacancies/1


