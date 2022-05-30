<html>
    <?php
        
        include('C:/xampp/htdocs/Proyecto/controller/config.php');
        session_start();
    
        if (isset($_POST['login'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $query = $connection->prepare("SELECT * FROM usuario WHERE email=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                echo '<script>alert("El email ingresado no se encuentra registrado!")</script>';
            } else {
                if (password_verify($password, $result['password'])) {
                    $_SESSION['user_id'] = $result['id'];
                    echo '<script>alert("Ha ingresado sin problemas!")</script>';
                    header('Location: ./new_user.php');
                } else {
                    echo '<script>alert("La combinacion de contraseña y correo es incorrecta!")</script>';
                }
            }
        }
    
    ?>
    <head>
        <title>
            Ingresar
        </title>
        <link rel="stylesheet" href="../style/css/login_style.css">
    </head>
    <body>
        <form method="POST" action="" name="form-login">
            <table class="center" style="background-color: #E7E8EC; height: fit-content; width: 15%;">
                <tr>
                    <td class="circle center">
                        Foto
                    </td>
                </tr>
                <tr>
                    <td class="login_td" style="padding-top: 15%;">
                        <input name="email" type="text" required pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$" title="El correo debe tener la forma xxx@xxx.xxx" style="border-radius: 5px; text-align: center; width: 80%;" placeholder="Digite su email">
                    </td>
                </tr>
                <tr>
                    <td class="login_td" style="padding-bottom: 5%; padding-top: 3%;">
                        <input name="password" type="password" required style="border-radius: 5px; text-align: center; width: 80%;" placeholder="Digite su contrase&ntilde;a">
                    </td>
                </tr>
                <tr>
                    <td class="login_td" style="padding-top: 5%; padding-bottom: 5%;">
                        <button type="submit" name="login" value="login" style="border-radius: 5px; background-color: black; color: white; width: 50%">Ingresar</button>
                    </td>
                </tr>
            </table>
        </form>       
    </body>
</html>