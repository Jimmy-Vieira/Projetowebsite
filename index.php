<?php
session_start();
require 'db.php';

$busca = $_GET['busca'] ?? '';
$categoria = $_GET['categoria'] ?? '';

$query = "SELECT * FROM jogos WHERE 1";
$params = [];

if (!empty($busca)) {
  $query .= " AND nome LIKE ?";
  $params[] = "%" . $busca . "%";
}

if (!empty($categoria)) {
  $query .= " AND categoria = ?";
  $params[] = $categoria;
}

$stmt = $conn->prepare($query . " ORDER BY nome ASC");

if (count($params) === 2) {
  $stmt->bind_param("ss", $params[0], $params[1]);
} elseif (count($params) === 1) {
  $stmt->bind_param("s", $params[0]);
}

$stmt->execute();
$jogos = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Wiki de Jogos Online</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <header>
    <h1>Wiki de Jogos Online</h1>
    <nav>
      <?php if (isset($_SESSION['nome'])): ?>
        <span>Bem-vindo, <?= $_SESSION['nome'] ?> | <a href="logout.php">Sair</a></span>
        <a href="adicionar.php">Adicionar Jogo</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastro</a>
      <?php endif; ?>
    </nav>
  </header>
  <main>
    <form method="GET">
      <input type="text" name="busca" placeholder="Buscar jogo..." value="<?= htmlspecialchars($busca) ?>">
      <select name="categoria">
        <option value="">Todas Categorias</option>
        <option value="FPS" <?= $categoria=="FPS"?"selected":"" ?>>FPS</option>
        <option value="MOBA" <?= $categoria=="MOBA"?"selected":"" ?>>MOBA</option>
        <option value="MMORPG" <?= $categoria=="MMORPG"?"selected":"" ?>>MMORPG</option>
      </select>
      <button type="submit">Buscar</button>
    </form>
    <ul>
    <?php while ($jogo = $jogos->fetch_assoc()): ?>
      <li>
        <img src="uploads/<?= htmlspecialchars($jogo['imagem']) ?>" width="100">
        <a href="jogo.php?id=<?= $jogo['id'] ?>"><?= htmlspecialchars($jogo['nome']) ?></a>
        <span>(<?= htmlspecialchars($jogo['categoria']) ?>)</span>
      </li>
    <?php endwhile; ?>
    </ul>
  </main>
</body>
</html>