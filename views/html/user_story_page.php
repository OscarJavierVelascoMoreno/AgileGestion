<html>
    <head>
        <title>
            Historias de Usuario
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
                            <a  href="./user_story_page.php"><img src="../images/alinear-justificar.svg" width="15%"/></a>
                        </td>
                        <td class="td_list">
                            <a  href="./user_story_new.php"><img src="../images/agregar-documento.svg" width="15%"/></a>
                        </td>
                    </tr>
                </table> 
                <ul style="background-color: #979EA8;">
                    <?php
                        include('C:/xampp/htdocs/Proyecto/controller/conectarse.php');
                        Conectarse();

                        $conection = Conectarse();
                        $sql="SELECT * FROM project";
                        $result_project=mysqli_query($conection,$sql);
                        while($row = $result_project->fetch_array()){
                            $prj_id = $row['id'];
                            ?>
                                <li><a href="./project_page.php?prj=<?php echo $row['id']; ?>">Proyecto: <?php echo $row['name']; ?></a></li>
                                <ul style="background-color: #CED4DB;">
                                <?php
                                    $sql="SELECT * FROM user_story WHERE project_id=$prj_id";
                                    $result=mysqli_query($conection,$sql);
                                    while($row = $result->fetch_array()){
                                        ?>
                                        <li><a href="./user_story_page.php?usy=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
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
                    <span style="font-size: xx-large; width: 100%;">Historias de Usuario</span>
                </div>
                <div class="main" style="width: 100%; height: 5%; border-bottom: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; background-color: #282C33; color: white;">
                    <div style="width: 80%; text-align: center; display: flex; justify-content: center; align-items: center;">
                        <?php
                            
                            if (isset($_GET['usy'])) {
                                $usy_id = $_GET['usy'];
                                $sql="SELECT * FROM user_story WHERE id=$usy_id";
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
                                <span style="font-size: xx-large;">Historia de Usuario</span>
                                <?php
                            }
                        ?>
                    </div>
                    <?php
                    
                        if (isset($_GET['usy'])) {
                            $usy_id = $_GET['usy'];
                            ?>
                            <div style="width: 10%;">
                                <a  href="./user_story_edit.php?usy=<?php echo $usy_id;?>"><img src="../images/edit-free-icon-font.svg" width="15%"/></a>
                            </div>
                            <div style="width: 10%;">
                                <a  href="./user_story_delete.php?usy=<?php echo $usy_id;?>"><img src="../images/trash-free-icon-font.svg" width="15%"/></a>
                            </div>
                            <?php
                        }
                    ?>
                </div>
                <div style="width: 100%; height: 90%; display: flex; flex-direction: row;">
                    <div style="width: 30%; border-right: 1px solid black; text-align: center;">
                        <ul style="list-style-type: none; background-color: #979EA8;">
                            <?php
                                if (isset($_GET['usy'])) {
                                    $usy_id = $_GET['usy'];
                                    $conection = Conectarse();

                                    $sql="SELECT * FROM task WHERE user_story_id=$usy_id";
                                    $result=mysqli_query($conection,$sql);
                                    while($row = $result->fetch_array()){
                                        ?>
                                        <li><a href="task_page.php?tsk=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
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
                                        if (isset($_GET['usy'])) {
                                            $usy_id = $_GET['usy'];
                                            
                                            $sql="SELECT prj.* FROM project AS prj JOIN user_story AS usy WHERE prj.id=usy.project_id AND usy.id=$usy_id";
                                            $result=mysqli_query($conection,$sql);
                                            while($row = $result->fetch_array()){
                                            ?>
                                                <td>Proyecto: <a href="project_page.php?prj=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></td>
                                            <?php
                                            }

                                            $sql="SELECT us.* FROM user AS us JOIN user_story AS usy WHERE us.id=usy.user_id AND usy.id=$usy_id";
                                            $result=mysqli_query($conection,$sql);
                                            while($row = $result->fetch_array()){
                                            ?>
                                                <td>Responsable: <a href="users_page.php?usr=<?php echo $row['id']; ?>"><?php echo $row['names']; ?> <?php echo $row['lastnames']; ?></a></td>
                                            <?php
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <td>Proyecto: Proyecto </td>
                                            <td>Responsable: Desarrollador </td>
                                            <?php
                                        }
                                    ?>
                                    <td>Sprint: Sprint 1</td>
                                    <td>Abierto</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 80%; height: 50%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                            <?php
                                if (isset($_GET['usy'])) {
                                    $usy_id = $_GET['usy'];
                                    $sql="SELECT * FROM user_story WHERE id=$usy_id";
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
                                        Hlsjdfhlakjsdbvlasjdfhlkajsdhflkajsdhflkasjdhflaksjdfhlasj
                                        kdfhlaksjdfhlaskdjfhalsdkjfalskdfhlaskfjkahdlfkjashldkfjha
                                        slkdjfhlaskjdfhlaskjdfhlaksjdfhalksjdfhalskdfhlaskdhflaksj
                                        dfhlaksdjfhlaskjdfhallajdfhlkajsdhflkasjdhfkahsldfkjahsldk
                                        fjhalskdfhalskdjfhlaskjfhlaksjdfhlkasjdhflkasjdhflkasjfhlk
                                        dsdlakdjhflkasjdfhlaksjdfhkasfh.
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
