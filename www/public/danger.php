<?php

$pass = password_hash($_GET['pass'], PASSWORD_DEFAULT);
echo $pass;

echo phpinfo();