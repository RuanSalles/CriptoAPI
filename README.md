# CriptoApi



![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![PhpStorm](https://img.shields.io/badge/phpstorm-143?style=for-the-badge&logo=phpstorm&logoColor=white&color=purple&labelColor=darkorchid)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=black)

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)


## About

CriptoAPI is a project that facilitates the visualization of the parameterization of cryptocurrency values, giving the user the chance to search for current values ​​(real time) or searching a price history of specific currencies.

Currently, CriptoAPI tracks the following currencies, current prices and the possibility of checking prices by date:

+ Bitcoin
+ Dacxi
+ Ethereum
+ ATOM

## Technologies Used
The technologies that make up the CryptoAPI are:

+ PHP 8
+ MySQL
+ Docker
+ Laravel

## Test evaluative requirements

Activities | Delivered
-------------------------------------------- | --------------------------------------------
**Required** - Create the API using Laravel | ✅
**Required** - Use the CoinGecko API and store the price of Bitcoin into the database | ✅
**Required** - Host the application on your preferred hosting service | ✅
**Bonus** - Following coin prices: DACXI, ETH, ATOM | ✅
**Bonus** - Automated Tests | ❌
**Bonus** - Docker Orchestration | ✅

Bonus: Endpoint creation that accepts the search by date and time, making the search return more accurate.

## Summary about the application

The docker environment was chosen to create the project, with the WebDevops Ngnix 8.0 image, bringing all the features and benefits of version 8 of PHP to the project. Consequently, MySQL version 5.7 was chosen for the database, also with docker/container image, all project dependencies are properly configured through the docker-compose.yml file.

Regarding to the project choices, Repository patterns are used for all actions related to the database, as well as the Pattern Service to communicate the actions requested by the Controller, handled by the service and returned by the Repository in order to respect good programming practices and clean code.

In order for the database to be properly populated with the history, a routine was implemented through Command and Schedule, so that with the PHP-FPM Supervisor itself, it is possible to run a command that performs the search for all the currencies existing in the database. data and later populate the database. This entire process runs automatically when the docker containers are raised at an interval of 1 (one) minute.

The Deployment of the project was carried out on a Digital Ocean VPS, thinking about better performance and compatibility with the Docker environment, making the application more robust and thinking about its scalability.

The CriptoAPI contains Endpoints that currently allow: List the currencies that can be searched, search the current value of a specific currency, search for the history of the currency value by date and time, in addition to an automated and transparent routine to populate the bank at an interval of 1 (one) minute with the history of all coins in the database.

Any and all questions about the application or requirements can be removed by sending an email to the address: contatoruansales@gmail.com

## Installing the Project

To start installing the project, execute the clone with the command:

> Choose the most convenient way to clone via HTTPS or SSH

~~~bash
# SSH Clone
git clone git@github.com:RuanSalles/CriptoAPI.git

# HTTPS Clone
git clone https://github.com/RuanSalles/CriptoAPI.git
~~~

Access the project folder:

~~~bash
cd CriptoApi
~~~

Then copy the docker-compose and env files to properly configure the environment variables and docker containers needed to run the application.
~~~bash
# Copy of project docker-compose
cp docker-compose.example.yml docker-compose.yml

# Copy project .env with environment variable settings
cp .env.example .env
~~~

After copying the files above, you can start the project with the command:

~~~bash
# Starting Docker
docker-compose up -d
~~~

After downloading, creating and having all the containers standing, you can use the command below to install all the dependencies.

~~~bash
make init
~~~
>If you have any question at the project root, you can find the makefile and check the available options.

>The application automatically runs the searches that populate the database to create a history of the coins, as soon as the project starts, this process will start in the background in a transparent way, so that the time and date functionality can be used must be used in UTC format **(yyyy-mm-dd)**, if you search by time you must use the standard format **(hour:minute:seconds)**.

After finishing the process of the command above, you can now access the browser on localhost to run the application:

~~~text
http://localhost:8080
~~~

### Routes

Below we will list the endpoints and their respective routes:

#### 1. Coin listing
Listing of all coins that are tracked by CriptoApi:
~~~text
/api/coins/list
~~~

Return example:

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

#### 2. Search by Currency

You can search through this endpoint using any of the **ids** in the entpoint payload above:

~~~text
/api/coins/{coin}
~~~

Return example:

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

#### 3. Quote History

You will be able to check the exact value of specific coins based on the date and time of your choice:

> >The application contains an automated routine that fills the database with the current values of the currencies contained in the database, which can be seen in the above mentioned route list.


~~~text
/api/coins/history/{coin}?date=xxxx-xx-xx&time=xx:xx:xx
~~~
>The **coin and date** parameters are required, while the **time** is optional

Return example:

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

## License

This project is under the MIT license.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)