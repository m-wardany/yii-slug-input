yii2 widget to auto generate slug using jQuery
==============================================
Generate auto slug text from any input using model input or just Html id attribute

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist wardany/yii-slug-input "*"
```

or add

```
"wardany/yii-slug-input": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \wardany\slugify\Slugify::widget(); ?>```