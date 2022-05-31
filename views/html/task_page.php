<html>
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
                            <a  href="./task_page.php"><img src="../images/alinear-justificar.svg" width="15%"/></a>
                        </td>
                        <td class="td_list">
                            <a  href="./task_new.php"><img src="../images/agregar-documento.svg" width="15%"/></a>
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
                        <div style="width: 80%; height: 10%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                            <table style="width: 50%; margin: 5%; ">
                                <tr>
                                    <?php
                                        if (isset($_GET['tsk'])) {
                                            $tsk_id = $_GET['tsk'];
                                            
                                            $sql="SELECT usy.* FROM user_story AS usy JOIN task AS tsk WHERE usy.id=tsk.user_story_id AND tsk.id=$tsk_id";
                                            $result=mysqli_query($conection,$sql);
                                            while($row = $result->fetch_array()){
                                            ?>
                                                <td>HU: <a href="user_story_page.php?usy=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
                                            <?php
                                            }

                                            $sql="SELECT us.* FROM user AS us JOIN task AS tsk WHERE us.id=tsk.user_id AND tsk.id=$tsk_id";
                                            $result=mysqli_query($conection,$sql);
                                            while($row = $result->fetch_array()){
                                            ?>
                                                <td>Responsable: <a href="user_page.php?usr=<?php echo $row['id']; ?>"><?php echo $row['names']; ?> <?php echo $row['lastnames']; ?></a></td>
                                            <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <td>HU: Historia de Usuario</td>
                                            <td>Responsable: Desarrollador</td>
                                            <?php
                                        }
                                    ?>
                                    <td>Abierto</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 80%; height: 30%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                            <?php
                                if (isset($_GET['tsk'])) {
                                    $tsk_id = $_GET['tsk'];
                                    $sql="SELECT * FROM task WHERE id=$tsk_id";
                                    $result=mysqli_query($conection,$sql);
                                    while($row = $result->fetch_array()){
                                        ?>
                                        <p style="padding: 5%;">
                                            Descripcion: <br/>
                                            <?php echo $row['description']; ?>
                                        </p>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <p style="padding: 5%;">
                                        Descripcion: <br/>

                                        Lorem ipsum dolor sit amet consectetur adipiscing elit, dui gravida dictumst aliquet lacus scelerisque, molestie nam conubia vulputate dapibus sodales. Tristique aliquam fames odio eros montes rhoncus penatibus arcu gravida, nam erat mi iaculis lacus fermentum facilisis nunc, integer proin taciti eu tincidunt varius nisi leo. Litora mollis eu feugiat a taciti enim blandit sollicitudin felis tempor cum magnis, congue massa malesuada hendrerit condimentum senectus ullamcorper ultrices cursus consequat nunc, montes turpis phasellus sem vulputate tristique sapien dignissim conubia urna in.
                                    </p>
                                    <?php
                                }
                            ?>
                        </div>
                        <div style="width: 80%; height: 10%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                            <table style="width: 80%; margin: 5%; ">
                                <tr>
                                    <?php
                                        if (isset($_GET['tsk'])) {
                                            $tsk_id = $_GET['tsk'];
                                            
                                            $sql="SELECT * FROM task WHERE id=$tsk_id";
                                            $result=mysqli_query($conection,$sql);
                                            while($row = $result->fetch_array()){
                                            ?>
                                                    <td>Tiempo Estimado: <?php echo $row['estimated_time']; ?></td><br>
                                                    <td>Tiempo Invertido: <?php echo $row['time_spent']; ?></td><br>
                                                </tr>
                                                <tr>
                                                    <td>Tiempo Restante: <?php echo $row['time_left']; ?></td><br>
                                                    <td>Calificación <?php echo $row['qualification']; ?></td>
                                            <?php
                                            }
                                        }
                                        else
                                        {
                                                ?>
                                                <td>Tiempo Estimado: 5 hrs</td><br>
                                                <td>Tiempo Invertido: 2 hrs</td><br>
                                            </tr>
                                            <tr>
                                                <td>Tiempo Restante: 3 hrs</td><br>
                                                <td>Calificación</td>
                                                <?php
                                        }
                                    ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
