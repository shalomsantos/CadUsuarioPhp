<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- meu css e js -->
    <link rel="stylesheet" href="/css/login.css">
    <script type="text/javascript" src="/js/script.js" defer></script>
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous" defer></script>
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon" />
    <title>.::LOGIN::.</title>
</head>
<body class="d-flex justify-content-center align-items-center">
    <main class="d-flex rounded-2 overflow-hidden">
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
        <div class="bg-trans-blur d-flex align-items-center p-4 order-2">
            <form action="index.php" method="POST" class="d-flex flex-column gap-2 text-center">
                <h1>Login</h1>
                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail:">
                <input type="password" name="password" id="password" class="form-control" placeholder="Senha:">
                <button type="submit" name="submit" id="submit" class="btn btn-success entrar">Entrar</button>
                <a href="#" id="register" onClick="register()">Criar conta</a>
                <!-- VOU TER QUE CRIAR UM TELA DE CADASTRO, NA HOME PRECISO MONTAR O UM PAINEL PARA VISIALIZAR OS USUARIOS E REDIRECIONAR PARA CADASTRO OU RETORNAR AO LOGIN -->
                <!-- <a class="btn btn-outline-secondary" href="edit.php?id='.$row['id'].'"><i class="fa-solid fa-pen"></i></a> -->
            </form>
        </div>
        <div class="register bg-trans-blur p-4 order-1" style="display: none;">
            <form action="" method="" class="d-flex flex-column gap-2 text-center">
                <h1>Register</h1>
                <input type="name" name="nome" id="nome" class="form-control" placeholder="Nome:">
                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail:">
                <input type="tel" name="telefone" id="telefone" class="form-control" placeholder="Telefone:">
                <input type="password" name="password" id="password" class="form-control" placeholder="Senha:">
                <input type="confirm" name="confirm" id="confirm" class="form-control" placeholder="Confirm senha:">
                <button class="btn btn-outline-success">Registrar</button>
            </form>
        </div>
    </main>
</body>
</html>