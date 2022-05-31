<html>
    <?php
    
    include('C:/xampp/htdocs/Proyecto/controller/config.php');
    session_start();
    
    if (isset($_POST['delete_user'])) {
        if (isset($_GET['usr'])){
            $id = $_GET['usr'];
    
            $query = $connection->prepare("DELETE FROM user WHERE id=:id");
            $query->bindParam("id", $id, PDO::PARAM_STR);
            $query->execute();

            header('Location: ./users_page.php?usr=1');
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
                            <a  href="./users_page.html"><img src="../images/casa.svg" width="15%"/></a>
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
                    <?php
                    
                        if (isset($_GET['usr'])) {
                            ?>
                            <div style="width: 10%;">
                                <a  href="./users_page.html"><img src="../images/edit-free-icon-font.svg" width="15%"/></a>
                            </div>
                            <div style="width: 10%;">
                                <a  href="./users_page.html"><img src="../images/trash-free-icon-font.svg" width="15%"/></a>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div style="width: 100%; height: 90%; display: flex; flex-direction: row;">
                    <div style="width: 30%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; margin-top: 10%;">
                        <span style="font-size: xx-large; width: 100%;">Foto</span>
                    </div>
                    <div style="width: 70%; margin: 5%;">
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
                                            <td>Nombres: <?php echo $row['names']; ?></td>
                                            <td>Apellidos: <?php echo $row['lastnames']; ?></td>
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
                                            <td>Correo electronico: <?php echo $row['email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Cambiar contraseña</td>
                                        </tr>
                                        <tr>
                                            <td>Descripcion: <?php echo $row['description']; ?></td>
                                        </tr>
                                        <?php
                                        }
                                    }
                                ?>
                            </table>
                        </div>

                        <div style="width: 80%; height: 13%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                            <form method="POST" action="" name="form-dlete-user">
                                <?php
                                    if (isset($_GET['usr'])) {
                                        $usr_id = $_GET['usr'];
                                        ?>
                                        <button type="submit" name="delete_user" value="delete_user" style="margin: 5%; border-radius: 5px; background-color: black; color: white; width: 60%">Eliminar</button>
                                        <a href="users_page.php?usr=<?php echo $usr_id;?>" class="button">Cancelar</a>
                                        <?php
                                    }
                                ?>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
