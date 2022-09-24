# CriptoApi



![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![PhpStorm](https://img.shields.io/badge/phpstorm-143?style=for-the-badge&logo=phpstorm&logoColor=white&color=purple&labelColor=darkorchid)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=black)

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)


## Sobre

A CriptoAPI é um projeto que facilita a visualização de parametrização dos valores de cripto moedas, dando ao usuário a chance de busca por valores atuais (tempo real) ou buscando um histórico de preços de moedas específicas.

Atualmente a CriptoAPI realiza o rastreamento das seguintes moedas, preços atuais e com possibilidade de verificar preços por data:

+ Bitcoin
+ Dacxi
+ Ethereum
+ ATOM

## Tecnologias Utilizadas
As tecnologias que compoem a CriptoAPI são:

+ PHP 8
+ MySQL
+ Docker
+ Laravel

## Instalando o Projeto

Para iniciar a instalação do projeto realize o clone com o comando:

> Escolha a forma mais conveniente de clone por HTTPS ou SSH
~~~bash
# SSH Clone
git clone git@github.com:RuanSalles/CriptoAPI.git

# HTTPS Clone
git clone https://github.com/RuanSalles/CriptoAPI.git
~~~

Acesse a pasta do projeto:

~~~bash
cd CriptoApi
~~~

Em seguida copie os arquivos docker-compose e env para realizar a devida configurações das variáveis de ambiente e containers docker necessários para executar a aplicação.

~~~bash
# Copia do docker-compose do projeto
cp docker-compose.example.yml docker-compose.yml

#Copia do .env do projeto com as configurações de variáveis de ambiente
cp .env.example .env
~~~

Posterior ha copia dos arquivos acima, poderá iniciar o projeto com o comando:

~~~bash
#Iniciando Docker
docker-compose up -d
~~~

Facilitando para build do projeto, há implementação de arquivo makefile, que executará comandos diretamente nos containers realizando a instalação do composer, migrations entre outros, então execute:
~~~bash
make init
~~~
>Qualquer dúvida na raiz do projeto poderá encontrar o makefile e verificar as opções disponíveis.

Após finalização do processo do comando acima, já poderá acessar o navegador no localhost para executar a aplicação:

~~~text
http://localhost:8080
~~~

### Rotas

A seguir iremos listar os endpoints e suas respectivas rotas:

> Todas as rotas da CriptoApi contém o prefixo **coins** então atende-se no padrão de utilização:

#### 1. Listagem de moedas
Listagem de todas as moedas que são rastreadas pela CriptoApi:
~~~text
/api/coins/list
~~~

Exemplo de retorno:

~~~json
/* url: /api/coins/list */
{
   
   "status":"success",
   "data":[
      {
         "id_name":"dacxi",
         "name":"Dacxi",
         "symbol":"dacxi"
      },
      {
         "id_name":"ethereum",
         "name":"Ethereum",
         "symbol":"eth"
      },
      {
         "id_name":"bitcoin",
         "name":"Bitcoin",
         "symbol":"btc"
      },
      {
         "id_name":"pstake-staked-atom",
         "name":"pSTAKE Staked ATOM",
         "symbol":"stkatom"
      }
   ]
}
~~~

#### 2. Pesquisa por Moeda

Você poderá pesquisar através deste endpoint usando qualquer dos **ids** existentes no payload do entpoint acima:

~~~text
/api/coins/{coin}
~~~

Exemplo de retorno:

~~~json
/* url: /api/coins/bitcoin */
{
   "status":"success",
   "data":{
      "coin_data":{
         "id":"bitcoin",
         "name":"Bitcoin",
         "symbol":"btc"
      },
      "current_price":{
         "aed":69590,
         "ars":2756393,
         "aud":28935,
         "bch":158.355,
         "bdt":1965651,
         "bhd":7144.67,
         "bmd":18945.91,
         "bnb":68.991,
         "brl":99745,
         "btc":1,
         "cad":25746,
         "chf":18587.36,
         "clp":18011160,
         "cny":135054,
         "czk":481264,
         "dkk":145374,
         "dot":2977,
         "eos":15684,
         "eth":14.317582,
         "eur":19552.03,
         "gbp":17448.01,
         "hkd":148718,
         "huf":7941709,
         "idr":286317472,
         "ils":66485,
         "inr":1539266,
         "jpy":2716399,
         "krw":26955486,
         "kwd":5873.73,
         "lkr":6863569,
         "ltc":346.953,
         "mmk":40037666,
         "mxn":382700,
         "myr":86744,
         "ngn":8284032,
         "nok":201716,
         "nzd":32998,
         "php":1113072,
         "pkr":4561416,
         "pln":92765,
         "rub":1096495,
         "sar":71279,
         "sek":214053,
         "sgd":27091,
         "thb":710851,
         "try":348902,
         "twd":602575,
         "uah":704128,
         "usd":18945.91,
         "vef":1897.05,
         "vnd":449221440,
         "xag":1003.6,
         "xau":11.52,
         "xdr":13485.28,
         "xlm":158906,
         "xrp":38576,
         "yfi":2.269222,
         "zar":339629,
         "bits":999508,
         "link":2461,
         "sats":99950809
      }
   }
}
~~~

#### 3. Histórico de Cotações

Você poderá verificar o valor exato de moedas específicas baseado na data e hora de sua escolha:

~~~text
/api/coins/history/{coin}?date=xxxx-xx-xx&time=xx:xx:xx
~~~
>Os parâmetros **coin e date** são obrigatórios, enquanto o **time** é opcional

Exemplo de retorno:

~~~json
/* url: /api/coins/history/ethereum?date=2022-09-24&time=20:32:00 */
{

  "status": "success",
  "data": {
    "coin": {
      "id": "ethereum",
      "name": "Ethereum",
      "symbol": "eth"
    },
    "current_price": {
      "aed": 4920.2,
      "ars": 194884,
      "aud": 2045.75,
      "bch": 11.079663,
      "bdt": 138976,
      "bhd": 505.15,
      "bmd": 1339.52,
      "bnb": 4.815927,
      "brl": 7052.22,
      "btc": 0.07012815,
      "cad": 1820.34,
      "chf": 1314.17,
      "clp": 1273434,
      "cny": 9548.66,
      "czk": 34027,
      "dkk": 10278.29,
      "dot": 208.579,
      "eos": 1097,
      "eth": 1,
      "eur": 1382.38,
      "gbp": 1233.62,
      "hkd": 10514.71,
      "huf": 561499,
      "idr": 20243355,
      "ils": 4700.69,
      "inr": 108830,
      "jpy": 192056,
      "krw": 1905820,
      "kwd": 415.29,
      "lkr": 485271,
      "ltc": 24.302545,
      "mmk": 2830762,
      "mxn": 27058,
      "myr": 6133.01,
      "ngn": 585702,
      "nok": 14261.81,
      "nzd": 2333.05,
      "php": 78697,
      "pkr": 322503,
      "pln": 6558.73,
      "rub": 77525,
      "sar": 5039.6,
      "sek": 15134.06,
      "sgd": 1915.42,
      "thb": 50259,
      "try": 24668,
      "twd": 42604,
      "uah": 49784,
      "usd": 1339.52,
      "vef": 134.13,
      "vnd": 31761070,
      "xag": 70.96,
      "xau": 0.814845,
      "xdr": 953.44,
      "xlm": 11104,
      "xrp": 2682,
      "yfi": 0.15930244,
      "zar": 24013,
      "bits": 70128,
      "link": 171.786,
      "sats": 7012815
    }
  }
}
~~~



