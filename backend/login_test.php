<?php
require 'login.php';

if(login('JuanP@gmail.com', 'Fide123')){
    echo 'Login Correcto' . PHP_EOL;
}else{
    echo 'Login incorrecto' . PHP_EOL;
}

