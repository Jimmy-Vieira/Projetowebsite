<?php
$host = "localhost";
$user = "root";
$pass = ""; // sua senha
$db = "wiki_jogos";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Erro na conexão: " . $conn->connect_error);
}