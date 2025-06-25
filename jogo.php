<?php
require 'db.php';
$id = $_GET['id'] ?? 0;
$sql = "SELECT j.nome, j.descricao, j.categoria, j.imagem, u.nome AS autor
        FROM jogos j
        LEFT JOIN usuarios u ON j.criado_por = u.id
        WHERE j.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$jogo = $res->fetch_assoc();
?>
<h2><?= htmlspecialchars($jogo['nome']) ?> (<?= htmlspecialchars($jogo['categoria']) ?>)</h2>
<img src="uploads/<?= htmlspecialchars($jogo['imagem']) ?>" width="300">
<p><?= nl2br(htmlspecialchars($jogo['descricao'])) ?></p>
<p><em>Criado por: <?= htmlspecialchars($jogo['autor'] ?? 'Anônimo') ?></em></p>
<a href="index.php">Voltar</a>