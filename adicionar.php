<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST['nome'];
  $descricao = $_POST['descricao'];
  $categoria = $_POST['categoria'];
  $uid = $_SESSION['usuario_id'];

  $imagem = $_FILES['imagem']['name'];
  $temp = $_FILES['imagem']['tmp_name'];
  $pasta = "uploads/";

  move_uploaded_file($temp, $pasta . $imagem);

  $sql = "INSERT INTO jogos (nome, descricao, categoria, imagem, criado_por) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssi", $nome, $descricao, $categoria, $imagem, $uid);
  $stmt->execute();

  header("Location: index.php");
  exit();
}
?>
<form method="POST" enctype="multipart/form-data">
  <h2>Adicionar Jogo</h2>
  <input type="text" name="nome" placeholder="Nome do Jogo" required>
  <textarea name="descricao" placeholder="Descrição" required></textarea>
  <select name="categoria" required>
    <option value="">Escolha uma categoria</option>
    <option value="FPS">FPS</option>
    <option value="MOBA">MOBA</option>
    <option value="MMORPG">MMORPG</option>
  </select>
  <input type="file" name="imagem" accept="image/*" required>
  <button type="submit">Salvar</button>
</form>