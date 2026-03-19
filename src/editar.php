<?php
require_once 'config/db.php';

//Verificar se o formulário foi submetido para ATUALIZAR os dados (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $categoria_id = $_POST['categoria_id'];
    $quantidade = $_POST['quantidade'];
    $preco = str_replace(',', '.', $_POST['preco']);

    $sql = "UPDATE produtos SET nome = :nome, categoria_id = :categoria_id, quantidade = :quantidade, preco = :preco WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':categoria_id' => $categoria_id,
        ':quantidade' => $quantidade,
        ':preco' => $preco,
        ':id' => $id
    ]);

    // Voltar para o Dashboard
    header('Location: index.php');
    exit;
}


if (!isset($_GET['id'])) {
    die("Erro: ID do produto não fornecido.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
$stmt->execute([':id' => $id]);
$produto = $stmt->fetch();

if (!$produto) {
    die("Erro: Produto não encontrado.");
}

$query_categorias = $pdo->query("SELECT * FROM categorias");
$categorias = $query_categorias->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ativo - AssetLogic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">AssetLogic</a>
        </div>
    </nav>

    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm border-0 border-top border-primary border-3">
            <div class="card-header bg-white pt-3 pb-2">
                <h4 class="text-secondary">Editar Ativo #<?= htmlspecialchars($produto['id']) ?></h4>
            </div>
            <div class="card-body">
                
                <form action="editar.php" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($produto['id']) ?>">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nome do Produto/Ativo</label>
                        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($produto['nome']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoria</label>
                        <select name="categoria_id" class="form-select" required>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $produto['categoria_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Quantidade (Stock)</label>
                            <input type="number" name="quantidade" class="form-control" value="<?= htmlspecialchars($produto['quantidade']) ?>" min="0" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Preço Unitário (€)</label>
                            <input type="text" name="preco" class="form-control" value="<?= htmlspecialchars($produto['preco']) ?>" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Alterações</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>
</html>
