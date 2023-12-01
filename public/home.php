<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- meu css e js -->
    <link rel="stylesheet" href="/css/style.css">
    <script type="text/javascript" src="/js/script.js" defer></script>
    <!-- boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous" defer></script>
    <!-- fontwasome -->
    <script src="https://kit.fontawesome.com/c3cffe3b5e.js" crossorigin="anonymous" defer></script>
    <link rel="shortcut icon" href="/img/docker.png" type="image/x-icon" />
    <title>.::PHP::.</title>
</head>
<body>
    
    <span id="msg">
        <?php
            // importando arquivo de conexão
            include_once('config.php'); 

            // criando instancia da classe e chamando metodo que retornar um objeto da conexão
            $conexao = new Connection();
            $pdoInstance = $conexao->getConnection();

            // ações de crud
            if(!empty($_GET['id'])){
                $id = $_GET['id'];

                $sql = "SELECT * FROM usuario WHERE id=$id";
                $result = $pdoInstance->prepare($sql);
                $result->execute();
                
                if(($result) and ($result->rowCount() != 0)){
                    $result_user = $result->fetch(PDO::FETCH_ASSOC);
                }
            }
            // ações de crud
            if(isset($_POST['submit'])){

                if(isset($_POST['name'])){
                    echo "Usuário adicionado com sucesso!";
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
                        } catch(PDOException $e) {
                            echo 'Error: ' . $e->getMessage();
                        }
                    }
                    else{
                        echo "dados insuficientes para realizar cadastro!";
                    }
                    echo "teste de inserção";
                }
            }
            // ações de crud
            if(isset($_GET['delete'])){
                $id = (int)$_GET['delete'];
                $pdoInstance->exec("DELETE FROM usuario WHERE id=$id");
            }
        ?>
    </span>
    <main class="bg-dark">
        <div class="d-flex flex-column w-75" style="position: relative;">
            <a href="index.php" class="btn btn-primary btn-exit"><i class="fa-solid fa-right-from-bracket mx-2"></i>Log-out</a>
            <h5 class="text-white">Adicionar usuário</h5>
            <form action="./home.php" method="POST" class="border bg-white rounded-2 w-100 p-3">
                <div class="row">
                    <div class="col d-flex flex-column gap-1">
                        <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Nome:" required value="<?php if(isset($result_user['nome'])){echo $result_user['nome'];} ?>">
                        <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="E-mail:" required value="<?php if(isset($result_user['email'])){echo $result_user['email'];} ?>">
                        <input type="tel" name="tel" id="tel" class="form-control form-control-sm" placeholder="Telefone:" value="<?php if(isset($result_user['telefone'])){echo $result_user['telefone'];} ?>">
                    </div>
                    <div class="col d-flex flex-column gap-1">
                        <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Senha" required value="<?php if(isset($result_user['senha'])){echo $result_user['senha'];} ?>">
                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control form-control-sm" placeholder="Senha confirm:" required value="<?php if(isset($result_user['senha'])){echo $result_user['senha'];} ?>">
                        <div>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-success" type="submit" name="submit" id="submit" onclick="SenhaConfirm(event)"><i class="fa-solid fa-user-plus mx-2"></i>Adicionar</button>
                                <button class="btn btn-primary" type="button" onclick="Clean()" id="limpar"><i class="fa-solid fa-broom mx-2"></i>Limpar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <table class="w-100">
                        <theade>
                            <tr>
                                <th>Nº</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>...</th>
                            </tr>
                        </theade>
                        <tbody>
                            <tr>
                                <?php
                                    //realizando consulta(retornando tudo) na instancia aberta anteriormente
                                    $sql = $pdoInstance->prepare('SELECT * FROM usuario');
                                    $sql->execute();
                                    $fechUsuarios = $sql->fetchAll();
            
                                    //se ouver registro neste a linha será populada com os dados
                                    if ($fechUsuarios) {
                                        $count = 1;
                                        foreach ($fechUsuarios as $row) {
                                            echo '<tr>';
                                            echo '<td>'.$row['id'].'</td>';
                                            echo '<td>'.$row['nome'].'</td>';
                                            echo '<td>'.$row['email'].'</td>';
                                            echo '<td>'.$row['telefone'].'</td>';
                                            echo '<td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a class="btn btn-danger" href="?delete='.$row['id'].'">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                        <a class="btn btn-secondary" href="edit.php?id='.$row['id'].'">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                    </div>
                                                </td>';
                                            echo '</tr>';
                                            $count++;
                                        }
                                    } else {
                                        echo '<tr>';
                                        echo '<td colspan="5">Nenhum registro encontrado</td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </main>
</body>
</html>