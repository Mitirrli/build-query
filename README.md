<h1 align="center"> build query </h1>
<p align="center">:rainbow: use for build query.</p>

[![Total Downloads](https://poser.pugx.org/mitirrli/build-query/downloads)](https://packagist.org/packages/mitirrli/build-query)
[![Latest Stable Version](https://poser.pugx.org/mitirrli/build-query/v/stable)](https://packagist.org/packages/mitirrli/build-query)
[![Latest Unstable Version](https://poser.pugx.org/mitirrli/build-query/v/unstable)](https://packagist.org/packages/mitirrli/build-query)
<a href="https://packagist.org/packages/mitirrli/build-query"><img src="https://poser.pugx.org/mitirrli/build-query/license" alt="License"></a>

## Environment

- PHP >= 7.0

## Installation

```shell
$ composer require "mitirrli/build-query"
```

## QuickStart
```php
use Mitirrli\Buildable\Constant;

$this->param($params ?? [])
     ->initial(['initial' => 0]) //set an initial value
     ->key('name', Constant::RIGHT) //right fuzzy
     ->key('name', Constant::ALL) //all fuzzy
     ->key('avatar')
     ->key(['name', 'nickname'])
     ->inKey('type') //array search
     ->betweenKey('created_at', 'started_at', 'ended_at') //between search
     ->beforeKey('id') //before Key
     ->afterKey('id') //after kay
     ->unsetKey('initial') //unset param
     ->result(); //get result
```  
  
