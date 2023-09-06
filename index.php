<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <script type="text/javascript" src="/js/script.js" defer></script>
    <script src="https://kit.fontawesome.com/c3cffe3b5e.js" crossorigin="anonymous" defer></script>
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon" />
    <title>.::PHP::.</title>
</head>
<body>
    <div class="main">
        <?php
            //importando arquivo de conexão
            include_once('config.php'); 

            //criando instancia da classe e chamando metodo que retornar um objeto da conexão
            $conexao = new Connection();
            $pdoInstance = $conexao->getConnection();

            //ações de crud
            if(!empty($_GET['id'])){
                $id = $_GET['id'];

                $sql = "SELECT * FROM usuario WHERE id=$id";
                $result = $pdoInstance->prepare($sql);
                $result->execute();
                
                if(($result) and ($result->rowCount() != 0)){
                    $result_user = $result->fetch(PDO::FETCH_ASSOC);
                }
            }

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
                    
                        echo $stmt->rowCount();
            
                    } catch(PDOException $e) {
                        echo 'Error: ' . $e->getMessage();
                    }
                }
                else{
                    echo "dados insuficientes para realizar cadastro!";
                }
            }

            if(isset($_GET['delete'])){
                $id = (int)$_GET['delete'];
                $pdoInstance->exec("DELETE FROM usuario WHERE id=$id");
            }

            if(isset($_POST['editar'])){
                $id = $_POST['editar'];

                if(!empty($id)){
                    $name = $_POST['name']; 
                    $email = $_POST['email'];
                    $tel = $_POST['tel'];
                    $password = $_POST['password'];
    
    
                    $result = $pdoInstance->prepare("UPDATE usuario SET nome=:nome, emaiL=:email, telefone=:telefone, senha=:senha WHERE id=:id");
    
                    $result->execute(array(
                        ':id' => $id,
                        ':nome' => $name,
                        ':email' => $email,
                        ':tel' => $tel,
                        ':password' => $password
                    ));
                }else{
                    echo "algo deu errado no if para realizar o update";
                }
            }
        ?>

        <form action="index.php" method="POST">
            <div class="formulario">
                <img src="/img/add.png" alt="" class="img">
                <input type="text" name="name" id="name" placeholder="Nome:" required value="<?php if(isset($result_user['nome'])){echo $result_user['nome'];} ?>">
                <input type="email" name="email" id="email" placeholder="E-mail:" required value="<?php if(isset($result_user['email'])){echo $result_user['email'];} ?>">
                <input type="tel" name="tel" id="tel" placeholder="Telefone:" value="<?php if(isset($result_user['telefone'])){echo $result_user['telefone'];} ?>">
                <input type="password" name="password" id="password" placeholder="Senha" required value="<?php if(isset($result_user['senha'])){echo $result_user['senha'];} ?>">
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Senha confirm:" required value="<?php if(isset($result_user['senha'])){echo $result_user['senha'];} ?>">
                <div>
                    <button class="btn" type="submit" name="submit" id="submit" onclick="SenhaConfirm(event)">Adicionar</button>
                    <button class="btn" type="submit" href="?editar=<?php echo $result_user['id'];?>">Editar</button>
                    <button class="btn" type="button" onclick="Clean()"><i class="fa-solid fa-broom"></i></button>
                </div>
            </div>
        </form>

        <table>
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
                                echo '<td><a href="?delete='.$row['id'].'"><i class="fa-solid fa-trash"></i></a> | <a href="index.php?id='.$row['id'].'"><i class="fa-solid fa-pen"></i></a></td>';
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
</body>
</html>