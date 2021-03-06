# [Opengraph.io php](https://github.com/primeobsession/opengraph-io-php)

Opengraph-io-php package is a wrapper on [opengraph.io](https://www.opengraph.io/) API, especially built for modern **PHP** projects which is using [Composer](https://getcomposer.org) as package and dependency management.

## Getting Started

[OpenGraph.io](https://www.opengraph.io/) client library for PHP.   Given a URL, the client 
will make a HTTP request to OpenGraph.io which will scrape the site for OpenGraph tags.  If tags exist the tags will
be returned to you.  

Often times the appropriate tags will not exist and this is where OpenGraph.io shines.  It will
infer what the OpenGraph tags probably would be an return them to you as ```hybridGraph```.  

The ```hybridGraph``` results will always default to any OpenGraph tags that were found on the page.  If only some tags
were found, or none were, the missing tags will be inferred from the content on the page. 

For most uses, the OpenGraph.io API is free. To get a free forever key, signup at [OpenGraph.io](https://www.opengraph.io/).  

If you end up having very heavy useage, the vast majority of projects will
be totally covered using one of our inexpensive plans.  Dedicated plans are also available upon request.

## Installation
 
This package is in active development and not discoverable by Composer via [Packagist](https://packagist.org). But if you wish to test this package now you have to follow these procedures

1. Clone this repository inside your PHP project. As this project is intended to release as a composer package so you should better have composer initialized into your project and already have a `/vendor` directory inside your project root.
    ```bash
    $ cd <project_root>/vendor
    $ mkdir primeobsession && cd primeobsession
    $ git clone https://github.com/primeobsession/opengraph-io-php.git
    ```
2. Open your `composer.json` file add this line inside your `"psr-4"` object
    ```json
    {
         ...
         "autoload": {
             ...
             "psr-4": {
                    "OpenGraph\\": "vendor/primeobsession/opengraph-io-php/src/OpenGraph"
             },
             ...
         },
         ...
    }
    ```
3. Now just autoload your composer dependencies again using
    ```bash
    $ composer dump-autoload
    ```
4. Now you should be able to access `OpenGraphClient` using proper namespace
    ```php
    use OpenGraph\OpenGraphClient;
     
    define('OG_API_KEY', 'XXXXXXXXX');
     
    $og = new OpenGraphClient(OG_API_KEY);
    ```

* After releasing this package to Packagist you will be able to require it as following
    ```bash
    $ composer require primeobsession/opengraph-io-php
    ``` 
    or simply by adding inside your `composer.json` like
    ```json
    {
        ...
        "require": {
            "php": ">=7.0.0",
            "primeobsession/opengraph-io-php": "^1.0"
        },
        ...
    }
    ```
    and the updating composer dependencies
    ```bash
    $ composer update
    ```

## Usage 
* Autoload the package at the top of your PHP file as following
```php
require_once __DIR__ . '/../vendor/autoload.php'; 
```

* Initiate the OpenGraph client with API key obtained from [opengraph.io](https://opengraph.io/app/#!/account) and pass it to class constructor as following
```php
define('OG_API_KEY', 'XXXXXXXXX');
 
try {
    $og = new OpenGraph\OpenGraphClient(OG_API_KEY);
} catch (\OpenGraph\OpenGraphException $e) {
    echo $e->getMessage();
}
```

* OpenGraph client constructor parameter summary

| Parameters | Type | Required | Default | Description |
|:----------:|:----:|:--------:|:-------:|:-----------:|
| app_id | string | yes | null |The API key for registered users.  Create an account (no cc ever required) to receive your app_id(OG_API_KEY). |
| cache_ok | boolean | no | false |This will force our servers to pull a fresh version of the site being requested. This can significantly slow down the time it takes to get a response. |
| full_render | boolean | no | false |This will fully render the site using a chrome browser before parsing its contents. This is especially helpful for single page applications and JS redirects. This will slow down the time it takes to get a response by around 1.5 seconds. |

```php
define('OG_API_KEY', 'XXXXXXXXX');
 
try {
    $og = new OpenGraph\OpenGraphClient(OG_API_KEY, true, true); // app_id = 'XXXXXXXXX', cache_ok = true, full_render = true
} catch (\OpenGraph\OpenGraphException $e) {
    echo $e->getMessage();
}
```
* To fetch open graph response for a website you have to call fetch method with URL (of website to fecth og contents) as a required parameter.
```php
define('OG_API_KEY', 'XXXXXXXXX');
 
try {
    $og = new OpenGraph\OpenGraphClient(OG_API_KEY, true, true);
    $response = $og->fetch('https://www.opengraph.io');
    echo '<pre>';
    var_dump($response);
} catch (\OpenGraph\OpenGraphException $e) {
    echo $e->getMessage();
}
```

* Example OpenGraph Response

```php
object(OpenGraph\OpenGraphResponse)[4]
  protected '_id' => null
  protected '_v' => null
  protected 'url' => string 'https://opengraph.io' (length=20)
  protected 'hybridGraph' => 
    object(OpenGraph\HybridGraph)[11]
      protected 'title' => string 'OpenGraph.io - A very simple Open Graph API' (length=43)
      protected 'description' => string 'A free and simple API to retreive Open Graph data from websites, even those without it properly defined.' (length=104)
      protected 'type' => string 'website' (length=7)
      protected 'url' => string 'https://www.opengraph.io/' (length=25)
      protected 'favicon' => null
      protected 'site_name' => null
      protected 'image' => string 'http://www.opengraph.io/wp-content/uploads/2016/06/logo-simple.png' (length=66)
  protected 'openGraph' => 
    object(OpenGraph\OpenGraph)[12]
      protected 'error' => null
      protected 'title' => string 'OpenGraph.io - A very simple Open Graph API' (length=43)
      protected 'type' => string 'website' (length=7)
      protected 'admins' => null
      protected 'site_name' => string 'Opengraph.io' (length=12)
      protected 'image' => 
        object(stdClass)[8]
          public 'url' => string 'http://www.opengraph.io/wp-content/uploads/2016/06/logo-simple.png' (length=66)
      protected 'url' => string 'https://www.opengraph.io/' (length=25)
      protected 'description' => string 'A free and simple API to retreive Open Graph data from websites, even those without it properly defined.' (length=104)
  protected 'htmlInferred' => 
    object(OpenGraph\HtmlInferred)[13]
      protected 'title' => string 'OpenGraph.io - A Very Simple OpenGraph API' (length=42)
      protected 'description' => string 'Don’t waste time and resources scraping sites or trying to unfurl urls. Focus on your product and let us handle this for you!' (length=127)
      protected 'type' => string 'site' (length=4)
      protected 'url' => string 'https://opengraph.io' (length=20)
      protected 'favicon' => null
      protected 'site_name' => string 'OpenGraph.io' (length=12)
      protected 'images' => 
        array (size=2)
          0 => string 'https://www.opengraph.io/wp-content/uploads/2016/06/opengraph-white-27h.png' (length=75)
          1 => string 'http://www.opengraph.io/wp-content/uploads/2016/06/GoodData_small.png' (length=69)
      protected 'image_guess' => null
  protected 'requestInfo' => 
    object(OpenGraph\RequestInfo)[14]
      protected 'redirects' => int 0
      protected 'host' => string 'https://www.opengraph.io/' (length=25)
  protected 'accessed' => null
  protected 'updated' => 
    object(DateTime)[15]
      public 'date' => string '2017-09-22 21:03:41.501992' (length=26)
      public 'timezone_type' => int 3
      public 'timezone' => string 'UTC' (length=13)
  protected 'created' => 
    object(DateTime)[16]
      public 'date' => string '2017-09-22 21:03:41.502103' (length=26)
      public 'timezone_type' => int 3
      public 'timezone' => string 'UTC' (length=13)
  protected 'version' => string '1.1' (length=3)
```
 * N.B. OpenGraph Response return you back an implementaion of `OpenGraphResponse` object if you wish to get all data as an array just append `toArray()` method after your response as following.
```php
...
    var_dump($response->toArray());
...
```
* Now you will get an array like following
```php
array (size=11)
  '_id' => string '59c52d5a1b60710023a3b82a' (length=24)
  '_v' => null
  'url' => string 'https://opengraph.io' (length=20)
  'hybridGraph' => 
    array (size=6)
      'title' => string 'OpenGraph.io - A very simple Open Graph API' (length=43)
      'description' => string 'A free and simple API to retreive Open Graph data from websites, even those without it properly defined.' (length=104)
      'type' => string 'website' (length=7)
      'url' => string 'https://www.opengraph.io/' (length=25)
      'favicon' => null
      'image' => string 'http://www.opengraph.io/wp-content/uploads/2016/06/logo-simple.png' (length=66)
  'openGraph' => 
    array (size=8)
      'error' => null
      'title' => string 'OpenGraph.io - A very simple Open Graph API' (length=43)
      'type' => string 'website' (length=7)
      'admins' => null
      'site_name' => string 'Opengraph.io' (length=12)
      'image' => 
        object(stdClass)[8]
          public 'url' => string 'http://www.opengraph.io/wp-content/uploads/2016/06/logo-simple.png' (length=66)
      'url' => string 'https://www.opengraph.io/' (length=25)
      'description' => string 'A free and simple API to retreive Open Graph data from websites, even those without it properly defined.' (length=104)
  'htmlInferred' => 
    array (size=8)
      'title' => string 'OpenGraph.io - A Very Simple OpenGraph API' (length=42)
      'description' => string 'Don’t waste time and resources scraping sites or trying to unfurl urls. Focus on your product and let us handle this for you!' (length=127)
      'type' => string 'site' (length=4)
      'url' => string 'https://opengraph.io' (length=20)
      'favicon' => null
      'site_name' => string 'OpenGraph.io' (length=12)
      'images' => 
        array (size=2)
          0 => string 'https://www.opengraph.io/wp-content/uploads/2016/06/opengraph-white-27h.png' (length=75)
          1 => string 'http://www.opengraph.io/wp-content/uploads/2016/06/GoodData_small.png' (length=69)
      'image_guess' => null
  'requestInfo' => 
    array (size=2)
      'redirects' => int 0
      'host' => string 'https://www.opengraph.io/' (length=25)
  'accessed' => int 1
  'updated' => 
    object(DateTime)[15]
      public 'date' => string '2017-09-22 15:33:46.120000' (length=26)
      public 'timezone_type' => int 2
      public 'timezone' => string 'Z' (length=1)
  'created' => 
    object(DateTime)[16]
      public 'date' => string '2017-09-22 15:33:46.120000' (length=26)
      public 'timezone_type' => int 2
      public 'timezone' => string 'Z' (length=1)
  'version' => string '1.1' (length=3)
```

# Some examples

### Get Site Description
```php
...
    var_dump($response->hybridGraph->description);
...
```

### Get Site Logo
```php
...
    var_dump($response->hybridGraph->image);
...
```

### Get Site Title
```php
...
    var_dump($response->hybridGraph->title);
...
```

## Support

Feel free to reach out at any time with questions or suggestions by adding to the issues for this repo or if you'd 
prefer, head over to [https://www.opengraph.io/support/](https://www.opengraph.io/support/) and drop us a line!

## License

MIT License

Copyright (c)  Opengraph.io

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.