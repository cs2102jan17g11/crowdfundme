# Crowdfundme
Explore the greatest projects, ever.

# Installations
## Modules
Make sure you are using either bitnami's MAPP-5.60.30-0 or WAPP stack with these installed:
    - Postgres
    - Apache

## Configurations
Setup your variables that will be used by php.
`cp example.env.php env.php`
Update `pg_port`, `pg_dbname` `pg_username`, `pg_password` to your own local dev's setting.

## Additional configs (has to be done on local)
### 404 Error page
Find `httpd.conf` in `apache2/conf` and add this line `ErrorDocument 404 /404.php` at around line 443~, which is together with the other `ErrorDocument` configs. Restart your apache server if the 404 page is the default one.

# Updating Database
Note: it is assumed that the postgres database name for this project is called `crowdfundme` and the owner of that db (with creation/update/delete permission) is `postgres`, hosting address is `localhost` and port is `5432`.
You can verify this by trying to access the database with
`pgcli crowdfunme -U postgres`

Drop the existing `crowdfundme` database.  
`dropdb crowdfundme -U postgres`  
Then, create a new database  
`createdb crowdfundme -U postgres`  
Then, run
`psql crowdfundme -U postgres < sqls/schemas.sql`  
`psql crowdfundme -U postgres < sqls/data.sql`  

# Project Structure
## Site structure
```
├── book/         // previous book template, can be removed
├── css/          // store css assets here
├── footer.php    // all php webpages must include this
├── headers.php   // all php webpages must include this
├── img/          // store img assets here
├── index.php     // index page
├── projects/     // projects subsite, views/updates/manage a particular project
├── projects.php  // projects overview, lists all projects available
```

## PHP
```
├── env.php       // store global variables here, not sure if we need a constants.php
├── sqls.php      // store php-sql query functions here
```
