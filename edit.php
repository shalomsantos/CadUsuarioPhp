<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- meu css e js -->
    <link rel="stylesheet" href="/css/style.css">
    <script type="text/javascript" src="/js/script.js" defer></script>
    <!-- jquey -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js" defer></script>
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" defer>
    <!-- fontwasome -->
    <script src="https://kit.fontawesome.com/c3cffe3b5e.js" crossorigin="anonymous" defer></script>
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon" />
    <title>.::PHP::.</title>
</head>
<body>
    <div class="main">
        <span id="msg">
            <?php
                // importando arquivo de conexão
                include_once('config.php'); 

                // criando instancia da classe e chamando metodo que retornar um objeto da conexão
                $conexao = new Connection();
                $pdoInstance = $conexao->getConnection();

                // ações de crud
                if(!empty($_GET['editar'])){
                    $id = $_GET['editar'];

                    $sql = "SELECT * FROM usuario WHERE id=$id";
                    $result = $pdoInstance->prepare($sql);
                    $result->execute();
                    
                    if(($result) and ($result->rowCount() != 0)){
                        $result_user = $result->fetch(PDO::FETCH_ASSOC);
                    }
                }
                // ações de crud
                if(isset($_POST['submit'])){

                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $tel = $_POST['tel'];
                    $password = $_POST['password'];

                    if($name OR $email OR $password != ''){
                        
                        try {
                            $stmt = $pdoInstance->prepare('INSERT INTO usuario(nome, email, telefone, senha) VALUES(:nome, :email, :tel, :password)');
                            $stmt->execute(array(
                            ':nome' => $name,
                            ':email' => $email,
                            ':tel' => $tel,
                            ':password' => $password
                            ));
                            // echo $stmt->rowCount();
                        } catch(PDOException $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                    }
                    else{
                        echo "dados insuficientes para realizar cadastro!";
                    }
                }
                // ações de crud
                if(isset($_GET['editar'])){

                    $id = (int)$_GET['editar'];

                    echo $id;
                    // try {
                    //     $stmt = $pdoInstance->prepare('INSERT INTO usuario(nome, email, telefone, senha) VALUES(:nome, :email, :tel, :password)');
                    //     $stmt->execute(array(
                    //     ':nome' => $name,
                    //     ':email' => $email,
                    //     ':tel' => $tel,
                    //     ':password' => $password
                    //     ));
                    //     // echo $stmt->rowCount();
                    // } catch(PDOException $e) {
                    //     echo 'Error: ' . $e->getMessage();
                    // }
                }
            ?>
        </span>
        <form action="edit.php" method="POST">
            <h1 class="text-center">Adicionar usuário</h1>
            <div class="col-6 container d-flex p-2">
                <div class="col-6 d-flex flex-column me-2" style="gap: 1rem;">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nome:" required value="<?php if(isset($result_user['nome'])){echo $result_user['nome'];} ?>">
                    <input type="email" name="email" id="email" class="form-control" placeholder="E-mail:" required value="<?php if(isset($result_user['email'])){echo $result_user['email'];} ?>">
                    <input type="tel" name="tel" id="tel" class="form-control" placeholder="Telefone:" value="<?php if(isset($result_user['telefone'])){echo $result_user['telefone'];} ?>">
                </div>
                <div class="col-6 d-flex flex-column" style="gap: 1rem;">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Senha" required value="<?php if(isset($result_user['senha'])){echo $result_user['senha'];} ?>">
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Senha confirm:" required value="<?php if(isset($result_user['senha'])){echo $result_user['senha'];} ?>">
                    <div>
                        <button class="btn btn-outline-primary" type="submit" name="editar" id="editar">Editar</button>
                        <button class="btn btn-outline-primary" type="button" onclick="Clean()" id="limpar"><i class="fa-solid fa-broom"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous" defer></script>
</body>
</html>