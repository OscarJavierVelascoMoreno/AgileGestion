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
                            <a  href="./users_page.html"><img src="../images/casa.svg" width="15%"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_list">
                            <a  href="./users_page.html"><img src="../images/alinear-justificar.svg" width="15%"/></a>
                        </td>
                        <td class="td_list">
                            <a  href="./users_page.html"><img src="../images/agregar-documento.svg" width="15%"/></a>
                        </td>
                        <td class="td_list">
                            <a  href="./users_page.html"><img src="../images/filtrar.svg" width="15%"/></a>
                        </td>
                    </tr>
                </table> 
                <ul>
                    <?php
                        include('C:/xampp/htdocs/Proyecto/controller/conectarse.php');
                        Conectarse();

                        $conection = Conectarse();
                        $sql="SELECT * FROM user_story";
                        $result=mysqli_query($conection,$sql);
                        while($row = $result->fetch_array()){
                            ?>
                            <li><a href="./us_page?us=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></li>
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
                        <span style="font-size: xx-large;"></span>Tareas 1</span>
                    </div>
                    <div style="width: 10%;">
                        <a  href="./users_page.html"><img src="../images/edit-free-icon-font.svg" width="15%"/></a>
                    </div>
                    <div style="width: 10%;">
                        <a  href="./users_page.html"><img src="../images/trash-free-icon-font.svg" width="15%"/></a>
                    </div>
                </div>
                <div style="width: 100%; height: 90%; display: flex; flex-direction: row;">
                    <div style="width: 30%; border-right: 1px solid black; text-align: center;">
                        <table style="border-collapse: collapse;">
                            <tr>
                                <td class="td_list">
                                    <a  href="./users_page.html"><img src="../images/alinear-justificar.svg" width="15%"/></a>
                                </td>
                                <td class="td_list">
                                    <a  href="./users_page.html"><img src="../images/agregar-documento.svg" width="15%"/></a>
                                </td>
                                <td class="td_list">
                                    <a  href="./users_page.html"><img src="../images/filtrar.svg" width="15%"/></a>
                                </td>
                            </tr>
                        </table> 
                        <ul style="list-style-type: none; background-color: #979EA8;">
                            <li>Tarea 1</li>
                            <ul style="list-style-type: none; background-color: #CED4DB;">
                            </ul>
                            <li>Tarea 2</li>
                            <ul style="list-style-type: none; background-color: #CED4DB;">
                            </ul>
                            <li>Tarea 3</li>
                            <ul style="list-style-type: none; background-color: #CED4DB;">
                            </ul>
                            <li>Tarea 4</li>
                            <ul style="list-style-type: none; background-color: #CED4DB;">
                            </ul>
                        </ul>
                    </div>
                    <div style="width: 70%; margin: 5%;">
                        <div style="width: 80%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                            <table style="width: 50%; margin: 5%; ">
                                <tr>
                                    <td>HU: Historia de Usuario 1</td>
                                    <td>Responsable: Desarrollador 1</td>
                                    <td>Abierto</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 80%; height: 50%; border: 1px solid black; margin: 5%; background-color: #979EA8;">
                            <p style="padding: 5%;">
                                Descripcion: <br/>
                                Hlsjdfhlakjsdbvlasjdfhlkajsdhflkajsdhflkasjdhflaksjdfhlasjsdfsdfsdas
                                kdfhlaksjdfhlaskdjfhalsdkjfalskdfhlaskfjkahdlfkjashldkfjhasdfsdfasda
                                slkdjfhlaskjdfhlaskjdfhlaksjdfhalksjdfhalskdfhlaskdhflaksjsdfsdfasda
                                dfhlaksdjfhlaskjdfhallajdfhlkajsdhflkasjdhfkahsldfkjahsldksdfsdfasda
                                fjhalskdfhalskdjfhlaskjfhlaksjdfhlkasjdhflkasjdhflkasjfhlksdfsdfasda
                                dsdlakdjhflkasjdfhlaksjdfhkasfh.
                            </p>
                        </div>
                        <!--<div style="width: 50%; margin: 5%;">-->
                        <div style="width: 80%; height: 20%; border: 1px solid black; text-align: center; display: flex; justify-content: center; align-items: center; margin: 5%; background-color: #979EA8;">
                            <table style="width: 50%; margin: 5%; ">
                                <tr>
                                    <td>Tiempo Estimado: 5 hrs</td><br>
                                    <td>Tiempo Invertido: 2 hrs</td><br>
                                    <td>Tiempo Restante: 3 hrs</td><br>
                                    <td>Calificación</td>
                                </tr>
                            </table>
                        <!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>