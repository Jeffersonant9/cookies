<?php 
include_once('database.php');

if (isset($_COOKIE['email']) && isset($_COOKIE['senha'])) {
    header("Location: main.php");
    exit();
}

function clear($input) {
    global $connect;
    $var = mysqli_escape_string($connect, $input);
    $var = htmlspecialchars($var);
    return $var;
}



if (isset($_POST['enviar'])) {


        
   
        $email_login = clear($_POST['email']);
        $senha_login =   md5($_POST['senha']) ;
        
        $sql = "SELECT * FROM usuarios WHERE email = '{$email_login}' and senha = '{$senha_login}'";
        $stmt = mysqli_prepare($connect, $sql);
        $resultado = mysqli_query($connect,$sql);
        $usuario = mysqli_fetch_assoc($resultado);
    if ($usuario){

    echo(' 
        
       <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
           
    ');

     echo("
        <script>
              window.onload = function() {
                 M.toast({html: 'Usuario invalido'});
             };
           </script>
       ");

      }
     else {



        $nome = clear($_POST['nome']);
            $email = clear($_POST['email']);
            $senha = md5(clear($_POST['senha']));
            
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senha);
            
            if (mysqli_stmt_execute($stmt)) {
                header("Location: login.php");
                exit();
            } else {
                $erro = "Erro ao cadastrar: " . mysqli_error($connect);
            }
            mysqli_stmt_close($stmt);
        }

        


        
    
 
}
 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
   
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>  .input-field input:focus {
            border-bottom: 1px solid #4caf50 !important;
            box-shadow: 0 1px 0 0 #4caf50 !important;
        }
        .input-field input:valid {
            border-bottom: 1px solid #4caf50 !important;
            box-shadow: none !important;
        }
        .input-field input {
            border-bottom: 1px solid #9e9e9e !important; 
            box-shadow: none !important;
        }
        .input-field input:invalid {
            border-bottom: 1px solid #9e9e9e !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title center">Cadastro de Usuário</span>
                        <?php if (isset($erro)): ?>
                            <p class="red-text center"><?php echo $erro; ?></p>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="input-field">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="nome" id="nome" required>
                                <label for="nome">Nome</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email" id="email" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">lock</i>
                                <input type="password" name="senha" id="senha" required>
                                <label for="senha">Senha</label>
                            </div>
                            <div class="center">
                                <input type="submit" name="enviar" value="Enviar" class="btn waves-effect waves-light">
                            </div>
                        </form>
                        <div class="center" style="margin-top: 20px;">
                            <a href="login.php" class="waves-effect waves-light btn-flat">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
    </script>
</body>
</html>