<?php

define("pg_host", 'localhost');
define("pg_port", 5432);
define("pg_dbname", 'postgres');
define("pg_username", "postgres");
define("pg_password", "wrongpassword");


define("pg_connect_string",
    "host=" . pg_host . 
    " port=" . pg_port . 
    " dbname=" .pg_dbname . 
    " user=" . pg_username . 
    " password=" . pg_password
);

?>