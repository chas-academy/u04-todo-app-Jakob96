# u04-todo-app-Jakob96

This app lets you manage and keep track of your activities in Todo lists. The home page will always show you your daily tasks.

## Technologies

```
MySQL database
PHP backend
Some JS
Bulma CSS frontend framework
HTML5

```

All requests is served from index.php which then routes the requests to the correct view.

The following code in .htaccess file in root will rewrite every request to index.php.

```
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)$ index.php [QSA,L]
```

"RewriteCond -d and -f" ensure that directly linked files like JS and CSS will be served correctly.

## Connect to database

Create a file app.json in /config with the following:

```
{
  "db": {
    "host": "localhost",
    "dbname": "tododb",
    "dbuser": "username",
    "dbpass": "password",
    "charset": "utf8"
  }
}

```

## Sign in

Every todo list will be assigned to your email adress which is used for identification.
