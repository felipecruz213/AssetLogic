<?php

require_once 'config/db.php';

$query = "SELECT p.id, p.nome, p.quantidade, p.preco, c.nome as categoria 
          FROM produtos p 
          LEFT JOIN categorias c ON p.categoria_id = c.id 
          ORDER BY p.id DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    $produtos = [];
    $erro_db = "Aviso: A tabela de produtos ainda não existe. Por favor, execute o script SQL.";
}
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AssetLogic - Gestão de Inventário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">AssetLogic</a>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 text-secondary">Dashboard de Ativos</h2>
            <a href="adicionar.php" class="btn btn-primary btn-sm">+ Novo Registo</a>
        </div>

        <?php if (isset($erro_db)): ?>
            <div class="alert alert-warning"><?= htmlspecialchars($erro_db) ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Nome do Ativo</th>
                                <th>Categoria</th>
                                <th>Quantidade (Stock)</th>
                                <th>Preço Unitário</th>
                                <th class="pe-4 text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produtos)): ?>
                                <?php foreach ($produtos as $produto): ?>
                                    <tr>
                                        <td class="ps-4 text-muted">#<?= htmlspecialchars($produto['id']) ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($produto['nome']) ?></td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                <?= htmlspecialchars($produto['categoria'] ?? 'Sem Categoria') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($produto['quantidade'] < 5): ?>
                                                <span class="text-danger fw-bold">
                                                    <?= htmlspecialchars($produto['quantidade']) ?> ⚠️ Baixo
                                                </span>
                                            <?php else: ?>
                                                <span class="text-success fw-bold">
                                                    <?= htmlspecialchars($produto['quantidade']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= number_format($produto['preco'], 2, ',', ' ') ?> €</td>
                                        <td class="pe-4 text-end">
                                            <a href="editar.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                            
                                            <a href="apagar.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('Tem a certeza que deseja apagar este ativo? Esta ação não pode ser desfeita.');">Apagar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        Nenhum ativo registado no sistema no momento.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>