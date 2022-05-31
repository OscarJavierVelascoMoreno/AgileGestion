<html>
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
                            <a  href="./main_menu.php"><img src="../images/casa.svg" width="15%"/></a>
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
                        include('C:/xampp/htdocs/AgileGestion/controller/conectarse.php');
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
                    <?php
                    
                        if (isset($_GET['prj'])) {
                            $prj_id = $_GET['prj'];
                            ?>
                            <div style="width: 10%;">
                                <a  href="./project_edit.php?prj=<?php echo $prj_id;?>"><img src="../images/edit-free-icon-font.svg" width="15%"/></a>
                            </div>
                            <div style="width: 10%;">
                                <a  href="./project_delete.php?prj=<?php echo $prj_id;?>"><img src="../images/trash-free-icon-font.svg" width="15%"/></a>
                            </div>
                            <?php
                        }
                    ?>
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
                                        <li><a href="user_story_page.php?usy=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
                                        <?php
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div style="width: 70%; margin: 5%;">
                        <div style="width: 80%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                            <table style="width: 100%; margin: 5%; ">
                                <tr>
                                    <?php
                                        if (isset($_GET['prj'])) {
                                            $prj_id = $_GET['prj'];
                                            $sql="SELECT us.* FROM user AS us JOIN project AS prj WHERE us.id=prj.user_id AND prj.id=$prj_id";
                                            $result=mysqli_query($conection,$sql);
                                            while($row = $result->fetch_array()){
                                            ?>
                                                <td>Lider del Proyecto: <a href="user_page.php?usr=<?php echo $row['id']; ?>"><?php echo $row['names']; ?> <?php echo $row['lastnames']; ?></a></td>
                                            <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <td>Lider del Proyecto: Lider</td>
                                            <?php
                                        }
                                    ?>
                                    <td>Metodologia de proyecto: Scrum</td>
                                    <td>Abierto</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 80%; height: 50%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                            <?php
                                if (isset($_GET['prj'])) {
                                    $prj_id = $_GET['prj'];
                                    $sql="SELECT * FROM project WHERE id=$prj_id";
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
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
