<?php if(session_id() ===""){ session_start();} ?>


    <form id="verCitas">
  <legend>Filtrar Citas</legend>
     <div class="filtroPc" id="fieldSetSearch">        
        <section>          
            <span class="btn icon-calendar-minus-o" onclick="openwindows(this, '#divHistorial');"></span>
            <input type="date" name="dateBrowse" id="dateBrowse" value="<?php echo date("Y-m-d"); ?>" disabled>
            <div><input type="checkbox" id="switchDateBrowse"></div>
        </section>
    <?php  if(strcasecmp($_SESSION['type'],"business")==0){ ?>  
        <div class="userList">
            <?php 
            include("../admin/connection.php");
		    $res = mysqli_query($con, "SELECT * FROM users WHERE business='".$_SESSION['business']."' AND status='enabled' ORDER BY user");
            if( mysqli_num_rows($res) > 0 ){ ?>
            <label><input type='radio' name='iduser' value="" checked>Todos</label>
            <?php  
                    while($rs=mysqli_fetch_array($res)){ ?>
            <label>
                <input type='radio' name='iduser' value="<?php echo $rs['iduser']; ?>">
                <?php echo ($_SESSION['iduser']==$rs['iduser']? "Cualquiera" : $rs['user']); ?>
            </label>
            <?php }
                
            }else{ ?>
            <label><input type='radio' name='iduser' value="" checked>No staff</label>
            <?php }
                mysqli_close($con);
                mysqli_free_result($res); 
            ?>

        </div>    
    <?php } ?>
    </div>
   
</form>
