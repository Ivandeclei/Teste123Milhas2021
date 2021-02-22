# Teste 123Milhas

O Teste foi realizado utilizando o framework laravel.
O objetivo do teste é criar uma API  que realize a consulta de voos em uma outra API e realizar o tratamento dos dados .


## Executar o projeto local

#### passo 1 
Realizar o clone do projeto

```git clone https://github.com/Ivandeclei/123Milhas.git```

#### passo 2 
Instalar as dependencias do projeto
entrar na raiz do projeto  e executar o comando 

```composer install```


#### passo 3 
Criar arquivo ```.env```.

Na Raiz do projeto haverá um arquivo chamado ``` .env.example ``` é necessário criar um novo arquivo chamado ```.env``` na raiz do projeto. 

Apos a criação é necessário copiar o conteudo  do arquivo  ```.env.example ``` para o```.env```

#### passo 4 
Executar o projeto

Para rodar o projeto é necessario executar o seguinte comando no CMD .

1º entre na raiz do projeto
2º execute o comando 
```[ php artisan serve --port 8080 ]```

OBS: Se houver alteração da porta ```8080```  para outra porta ,  é necessário alterar no arquivo ```swagger.php ``` que esta localizado no seguinte local ```swagger\swagger.php``` e alterar na ```linha 8``` o numero da porta

3º Abrir o navegador e digitar ```localhost:8080 ```
será aberto a Interface do Swagger para realizar os testes


## Documentação 
A documentação e criada dinamicamente usando  Annotation no proprio codigo se for inserido uma nova Annotation é necessario executar o seguinte comando a raiz do projeto.


```./vendor/bin/openapi --format json --output ./public/swagger/swagger.json ./swagger/swagger.php app```

## Rotas

Para acessar a rota de acesso aos voos é necessário copiar o link abaixo e colar no navegador ou cliente de acesso a APIs.
``` http://localhost:[Porta]/api/flights```

OBS: [Porta] deve ser colocado a mesma que foi escolhida no passo 4. 


## Ordenação dos grupos de voos

para realizar a ordenação direto na Rota de API sem utilizar o swegger é necessário adicionar o parametro ```orderBy``` na rota conforme exemplo

``` http://localhost:8080/api/flights?orderBy=DESC```

Valores Validos
```ASC``` e  ```DESC``` 
