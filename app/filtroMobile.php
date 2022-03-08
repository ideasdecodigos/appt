<?php if(session_id() ===""){ session_start();} ?>
<form id="verCitas">
    <fieldset id="fieldSetSearch">
        <legend>[Filtrar Citas]</legend> 
        <div class="filtroPc">
           <span class="btn icon-calendar-minus-o" onclick="openwindows(this, '#divHistorial');"></span>
            <?php  if(strcasecmp($_SESSION['type'],"business")==0){?>
                <select name="iduser">
                    <?php include("../admin/connection.php");
                    $res = mysqli_query($con, "SELECT * FROM users WHERE business='".$_SESSION['business']."' AND status='enabled' AND iduser!=".$_SESSION['iduser']." ORDER BY user");
                    if( mysqli_num_rows($res) > 0 ){ ?>
                        <option value="" selected>Todos</option>
                        <?php   while($rs=mysqli_fetch_array($res)){ ?>
                                    <option value="<?php echo $rs['iduser']; ?>"><?php echo $rs['user']; ?></option>
                        <?php   }
                    }else{ ?>
                        <option value="" selected>Empleados</option>
                    <?php }
                    mysqli_close($con);
                    mysqli_free_result($res);  ?>
                </select>
            <?php } ?>
            <input type="date" name="dateBrowse" id="dateBrowse" value="<?php echo date("Y-m-d"); ?>" disabled>
            <div><input type="checkbox" id="switchDateBrowse"></div>
        </div>
    </fieldset>
</form>
