<?php
$filename = "notas.txt";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {

        if ($_POST['action'] == 'cadastrar') {
            $nome = trim($_POST['nome']);
            $nota = trim($_POST['nota']);

            if ($nome == "") {
                $erro = "O nome não pode ser vazio.";
            } elseif (!is_numeric($nota) || $nota < 0 || $nota > 10) {
                $erro = "Nota inválida! Insira um valor entre 0 e 10";
            } else {
                $handle = fopen($filename, "a");
                fwrite($handle, $nome . "|" . $nota . "\n");
                fclose($handle);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }

        elseif ($_POST['action'] == 'apagar') {
            file_put_contents($filename, "");
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }

        elseif ($_POST['action'] == 'editar') {
            $index = $_POST['index'];
            $novaNota = trim($_POST['nota']);

            if (!is_numeric($novaNota) || $novaNota < 0 || $novaNota > 10) {
                $erro = "Nota inválida! Insira um valor entre 0 e 10";
            } else {
                $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                if (isset($lines[$index])) {
                    $parts = explode("|", $lines[$index]);
                    $nome = $parts[0];
                    $lines[$index] = $nome . "|" . $novaNota;
                    file_put_contents($filename, implode("\n", $lines) . "\n");
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                } else {
                    $erro = "Aluno não encontrado para edição";
                }
            }
        }
    }
}

if (isset($_GET['edit'])) {
    $editIndex = $_GET['edit'];
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (isset($lines[$editIndex])) {
        $parts = explode("|", $lines[$editIndex]);
        $editNome = $parts[0];
        $editNota = $parts[1];
    } else {
        $erro = "Aluno não encontrado para edição";
    }
}

$alunos = [];
if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $ln) {
        $parts = explode("|", $ln);
        if (count($parts) == 2) {
            $alunos[] = ["nome" => $parts[0], "nota" => $parts[1]];
        }
    }
}

$media = 0;
if (count($alunos) > 0) {
    $soma = 0;
    foreach ($alunos as $aluno) {
        $soma += $aluno["nota"];
    }
    $media = $soma / count($alunos);
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Notas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e0f7fa; 
            margin: 0;
            padding: 0;
            color: #595959; 
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: rgba(252, 252, 252, 0.8); 
            backdrop-filter: blur(10px); 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2, h3 {
            color: #595959; 
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 8px 0;
            font-weight: bold;
            color: #595959; 
        }

        input[type="text"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
            color: #595959; 
        }

        input[type="submit"] {
            padding: 12px 24px;
            background: #74A57F; 
            border: none;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background: #6b8f6a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(252, 252, 252, 0.9); 
            backdrop-filter: blur(10px); 
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #74A57F; 
            color: white;
        }

        td a {
            color: #FF6B6B;
            text-decoration: none;
        }

        td a:hover {
            color: #d94c4c; 
        }

        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            th { display: none; }
            td {
                border: none;
                position: relative;
                padding-left: 50%;
                margin-bottom: 10px;
            }
            td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                color: #74A57F; 
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de notas dos alunos</h1>
        <?php if (isset($erro)): ?>
            <p style="color:red;"><?php echo htmlspecialchars($erro); ?></p>
        <?php endif; ?>

        <?php if (isset($editIndex)): ?>
            <h2>Editar nota de <?php echo htmlspecialchars($editNome); ?></h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="editar">
                <input type="hidden" name="index" value="<?php echo htmlspecialchars($editIndex); ?>">
                <label>Nota:</label>
                <input type="text" name="nota" value="<?php echo htmlspecialchars($editNota); ?>">
                <input type="submit" value="Atualizar">
            </form>
            <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Cancelar Edição</a></p>
            <hr>
        <?php else: ?>
            <h2>Cadastrar Aluno</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="cadastrar">
                <label>Nome:</label>
                <input type="text" name="nome">
                <label>Nota:</label>
                <input type="text" name="nota">
                <input type="submit" value="Cadastrar">
            </form>
            <form method="POST" action="" style="margin-top:10px;">
                <input type="hidden" name="action" value="apagar">
                <input type="submit" value="Apagar todas as notas" onclick="return confirm('Tem certeza que deseja apagar todas as notas?');">
            </form>
        <?php endif; ?>

        <h2>Lista de Alunos e Notas</h2>
        <?php if (count($alunos) == 0): ?>
            <p>Nenhum aluno cadastrado</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Nota</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alunos as $idx => $aluno): ?>
                    <tr>
                        <td data-label="Nome"><?php echo htmlspecialchars($aluno["nome"]); ?></td>
                        <td data-label="Nota"><?php echo htmlspecialchars($aluno["nota"]); ?></td>
                        <td data-label="Ação"><a href="?edit=<?php echo $idx; ?>">Editar</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <h3>Média das notas: <?php echo number_format($media, 2); ?></h3>
    </div>
</body>
</html>
