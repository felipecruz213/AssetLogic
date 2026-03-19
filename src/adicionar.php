<?php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $categoria_id = $_POST['categoria_id'];
    $quantidade = $_POST['quantidade'];
    $preco = str_replace(',', '.', $_POST['preco']);

    // Isso evita SQL injection
    $sql = "INSERT INTO produtos (nome, categoria_id, quantidade, preco) 
            VALUES (:nome, :categoria_id, :quantidade, :preco)";
    
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':categoria_id' => $categoria_id,
        ':quantidade' => $quantidade,
        ':preco' => $preco
    ]);


    header('Location: index.php');
    exit;
}

// Buscar as categorias à Base de Dados para o menu Dropdown
$query_categorias = $pdo->query("SELECT * FROM categorias");
$categorias = $query_categorias->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Ativo - AssetLogic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">AssetLogic</a>
        </div>
    </nav>

    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pt-3 pb-2">
                <h4 class="text-secondary">Registar Novo Ativo</h4>
            </div>
            <div class="card-body">
                
                <form action="adicionar.php" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome do Produto/Ativo</label>
                        <input type="text" name="nome" class="form-control" required placeholder="Ex: Monitor 24 Polegadas">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoria</label>
                        <select name="categoria_id" class="form-select" required>
                            <option value="">Selecione uma categoria...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Quantidade (Stock)</label>
                            <input type="number" name="quantidade" class="form-control" value="0" min="0" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Preço Unitário (€)</label>
                            <input type="text" name="preco" class="form-control" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/index.php" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Gravar Registo</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>
</html>
