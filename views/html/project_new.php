<html>
    <?php
        
        include('C:/xampp/htdocs/AgileGestion/controller/config.php');
        session_start();
        
        include('C:/xampp/htdocs/AgileGestion/controller/conectarse.php');
        Conectarse();

        $conection = Conectarse();

        if (isset($_POST['new_project'])) {
        
            $name = $_POST['name'];
            $user_id = $_POST['user_selection'];
            $description = $_POST['description'];
            $end_type = $_POST['end_selection'];

            if(!$user_id){
                echo '<script>alert("Debe seleccionar un lider valido!")</script>';
            }
            if(!$description){
                echo '<script>alert("Debe ingresar una descripcion del proyecto!")</script>';
            }
        
            $query = $connection->prepare("SELECT * FROM project WHERE name=:name");
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->execute();
        
            // Algoritmo para determinar si sera entregado a tiempo
            
            // Cada uno de los tipos de fin proyecto se tomara como caso de exito
            // Probabilidad de exito para cada uno de los casos
            $prj_ontime = 0;
            $prj_aftertime = 0;
            $prj_beforetime = 0;
            $tot_prob_proj = 0; //n - Numero de ensayos y experimentos

            $get_prj_sql = "SELECT * FROM project WHERE NOT end_type=''";
            $get_prj_query = mysqli_query($conection, $get_prj_sql);
            while($prj_prob_row = $get_prj_query->fetch_array()){
                if ($prj_prob_row['end_type'] == "ontime") {
                    $prj_ontime += 1;
                }
                elseif ($prj_prob_row['end_type'] == "afterdue") {
                    $prj_aftertime += 1;
                }
                elseif ($prj_prob_row['end_type'] == "beforedue") {
                    $prj_beforetime += 1;
                }
                $tot_prob_proj += 1;
            }

            $prj_ontime = $prj_ontime/$tot_prob_proj;
            $prj_aftertime = $prj_aftertime/$tot_prob_proj;
            $prj_beforetime = $prj_beforetime/$tot_prob_proj;

            $msg_extra_bf = "<br/>La probabilidad de que el proyecto termine antes de tiempo es: $prj_beforetime";
            $msg_extra_on = "<br/>La probabilidad de que el proyecto termine justo a tiempo es: $prj_ontime";
            $msg_extra_af = "<br/>La probabilidad de que el proyecto termine despues de tiempo es: $prj_aftertime";

            if (!$end_type){
                if ($prj_ontime > $prj_aftertime and $prj_ontime > $prj_beforetime)
                    $end_type = "ontime";
                elseif ($prj_aftertime > $prj_ontime and $prj_aftertime > $prj_beforetime)
                    $end_type = "afterdue";
                elseif ($prj_beforetime > $prj_aftertime and $prj_beforetime > $prj_ontime)
                    $end_type = "beforedue";
            }

            $description = $description . $msg_extra_bf . $msg_extra_on . $msg_extra_af;

            // Algoritmo para determinar si sera entregado a tiempo

            if ($query->rowCount() > 0) {
                echo '<script>alert("Ya existe un proyecto con este nombre!")</script>';
            }
        
            if ($query->rowCount() == 0 AND $user_id AND $description) {
                $query = $connection->prepare("INSERT INTO project(name,user_id,description,end_type) VALUES (:name,:user_id,:description,:end_type)");
                $query->bindParam("name", $name, PDO::PARAM_STR);
                $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
                $query->bindParam("description", $description, PDO::PARAM_STR);
                $query->bindParam("end_type", $end_type, PDO::PARAM_STR);
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
                            <a  href="./main_menu.php"><img src="../images/casa.svg" width="15%"/></a>
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
                                            Descripcion: <br/>
                                            <textarea name="description" type="text" style="border-radius: 5px; text-align: center; width: 60%;"></textarea>
                                        </td>
                                        <td>
                                            Tipo de finalización: <br/>
                                            <select id="end_selection" name="end_selection">
                                                <option value = ""></option>
                                                <option value = "ontime">Terminado a Tiempo</option>
                                                <option value = "afterdue">Terminado despues del tiempo</option>
                                                <option value = "beforedue">Terminado antes de tiempo</option>
                                            </select>
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
