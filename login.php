<?php 
include_once('database.php');

if (isset($_COOKIE['email']) && isset($_SESSION['logado'])) {
    header("Location: main.php");
    exit();
}

function clear($input) {
    global $connect;
    $input = (string)$input;
    $var = mysqli_escape_string($connect, $input);
    $var = htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
    return $var;
}

if (isset($_POST['login'])) {
    $email = clear($_POST['email']);
    $senha =   md5($_POST['senha']) ;
    
    $sql = "SELECT * FROM usuarios WHERE email = '{$email}' and senha = '{$senha}'";
    $stmt = mysqli_prepare($connect, $sql);
    $resultado = mysqli_query($connect,$sql);
    $usuario = mysqli_fetch_assoc($resultado);
    if ($usuario){

        session_start();
            $_SESSION['logado'] = true;
            $_SESSION['email'] = $email;
            setcookie('email', $email, time() + (86400 * 30), "/");
            $_SESSION['senha'] = $senha;
            setcookie('senha', $senha, time() + (86400 * 30), "/");
            
            header("Location: main.php");
            exit();

    }
   
 
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
   
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
     
        .input-field input:focus {
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
                        <span class="card-title center">Login</span>
                        <form method="post" >
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
                                <input type="submit" name="login" value="Entrar" class="btn waves-effect waves-light">
                            </div>
                        </form>
                        <div class="center" style="margin-top: 20px;">
                            <a href="index.php" class="waves-effect waves-light btn-flat">Cadastrar</a>
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