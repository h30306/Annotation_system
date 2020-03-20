# Data Annotaion System

#### Github

https://github.com/h30306/tagged_system

### Author

[Howard W. Chung](https://github.com/h30306)

## Introduction

This library implements Data Annotation System website

Related demo sites
- [Annotation]()

## Require

- python>=3
- xampp
- [MySQL python connecter](https://dev.mysql.com/downloads/connector/python/)
- PHP 7.2.28

## Start Up

1.Launch Xampp App

2.Go to Gerneral page and press start

3.Go to Services page and press start all

4.Go to Network page and press enable

5.Go to Volumns page and press Mount

6.Press Explore button

7.Move this Annotation_system Under /htdocs/ or var/www/html/(For Linux Server)

8.Enter this link in your browser : http://localhost:8080/phpmyadmin/

9.Create an empty Database named "VAI"

10.Back to the Annotation_system folder and execute: 
```
python ./sql_processing/sql_processing.py
```
11.Enter this link in your browser : http://localhost:8080/annotation_system/

12.All done!

## Deploy on Heroku
>If you want to deploy on heroku, you can follow these steps!

1.Signup in [Heroku](https://dashboard.heroku.com)

2.Install [Heroku CLI](https://devcenter.heroku.com/articles/heroku-cli)

3.Go to the Annotation_system folder

4.execute
```
touch composer.json
```
```
heroku create Project Name(Annotation_system)
```
```
git init
```
```
heroku git:remote -a Project Name(Annotation_system)
```
Create "Procfile" with no filename extension, and it should look like this:
web: heroku-php-apache2
```
composer update
```
```
git add .
```
```
git commit -m 'v0.1'
```
```
git push heroku master
```

```
```
```

```
