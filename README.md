# Casper CURL

Basics on [casperjs](https://casperjs.org/) / [phantomjs](https://phantomjs.org/) libs for get content difficult sites.

## Installation

1 Install global casperjs and phantomjs
```bash
npm install -g casperjs
npm install -g phantomjs
```

2 Install CasperCURL package
```bash
composer require denis-kisel/casper-curl
```

### Publish Configuration File(If Use Laravel)
If you use another framework or native PHP, just skip this setting.
```bash
php artisan vendor:publish --provider="DenisKisel\CasperCURL\ServiceProvider" --tag="config"
```

## Usage
Simple example

```php
//Return content page
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')->request()
```

### Set Method
method($method)  
Methods available: `GET|POST|PUT|DELETE`  
By default use `GET`

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')
    ->method('POST')
    ->request()
```

### Set Data
withData($arrayData)  

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')
    ->withData([
        'login' => '***',
        'pass' => '***'
    ])
    ->method('POST')
    ->request()
```

### Set Headers
withHeaders($arrayHeaders)  

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')
    ->withHeaders([
        'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0',
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
    ])
    ->request()
```

### Set UserAgent
userAgent($userAgent)  
By default use: Mozilla/5.0 (Windows NT 10.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')
    ->userAgent('Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0')
    ->request()
```

### Use Proxy
withProxy($ip, $port \[, $method = 'http'] \[, $login = null] \[, $pass = null])

Methods available: `http|socks5|none`

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')
    ->withProxy($ip, $port)
    ->request()
```

### Use Cookies
withCookie($fileName, \[, $dir])  
By default cookie is `disabled`.  
By default cookies file is stored in storage dir.

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')
    ->withCookie('cookie.txt')
    ->request()
```

### Use WindowSize(ViewPort)
windowSize($with, $height)  
By default: width/height: `1920/1080` px

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')
    ->windowSize(320, 600)
    ->request()
```

### Phantom Cli Options
Set custom phantom cli options  
List of available options: [Phantom Options Doc](https://phantomjs.org/api/command-line.html)

withPhantomOptions($arrayOptions)  
Key of option `must not contain` a prefix `--`

```php
$options = [
    'debug' => 'true',
    'ignore-ssl-errors' => 'true'
];

$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('https://google.com')
    ->withPhantomOptions($options)
    ->request()
```

## CasperJS
For use dynamic handling content  
[Casper Doc](http://casperjs.org/)

### Use Casper Then
casperThen($jsScript)  
[DOC](http://docs.casperjs.org/en/latest/modules/casper.html#then)

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('http://google.fr')
    ->casperThen('
         this.fill('form[action="/search"]', { q: 'casperjs' }, true);
         this.wait(2000, function () {
             this.capture('step_1.png');
         });
     
    ')
    ->request()
```

### Use Custom Casper JS
Custom casper body js  
[DOC](http://docs.casperjs.org/en/1.1-beta2/index.html)

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('http://google.fr')
    ->customCasper('
        casper.then(function() {
             this.fill('form[action="/search"]', { q: 'casperjs' }, true);
             this.wait(2000, function () {
                 this.capture('step_1.png');
             });
        });
    ')
    ->request()
```

## Debug
enableDebug()  
Will be store response data and capture in storage dir

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('http://google.com')
    ->enableDebug()
    ->request()
```

## Response
Response is object with fields:
* status (exp. 200|404|500)
* content (string html|dom|txt)

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('http://google.com')
    ->request();
    
$response->status;
$response->content;
```

### Response Content
By default request response full page content  
[DOC](http://docs.casperjs.org/en/latest/modules/casper.html#getpagecontent)

But response can override by `output` variable

```php
$casperCURL = new \DenisKisel\CasperCURL\CasperCURL($storageDir);
$response = $casperCURL->to('http://google.fr')
    ->casperThen('
         this.fill('form[action="/search"]', { q: 'casperjs' }, true);
         this.wait(2000, function () {
             this.capture('step_1.png');
         });
         
         output = console.log('Override default output!');
    ')
    ->request()
```

## Use In Laravel

```php
$response = \DenisKisel\CasperCURL\LCasperCURL::to('https://google.com')->request()
```

## License
This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT)

## Contact
Developer: Denis Kisel
* Email: denis.kisel92@gmail.com
* Skype: live:denis.kisel92

