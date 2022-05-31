<html>
    <?php
    
    include('C:/xampp/htdocs/AgileGestion/controller/config.php');
    session_start();
    
    if (isset($_POST['new_user'])) {
    
        $names = $_POST['names'];
        $lastnames = $_POST['lastnames'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $description = $_POST['description'];
    
        $query = $connection->prepare("SELECT * FROM user WHERE EMAIL=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
    
        if ($query->rowCount() > 0) {
            echo '<script>alert("Este correo electronico ya se encuentra registrado!")</script>';
        }
    
        if ($query->rowCount() == 0) {
            $query = $connection->prepare("INSERT INTO user(names,lastnames,email,password,description) VALUES (:names,:lastnames,:email,:password_hash,:description)");
            $query->bindParam("names", $names, PDO::PARAM_STR);
            $query->bindParam("lastnames", $lastnames, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam("description", $description, PDO::PARAM_STR);
            $result = $query->execute();
    
            if ($result) {
                echo '<script>alert("Registro exitoso!")</script>';
                header('Location: ./user_page.php');
            } else {
                echo '<script>alert("Algo salio mal!")</script>';
            }
        }
    }

    ?>
    <head>
        <title>
            Usuarios
        </title>
        <link rel="stylesheet" href="../style/css/page_style.css">
    </head>
    <body>
        <div class="main_div">
            <div style="width: 20%; border-right: 2px solid black; height: 100%;">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td class="td_list" colspan="3">
                            <a  href="./main_menu.php"><img src="../images/casa.svg" width="15%"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_list">
                            <a  href="./user_page.php?usr=1"><img src="../images/alinear-justificar.svg" width="15%"/></a>
                        </td>
                    </tr>
                </table> 
                <ul>
                    <?php

                        include('C:/xampp/htdocs/AgileGestion/controller/conectarse.php');
                        Conectarse();
                        
                        $conection = Conectarse();
                        $sql="SELECT * FROM user";
                        $result=mysqli_query($conection,$sql);
                        while($row = $result->fetch_array()){
                            ?>
                            <li><a href="user_page.php?usr=<?php echo $row['id']; ?>"><?php echo $row['names']; ?> <?php echo $row['lastnames']; ?></a></li>
                            <?php
                        }
                        ?>
                </ul>
            </div>
            <div style="width: 80%; height: 100%;">
                <div style="width: 100%; height: 5%; border-bottom: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center;">
                    <span style="font-size: xx-large; width: 100%;">Usuarios</span>
                </div>
                <div class="main" style="width: 100%; height: 5%; border-bottom: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; background-color: #282C33; color: white;">
                    <div style="width: 80%; text-align: center; display: flex; justify-content: center; align-items: center;">
                        <span style="font-size: xx-large;"></span>Usuario Nuevo</span>
                    </div>
                </div>
                <div style="width: 100%; height: 90%; display: flex; flex-direction: row;">
                    <form method="POST" action="" name="form-new-user">

                        <div style="width: 100%; margin: 5%;">
                            <div style="width: 100%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                                <table style="width: 100%; margin: 5%; ">
                                    <tr>
                                        <td>Nombres: <input name="names" required pattern="^[A-Za-z ]{1,32}$" type="text" style="border-radius: 5px; text-align: center; width: 80%;" placeholder="Digite sus nombres" title="Solo se permiten letras en el campo de nombres."></td>
                                    </tr>
                                    <tr>
                                        <td>Apellidos: <input name="lastnames" required pattern="^[A-Za-z ]{1,32}$" type="text" style="border-radius: 5px; text-align: center; width: 80%;" placeholder="Digite sus apellidos" title="Solo se permiten letras en el campo de apellidos."></td>
                                    </tr>
                                </table>
                            </div>
                            <div style="width: 100%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                                <table style="width: 100%; margin: 5%; ">
                                    <tr>
                                        <td>Correo electronico: <input name="email" type="text" style="border-radius: 5px; text-align: center; width: 60%;" placeholder="Digite su email" required pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$" title="El correo debe tener la forma xxx@xxx.xxx"></td>
                                    </tr>
                                    <tr>
                                        <td>Digite la contraseña: <input name="password" type="password" style="border-radius: 5px; text-align: center; width: 60%;" placeholder="Digite una contraseña" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,12}$" title="La contraseña debe contener un caracter especial(!@#$%^&*_=+-), una letra mayuscula, un numero y debe tener minimo 8 caracteres maximo 12."></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Digite una descripción (Opcional): 
                                            <textarea name="description" type="text" style="border-radius: 5px; text-align: center; width: 60%;"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <button type="submit" name="new_user" value="new_user" style="margin: 5%; border-radius: 5px; background-color: black; color: white; width: 60%">Guardar</button>
                            <button type="reset" name="reset" value="reset" style="margin: 5%; border-radius: 5px; background-color: black; color: white; width: 60%">Limpiar</button>
                            <a href="user_page.php?usr=1" class="button">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
