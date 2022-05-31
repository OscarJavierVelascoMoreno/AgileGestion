<html>
    <?php
    
        include('C:/xampp/htdocs/Proyecto/controller/config.php');
        session_start();
        
        if (isset($_POST['edit_project'])) {
            if (isset($_GET['prj'])){
                $id = $_GET['prj'];
                $name = $_POST['name'];
                $user_id = $_POST['user_selection'];
                $description = $_POST['description'];

                if(!$user_id){
                    echo '<script>alert("Debe seleccionar un lider valido!")</script>';
                }
                if(!$description){
                    echo '<script>alert("Debe ingresar una descripcion del proyecto!")</script>';
                }

                $query_validation = $connection->prepare("SELECT * FROM project WHERE name=:name AND NOT id=:id");
                $query_validation->bindParam("name", $name, PDO::PARAM_STR);
                $query_validation->bindParam("id", $id, PDO::PARAM_STR);
                $query_validation->execute();
            
                if ($query_validation->rowCount() > 0) {
                    echo '<script>alert("Ya existe un proyecto con este nombre!")</script>';
                }
        
                $query = $connection->prepare("UPDATE project SET name=:name, user_id=:user_id, description=:description WHERE id=:id");
                $query->bindParam("id", $id, PDO::PARAM_STR);
                $query->bindParam("name", $name, PDO::PARAM_STR);
                $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
                $query->bindParam("description", $description, PDO::PARAM_STR);
                $query->execute();
                
                if ($query_validation->rowCount() <= 0) {
                    header("Location: ./project_page.php?prj=$id");
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
                        <td class="td_list">
                            <a  href="./project_new.php"><img src="../images/agregar-documento.svg" width="15%"/></a>
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
                        <?php
                        
                            if (isset($_GET['prj'])) {
                                $prj_id = $_GET['prj'];
                                $sql="SELECT * FROM project WHERE id=$prj_id";
                                $result=mysqli_query($conection,$sql);
                                while($row = $result->fetch_array()){
                                ?>
                                <span style="font-size: xx-large;"><?php echo $row['name']; ?></span>
                                <?php
                                }
                            }
                            else
                            {
                                ?>
                                <span style="font-size: xx-large;">Proyecto</span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <div style="width: 100%; height: 90%; display: flex; flex-direction: row;">
                    <div style="width: 30%; border-right: 1px solid black; text-align: center;">
                        <ul style="list-style-type: none; background-color: #979EA8;">
                            <?php

                                if (isset($_GET['prj'])) {
                                    $prj_id = $_GET['prj'];
                                    $conection = Conectarse();

                                    $sql="SELECT * FROM user_story WHERE project_id=$prj_id";
                                    $result=mysqli_query($conection,$sql);
                                    while($row = $result->fetch_array()){
                                        ?>
                                        <li><a href="?usy=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
                                        <?php
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div style="width: 70%; margin: 5%;">
                        <form method="POST" action="" name="form-edit-project">
                            <div style="width: 80%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                                <table style="width: 100%; margin: 5%; ">
                                    <tr>
                                        <td colspan="3">
                                            <?php
                                                $conection = Conectarse();
                                                $prj_usr_id = 0;

                                                $prj_id = $_GET['prj'];
                                                $sql="SELECT * FROM project WHERE id=$prj_id";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = $result->fetch_array()){
                                                    ?>
                                                    Nombre del Proyecto: <input name="name" value="<?php echo $row['name']?>" required pattern="^[A-Za-z 0-9]{1,32}$" type="text" style="border-radius: 5px; text-align: center; width: 60%;" placeholder="Digite el nombre del proyecto" title="Solo se permiten letras y numeros en el campo de nombre.">
                                                    <?php
                                                }
                                                ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lider del Proyecto:
                                            <select id="user_selection" name="user_selection">
                                            <option value = ""></option>
                                            <?php
                                                $conection = Conectarse();
                                                $prj_usr_id = 0;

                                                $prj_id = $_GET['prj'];
                                                $sql="SELECT * FROM project WHERE id=$prj_id";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = $result->fetch_array()){
                                                    $prj_usr_id = $row['user_id'];
                                                }

                                                $sql="SELECT * FROM user";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = mysqli_fetch_array($result)) {
                                                    if($row['id'] == $prj_usr_id){
                                                        ?>
                                                        <option selected="selected" value="<?php echo $row['id']?>"><?php echo $row['names']?> <?php echo $row['lastnames']?></option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <option value="<?php echo $row['id']?>"><?php echo $row['names']?> <?php echo $row['lastnames']?></option>
                                                        <?php
                                                    }
                                                }
                                            ?> 
                                            </select>
                                        </td>
                                        <td>Metodologia de proyecto: Scrum</td>
                                        <td>Abierto</td>
                                    </tr>
                                </table>
                            </div>
                            <div style="width: 80%; height: 50%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                                <table style="width: 100%; margin: 5%; ">
                                    <tr>
                                        <td>
                                            <?php
                                                $conection = Conectarse();

                                                $id = $_GET['prj'];
                                                $sql="SELECT * FROM project WHERE id=$id";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = $result->fetch_array()){
                                                    ?>
                                                    Descripcion (Opcional): <br/>
                                                    <textarea name="description" type="text" style="border-radius: 5px; text-align: center; width: 60%;"><?php echo $row['description']?></textarea>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <button type="submit" name="edit_project" value="edit_project" style="margin: 5%; border-radius: 5px; background-color: black; color: white; width: 20%">Guardar</button>
                            <?php
                                if (isset($_GET['prj'])) {
                                    $id = $_GET['prj'];
                                    ?>
                                    <a href="project_page.php?prj=<?php echo $id?>" class="button">Cancelar</a>
                                    <?php
                                }
                                ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
