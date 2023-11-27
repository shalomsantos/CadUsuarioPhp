<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- meu css e js -->
    <link rel="stylesheet" href="/css/style.css">
    <script type="text/javascript" src="/js/script.js" defer></script>
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" defer></script>
    
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon" />
    <title>.::LOGIN::.</title>
</head>
<body>
    <main class="w-100 d-flex align-items-center justify-content-center">
        <span id="msg">
            <?php
                // importando arquivo de conexão
                include_once('config.php'); 

                // criando instancia da classe e chamando metodo que retornar um objeto da conexão
                $conexao = new Connection();
                $pdoInstance = $conexao->getConnection();
                // ações de crud
                if(isset($_POST['submit'])){
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    if($email OR $password != ''){
                        try {
                            $sql = "SELECT * FROM usuario WHERE email='$email' and senha='$password';";
                            $result = $pdoInstance->prepare($sql);
                            $result->execute();
                            
                            if(($result) and ($result->rowCount() != 0)){

                                $result_user = $result->fetch(PDO::FETCH_ASSOC);
                                header('Location: home.php');

                            }elseif($result->rowCount() > 1){
                                echo 'erro inesperado, mais de um usuario com esse registro';
                            }
                            else{
                                echo 'Usuário ou senha não existe';
                            }
                        } catch(PDOException $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                    }
                    else{
                        echo "dados insuficientes para realizar o login!";
                    }
                }       
            ?>
        </span>
        <form action="index.php" method="POST" class="d-flex flex-column gap-2 text-center" style="width: 15rem;">
            <h1><strong>Login</strong></h1>
            <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="E-mail:">
            <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Senha:">
            <button type="submit" name="submit" id="submit" class="btn btn-success btn-sm entrar">Entrar</button>
        </form>
    </main>
</body>
</html>