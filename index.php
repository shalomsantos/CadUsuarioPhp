<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- meu css e js -->
    <link rel="stylesheet" href="/css/login.css">
    <script type="text/javascript" src="/js/script.js" defer></script>
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" defer>
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon" />
    <title>.::LOGIN::.</title>
</head>
<body>
    <main>
        <span id="msg">
            <?php
                // importando arquivo de conexão
                include_once('config.php'); 

                // criando instancia da classe e chamando metodo que retornar um objeto da conexão
                $conexao = new Connection();
                $pdoInstance = $conexao->getConnection();
                // ações de crud
                if(isset($_POST['submit'])){

                    header('Location: home.php');
                }
            ?>
        </span>
        <div class="centro card">
            <form action="home.php" method="POST" class="d-flex flex-column text-center" style="gap: 1rem;">
                <h1>Login</h1>
                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail:">
                <input type="password" name="password" id="password" class="form-control" placeholder="Senha:">
                <button type="submit" name="submit" id="submit" class="btn btn-outline-success">Entrar</button>
                <div class="d-flex justify-content-between">
                    <a href="#">Esqueceu a senha?</a>
                    <a href="#">Criar conta</a>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous" defer></script>
</body>
</html>