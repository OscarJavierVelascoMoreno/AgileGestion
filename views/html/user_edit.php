<html>
    <?php
    
        include('C:/xampp/htdocs/Proyecto/controller/config.php');
        session_start();
        
        if (isset($_POST['edit_user'])) {
            if (isset($_GET['usr'])){
                $id = $_GET['usr'];
                $names = $_POST['names'];
                $lastnames = $_POST['lastnames'];
                $email = $_POST['email'];
                $description = $_POST['description'];

                $query_validation = $connection->prepare("SELECT * FROM user WHERE EMAIL=:email AND NOT id=:id");
                $query_validation->bindParam("email", $email, PDO::PARAM_STR);
                $query_validation->bindParam("id", $id, PDO::PARAM_STR);
                $query_validation->execute();
            
                if ($query_validation->rowCount() > 0) {
                    echo '<script>alert("Este correo electronico ya se encuentra registrado!")</script>';
                }
        
                $query = $connection->prepare("UPDATE user SET names=:names, lastnames=:lastnames, email=:email, description=:description WHERE id=:id");
                $query->bindParam("id", $id, PDO::PARAM_STR);
                $query->bindParam("names", $names, PDO::PARAM_STR);
                $query->bindParam("lastnames", $lastnames, PDO::PARAM_STR);
                $query->bindParam("email", $email, PDO::PARAM_STR);
                $query->bindParam("description", $description, PDO::PARAM_STR);
                $query->execute();
                
                if ($query_validation->rowCount() <= 0) {
                    header("Location: ./users_page.php?usr=$id");
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
                            <a  href="./users_page.php"><img src="../images/casa.svg" width="15%"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_list">
                            <a  href="./users_page.php?usr=1"><img src="../images/alinear-justificar.svg" width="15%"/></a>
                        </td>
                        <td class="td_list">
                            <a  href="./user_new.php"><img src="../images/agregar-documento.svg" width="15%"/></a>
                        </td>
                    </tr>
                </table>
                <ul>
                    <?php
                        include('C:/xampp/htdocs/Proyecto/controller/conectarse.php');
                        Conectarse();

                        $conection = Conectarse();
                        $sql="SELECT * FROM user";
                        $result=mysqli_query($conection,$sql);
                        while($row = $result->fetch_array()){
                            ?>
                            <li><a href="?usr=<?php echo $row['id']; ?>"><?php echo $row['names']; ?> <?php echo $row['lastnames']; ?></a></li>
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
                    <?php
                    
                        if (isset($_GET['usr'])) {
                            $usr_id = $_GET['usr'];
                            $sql="SELECT * FROM user WHERE id=$usr_id";
                            $result=mysqli_query($conection,$sql);
                            while($row = $result->fetch_array()){
                            ?>
                            <span style="font-size: xx-large;"><?php echo $row['names']; ?> <?php echo $row['lastnames']; ?></span>
                            <?php
                            }
                        }
                        else
                        {
                            ?>
                            <span style="font-size: xx-large;">Usuario 1</span>
                            <?php
                        }
                    ?>
                    </div>
                </div>
                <div style="width: 100%; height: 90%; display: flex; flex-direction: row;">
                    <div style="width: 30%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; margin-top: 10%;">
                        <span style="font-size: xx-large; width: 100%;">Foto</span>
                    </div>
                    <div style="width: 70%; margin: 5%;">
                        <form method="POST" action="" name="form-login">
                            <div style="width: 80%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                                <table style="width: 100%; margin: 5%; ">
                                    <tr>
                                        <?php
                                            if (isset($_GET['usr'])) {
                                                $usr_id = $_GET['usr'];
                                                $sql="SELECT * FROM user WHERE id=$usr_id";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = $result->fetch_array()){
                                                    ?>
                                                    <td>Nombres: <input name="names" value="<?php echo $row['names']; ?>" required pattern="^[A-Za-z ]{1,32}$" type="text" style="border-radius: 5px; text-align: center; width: 80%;" placeholder="Digite sus nombres" title="Solo se permiten letras en el campo de nombres."></td>
                                                    <td>Apellidos: <input name="lastnames" value="<?php echo $row['lastnames']; ?>" required pattern="^[A-Za-z ]{1,32}$" type="text" style="border-radius: 5px; text-align: center; width: 80%;" placeholder="Digite sus apellidos" title="Solo se permiten letras en el campo de apellidos."></td>
                                                    <td>Perfil: Desarrollador</td>
                                                    <td>Activo</td>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </tr>
                                </table>
                            </div>
                            <div style="width: 80%; height: 20%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                                <table style="width: 100%; margin: 5%; ">
                                    <?php
                                        if (isset($_GET['usr'])) {
                                            $usr_id = $_GET['usr'];
                                            $sql="SELECT * FROM user WHERE id=$usr_id";
                                            $result=mysqli_query($conection,$sql);
                                            while($row = $result->fetch_array()){
                                                ?>
                                                <tr>
                                                    <td>Correo electronico: <input name="email" value="<?php echo $row['email']; ?>" type="text" style="border-radius: 5px; text-align: center; width: 60%;" placeholder="Digite su email" required pattern="^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$" title="El correo debe tener la forma xxx@xxx.xxx"></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Descripcion: 
                                                        <textarea name="description" type="text" style="border-radius: 5px; text-align: center; width: 60%;"><?php echo $row['description']; ?></textarea>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    ?>
                                </table>
                            </div>

                            <div style="width: 80%; height: 13%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                                <?php
                                    if (isset($_GET['usr'])) {
                                        $usr_id = $_GET['usr'];
                                        ?>
                                        <button type="submit" name="edit_user" value="edit_user" style="margin: 5%; border-radius: 5px; background-color: black; color: white; width: 60%">Guardar</button>
                                        <a href="users_page.php?usr=<?php echo $usr_id;?>" class="button">Cancelar</a>
                                        <?php
                                    }
                                ?>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
