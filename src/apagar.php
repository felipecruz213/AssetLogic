<?php

require_once 'config/db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        die("Erro crítico ao tentar apagar o registo: " . $e->getMessage());
    }
}

header('Location: index.php');
exit;
?>