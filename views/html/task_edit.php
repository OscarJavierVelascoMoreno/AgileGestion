<html>
    <?php
        
        include('C:/xampp/htdocs/AgileGestion/controller/config.php');
        session_start();
        
        if (isset($_POST['edit_task'])) {
            if (isset($_GET['tsk'])){
        
                $id = $_GET['tsk'];
                $name = $_POST['name'];
                $user_story_id = $_POST['user_story_selection'];
                $user_id = $_POST['user_selection'];
                $description = $_POST['description'];
                $estimated_time = $_POST['estimated_time'];
                $time_spent = $_POST['time_spent'];
                $time_left = $_POST['time_left'];
                $qualification = $_POST['qualification'];

                if(!$user_id){
                    echo '<script>alert("Debe seleccionar un responsable valido!")</script>';
                }
                if(!$user_story_id){
                    echo '<script>alert("Debe seleccionar una HU valida!")</script>';
                }

                $query_validation = $connection->prepare("SELECT * FROM task WHERE name=:name AND user_story_id=:user_story_id AND NOT id=:id");
                $query_validation->bindParam("id", $id, PDO::PARAM_STR);
                $query_validation->bindParam("name", $name, PDO::PARAM_STR);
                $query_validation->bindParam("user_story_id", $user_story_id, PDO::PARAM_STR);
                $query_validation->execute();
            
                if ($query_validation->rowCount() > 0) {
                    echo '<script>alert("Ya existe una tarea para esta historia de usuario con este nombre!")</script>';
                }
        
                if ($query_validation->rowCount() == 0 AND $user_story_id AND $user_id) {
                    $query = $connection->prepare("UPDATE task SET name=:name, user_story_id=:user_story_id, user_id=:user_id,  description=:description, estimated_time=:estimated_time, time_spent=:time_spent, time_left=:time_left, qualification=:qualification WHERE id=:id");
                    $query->bindParam("id", $id, PDO::PARAM_STR);
                    $query->bindParam("name", $name, PDO::PARAM_STR);
                    $query->bindParam("user_story_id", $user_story_id, PDO::PARAM_STR);
                    $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
                    $query->bindParam("description", $description, PDO::PARAM_STR);
                    $query->bindParam("estimated_time", $estimated_time, PDO::PARAM_STR);
                    $query->bindParam("time_spent", $time_spent, PDO::PARAM_STR);
                    $query->bindParam("time_left", $time_left, PDO::PARAM_STR);
                    $query->bindParam("qualification", $qualification, PDO::PARAM_STR);
                    $result = $query->execute();
            
                    if ($result) {
                        echo '<script>alert("Registro exitoso!")</script>';
                        header("Location: ./task_page.php?tsk=$id");
                    } else {
                        echo '<script>alert("Algo salio mal!")</script>';
                    }
                }

            }
        }

    ?>
    <head>
        <title>
            Tareas
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
                            <a  href="./task_page.html"><img src="../images/alinear-justificar.svg" width="15%"/></a>
                        </td>
                        <td class="td_list">
                            <a  href="./task_new.html"><img src="../images/agregar-documento.svg" width="15%"/></a>
                        </td>
                    </tr>
                </table> 
                <ul style="background-color: #979EA8;">
                    <?php
                        include('C:/xampp/htdocs/AgileGestion/controller/conectarse.php');
                        Conectarse();

                        $conection = Conectarse();
                        
                        $sql="SELECT * FROM project";
                        $result_project=mysqli_query($conection,$sql);
                        while($row = $result_project->fetch_array()){
                            $prj_id=$row['id'];
                            ?>
                            <li><a href="./project_page.php?prj=<?php echo $row['id']; ?>">Proyecto: <?php echo $row['name']; ?></a></li>
                            <ul style="background-color: #B7B9BD;">
                            <?php
                            $sql="SELECT * FROM user_story WHERE project_id=$prj_id";
                            $result_user_story=mysqli_query($conection,$sql);
                            while($row = $result_user_story->fetch_array()){
                                $usy_id = $row['id'];
                                ?>
                                    <li><a href="./user_story_page.php?usy=<?php echo $row['id']; ?>">HU: <?php echo $row['name']; ?></a></li>
                                    <ul style="background-color: #CED4DB;">
                                    <?php
                                        $sql="SELECT * FROM task WHERE user_story_id=$usy_id";
                                        $result=mysqli_query($conection,$sql);
                                        while($row = $result->fetch_array()){
                                            ?>
                                            <li><a href="./task_page.php?tsk=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
                                            <?php
                                        }   
                                    ?>
                                    </ul>
                                <?php
                            }   
                            ?>
                            </ul>
                            <?php
                        }
                    ?>
                </ul>
            </div>
            <div style="width: 80%; height: 100%;">
                <div style="width: 100%; height: 5%; border-bottom: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center;">
                    <span style="font-size: xx-large; width: 100%;">Tareas</span>
                </div>
                <div class="main" style="width: 100%; height: 5%; border-bottom: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; background-color: #282C33; color: white;">
                    <div style="width: 80%; text-align: center; display: flex; justify-content: center; align-items: center;">
                        <?php
                            
                            if (isset($_GET['tsk'])) {
                                $tsk_id = $_GET['tsk'];
                                $sql="SELECT * FROM task WHERE id=$tsk_id";
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
                                <span style="font-size: xx-large;">Tarea</span>
                                <?php
                            }
                        ?>
                    </div>
                    <?php
                    
                        if (isset($_GET['tsk'])) {
                            $tsk_id = $_GET['tsk'];
                            ?>
                            <div style="width: 10%;">
                                <a  href="./task_edit.php?tsk=<?php echo $tsk_id;?>"><img src="../images/edit-free-icon-font.svg" width="15%"/></a>
                            </div>
                            <div style="width: 10%;">
                                <a  href="./task_delete.php?tsk=<?php echo $tsk_id;?>"><img src="../images/trash-free-icon-font.svg" width="15%"/></a>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div style="width: 100%; height: 90%; display: flex; flex-direction: row;">
                    <div style="width: 100%; margin: top 0 right 5% left 5% down 0;">
                        <form method="POST" action="" name="form-new-task">
                            <div style="width: 90%; height: 10%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                                <table style="width: 50%; margin: 5%; ">
                                    <tr>

                                    <?php
                                
                                        if (isset($_GET['tsk'])) {
                                            $tsk_id = $_GET['tsk'];
                                            $sql="SELECT * FROM task WHERE id=$tsk_id";
                                            $result=mysqli_query($conection,$sql);
                                            while($row = $result->fetch_array()){
                                            ?>
                                                <td colspan="3">Nombre de la Tarea: <input value="<?php echo $row['name']?>" name="name" required pattern="^[A-Za-z 0-9]{1,32}$" type="text" style="border-radius: 5px; text-align: center; width: 70%;" placeholder="Digite el nombre de la tarea" title="Solo se permiten letras y numeros en el campo de nombre."></td>
                                            <?php
                                            }
                                        }
                                    ?>
                                    </tr>
                                    <tr>
                                        <td>HU:
                                            <select id="user_story_selection" name="user_story_selection">
                                            <option value = ""></option>
                                            <?php
                                                $conection = Conectarse();
                                                $tsk_usy_id = 0;

                                                $tsk_id = $_GET['tsk'];
                                                $sql="SELECT * FROM task WHERE id=$tsk_id";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = $result->fetch_array()){
                                                    $tsk_usy_id = $row['user_story_id'];
                                                }

                                                $sql="SELECT * FROM project";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = mysqli_fetch_array($result)) {
                                                    $prj_id = $row['id'];
                                                    $usy_sql="SELECT * FROM user_story WHERE project_id=$prj_id";
                                                    $usy_result=mysqli_query($conection,$usy_sql);
                                                    while($usy_row = mysqli_fetch_array($usy_result)) {
                                                        if($usy_row['id'] == $tsk_usy_id){
                                                            ?>
                                                            <option selected="selected" value="<?php echo $usy_row['id']?>"><?php echo $row['name']?>: <?php echo $usy_row['name']?></option>
                                                            <?php
                                                        }
                                                        else{
                                                            ?>
                                                            <option value="<?php echo $usy_row['id']?>"><?php echo $row['name']?>: <?php echo $usy_row['name']?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            ?> 
                                            </select>
                                        </td>
                                        <td>Responsable:
                                            <select id="user_selection" name="user_selection">
                                            <option value = ""></option>
                                            <?php
                                                $conection = Conectarse();
                                                $tsk_usr_id = 0;

                                                $tsk_id = $_GET['tsk'];
                                                $sql="SELECT * FROM task WHERE id=$tsk_id";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = $result->fetch_array()){
                                                    $tsk_usr_id = $row['user_id'];
                                                }

                                                $sql="SELECT * FROM user";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = mysqli_fetch_array($result)) {
                                                    if($row['id'] == $tsk_usr_id){
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
                                        <td>Abierto</td>
                                    </tr>
                                </table>
                            </div>
                            <div style="width: 90%; height: 30%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                            <table style="width: 100%; margin: 5%; ">
                                    <tr>
                                        <td>
                                            <?php
                                                $conection = Conectarse();

                                                $id = $_GET['tsk'];
                                                $sql="SELECT * FROM task WHERE id=$id";
                                                $result=mysqli_query($conection,$sql);
                                                while($row = $result->fetch_array()){
                                                    ?>
                                                    Descripcion: <br/>
                                                    <textarea name="description" type="text" style="border-radius: 5px; text-align: center; width: 60%;"><?php echo $row['description']?></textarea>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div style="width: 90%; height: 10%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                                <table style="width: 80%; margin: 5%; ">
                                    <?php
                                        $conection = Conectarse();
                                        $tsk_id = $_GET['tsk'];
                                        
                                        $sql="SELECT * FROM task WHERE id=$tsk_id";
                                        $result=mysqli_query($conection,$sql);
                                        while($row = $result->fetch_array()){
                                        ?>
                                                <td>Tiempo Estimado: <input type="number" value="<?php echo $row['estimated_time']; ?>" required name="estimated_time" min=".01" step=".01"></td><br>
                                                <td>Tiempo Invertido: <input type="number" value="<?php echo $row['time_spent']; ?>" required name="time_spent" min=".01" step=".01"></td><br>
                                            </tr>
                                            <tr>
                                                <td>Tiempo Restante: <input type="number" value="<?php echo $row['time_left']; ?>" required name="time_left" min=".01" step=".01"></td><br>
                                                <td>Calificación <input type="number" value="<?php echo $row['qualification']; ?>" required name="qualification" min=".01" step=".01"></td>
                                        <?php
                                        }
                                    ?>
                                </table>
                            </div>

                            
                            <button type="submit" name="edit_task" value="edit_task" style="margin: 5%; border-radius: 5px; background-color: black; color: white; width: 20%">Guardar</button>
                            <?php
                                if (isset($_GET['tsk'])) {
                                    $id = $_GET['tsk'];
                                    ?>
                                    <a href="task_page.php?tsk=<?php echo $id?>" class="button">Cancelar</a>
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
