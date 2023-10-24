## News Aggregator API

News Aggregator API project aims to provide an API endpoint to retrieve news articles from different sources (NewsAPI, The Guardian, New York Times).

## How to install

1. Clone the repository.
2. Run ```cp .env.example .env``` then ```composer install``` and when it's done run ```php artisan key:generate```
3. Head over to NewsAPI, The Guardian and NYT API to register and grab API keys.
NOTE: please make sure to activate the nyt top headlines API.
4. Inside your .env fill the following values with your API keys:
```sh
NEWS_API_KEY="PUT YOUR API KEY HERE"
GUARDIAN_API_KEY="PUT YOUR API KEY HERE"
NYT_API_KEY="PUT YOUR API KEY HERE"
```
5. Run ```php artisan migrate```
6. You're done. you can run ```php artisan serve``` and use the API.

## Features

1. Fetches news articles from different sources.
2. Stores them in a local database for easy retrieval.
3. Filtering and pagination of news articles.
4. Updates news regularly (every 5 mins).

Fetching articles works as follows:
1. refreshArticles() function in the Article model is called every 5 minutes to refresh the articles (Fetch from the data sources and store in the database).
2. Filtering, searching, paginating and retrieving the articles is done in ArticleController.

## How the fethcing works

Every five minutes there will be a call to the refreshArticle method (using the scheduler registered in the Kernal). the refreshArticle method will send requests to each news server and pass each article to the class responsible for handling that type (see classes directory in App\Classes for more information). after that's done, the results will be saved to the database.
