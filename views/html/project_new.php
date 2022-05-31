<html>
    <?php
        
        include('C:/xampp/htdocs/Proyecto/controller/config.php');
        session_start();
        
        if (isset($_POST['new_project'])) {
        
            $name = $_POST['name'];
            $user_id = $_POST['user_selection'];
            $description = $_POST['description'];

            if(!$user_id){
                echo '<script>alert("Debe seleccionar un lider valido!")</script>';
            }
            if(!$description){
                echo '<script>alert("Debe ingresar una descripcion del proyecto!")</script>';
            }
        
            $query = $connection->prepare("SELECT * FROM project WHERE name=:name");
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->execute();
        
            if ($query->rowCount() > 0) {
                echo '<script>alert("Ya existe un proyecto con este nombre!")</script>';
            }
        
            if ($query->rowCount() == 0 AND $user_id AND $description) {
                $query = $connection->prepare("INSERT INTO project(name,user_id,description) VALUES (:name,:user_id,:description)");
                $query->bindParam("name", $name, PDO::PARAM_STR);
                $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
                $query->bindParam("description", $description, PDO::PARAM_STR);
                $result = $query->execute();
        
                if ($result) {
                    echo '<script>alert("Registro exitoso!")</script>';
                    header('Location: ./project_page.php');
                } else {
                    echo '<script>alert("Algo salio mal!")</script>';
                }
            }
        }

    ?>
    <head>
        <title>
            Proyectos
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
                            <a  href="./project_page.php"><img src="../images/alinear-justificar.svg" width="15%"/></a>
                        </td>
                    </tr>
                </table> 
                <ul>
                    <?php
                        include('C:/xampp/htdocs/Proyecto/controller/conectarse.php');
                        Conectarse();

                        $conection = Conectarse();
                        $sql="SELECT * FROM project";
                        $result=mysqli_query($conection,$sql);
                        while($row = $result->fetch_array()){
                            ?>
                            <li><a href="?prj=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
            <div style="width: 80%; height: 100%;">
                <div style="width: 100%; height: 5%; border-bottom: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center;">
                    <span style="font-size: xx-large; width: 100%;">Proyectos</span>
                </div>
                <div class="main" style="width: 100%; height: 5%; border-bottom: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; background-color: #282C33; color: white;">
                    <div style="width: 80%; text-align: center; display: flex; justify-content: center; align-items: center;">
                        <span style="font-size: xx-large;">Proyecto Nuevo</span>
                    </div>
                </div>
                <div style="width: 100%; height: 90%; display: flex; flex-direction: row;">
                    <div style="width: 100%; margin: 5%;">
                        <form method="POST" action="" name="form-new-project">
                            <div style="width: 80%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                                <table style="width: 100%; margin: 5%; ">
                                    <tr>
                                        <td colspan="3">Nombre del Proyecto: <input name="name"  required pattern="^[A-Za-z 0-9]{1,32}$" type="text" style="border-radius: 5px; text-align: center; width: 80%;" placeholder="Digite el nombre del proyecto" title="Solo se permiten letras y numeros en el campo de nombre."></td>
                                    </tr>
                                    <tr>
                                        <td>Lider del Proyecto:
                                            <select id="user_selection" name="user_selection">
                                            <option value = ""></option>
                                            <?php
                                                $conection = Conectarse();

                                                $sql="SELECT * FROM user";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value="<?php echo $row['id']?>"><?php echo $row['names']?> <?php echo $row['lastnames']?></option>
                                                    <?php
                                                }
                                            ?> 
                                            </select>
                                        </td>
                                        <td>Metodologia de proyecto: Scrum</td>
                                        <td>Abierto</td>
                                    </tr>
                                </table>
                            </div>
                            <div style="width: 80%; height: 30%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                                <table style="width: 100%; margin: 5%; ">
                                    <tr>
                                        <td>
                                            Descripcion (Opcional): <br/>
                                            <textarea name="description" type="text" style="border-radius: 5px; text-align: center; width: 60%;"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                                
                            <button type="submit" name="new_project" value="new_project" style="margin: 5%; border-radius: 5px; background-color: black; color: white; width: 20%">Guardar</button>
                            <button type="reset" name="reset" value="reset" style="margin: 5%; border-radius: 5px; background-color: black; color: white; width: 20%">Limpiar</button>
                            <a href="project_page.php?prj=1" class="button">Cancelar</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>