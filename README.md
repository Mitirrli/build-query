<h1 align="center"> build query </h1>
<p align="center">:rainbow: use for build query.</p>

![StyleCI build status](https://github.styleci.io/repos/300122166/shield) 
[![Build Status](https://travis-ci.org/Mitirrli/build-query.svg?branch=master)](https://travis-ci.org/Mitirrli/build-query)
[![Coverage Status](https://coveralls.io/repos/github/Mitirrli/build-query/badge.svg?branch=master)](https://coveralls.io/github/Mitirrli/build-query?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/0a4fbf4b819b4817a42976e452cef04b)](https://app.codacy.com/gh/Mitirrli/build-query?utm_source=github.com&utm_medium=referral&utm_content=Mitirrli/build-query&utm_campaign=Badge_Grade)
[![Better Code](https://bettercodehub.com/edge/badge/Mitirrli/build-query?branch=master)](https://bettercodehub.com/)
[![Total Downloads](https://poser.pugx.org/mitirrli/build-query/downloads)](https://packagist.org/packages/mitirrli/build-query)
[![GitHub (pre-)release](https://img.shields.io/github/release/mitirrli/build-query/all.svg)](https://github.com/mitirrli/build-query)

## Environment

   - PHP >= 7.1

## Installation

```shell script
$ composer require mitirrli/build-query
```

## QuickStart

1. Common filter
```php
use Mitirrli\Buildable\Constant;
use Mitirrli\Buildable\Buildable;

$this->param($params ?? [])
    ->initial(['initial' => 0])
    ->key('avatar')
    ->key('name', Constant::RIGHT)
    ->key('name', Constant::ALL)
    ->inKey('type')
    ->betweenKey('created_at', ['start' => 'create', 'end' => 'end'])
    ->beforeKey('id')
    ->afterKey('id')
    ->unsetKey('initial')
    ->sort('created_at')                
    ->result();
```  

2. Get order
```php
use Mitirrli\Buildable\Sortable;

$this->param($params ?? [])
    ->initial(['time' => 'desc'])
    ->sort('time')
    ->result();
```
