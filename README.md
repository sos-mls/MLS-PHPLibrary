# CommonPHP #

A common php library between php projects

## The Tools Used ##

During the creation of this Common library I used:

* [A vagrant box for Testing and Static Code Analysis](https://github.com/fufu70/PHP-Jenkins-Breakfast-Box)

* A Local instance of [PHPUnit 4.8](https://phpunit.de/)

## Testing Locally ##

To test locally install PHPUnit, mcrypt, and imagemagick for php. After their installation simply run:

```shell
$ phpunit -c build/phpunit.xml 
```

### imagemagick: ###

```shell
$ brew install php56-imagick
```

### PHPUnit: ###

```shell
$ wget https://phar.phpunit.de/phpunit-4.8.phar
$ sudo chmod +x phpunit-4.8.phar
$ sudo mv phpunit-4.8.phar /usr/local/bin/phpunit
```

### MCrypt ###

```shell
$ brew install php56-mcrypt
```