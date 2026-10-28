<?php
$host = 'localhost'
$user = 'root'
$passwd = ''
$database = 'kino'

$connect = new mysqli($host, $user, $password, $database);

if ($connect->connect_errno) {
    die("nie udało się połączyć: ". $connect->connect_error);
}
?>