<?php if(session_id() ===""){ session_start();} ?>
<div class="inputPc">
   <h2>Empleados:</h2>
    <?php 
        include("../admin/connection.php"); 
        $res = mysqli_query($con, "SELECT * FROM users WHERE business='".$_SESSION['business']."' AND status='enabled' AND iduser!=".$_SESSION['iduser']." ORDER BY user"); 
        if( mysqli_num_rows($res) > 0 ){ ?>
    <input type="hidden" id="iduser">
    <label><input type="radio" name="user" required value="Anybody">Cualquiera</label>
    <?php
            while($rs=mysqli_fetch_array($res)){ ?>
    <label><input type="radio" name="user" required value="<?php echo $rs['iduser']; ?>"><?php echo $rs['user']; ?></label>
    <?php   }
        }else{ ?>
            <input type="hidden" id="iduser">
    <p><input type="radio" name="user" required value="Anybody">Cualquiera</p>
            
            <?php
        }mysqli_close($con);  mysqli_free_result($res); ?>
</div>
<script>
    $(".inputPc p input[type=radio]").change(function() {
        $('#employee').val($(this).parent().text());
        $('#empleado').val($(".inputPc p input[type=radio]:checked").val());

        //VALIDA QUE EL TIEMPO DE LA CITA ESTE DISPONIBLE 
        if ($(this).val() != "") {
            let date = $("#date").val();
            let time = $("#time").val();
            let inputRange = $("#inputRange").val();
            let iduser = $(this).val();

            $.ajax({
                type: 'POST',
                url: '../admin/save.php',
                data: {
                    iduser: iduser,
                    date: date,
                    time: time,
                    inputRange: inputRange,
                    validarCita: ''
                },
                success: function(data) {
                    $("#infocita").html(data);
                }
            });
            return false;
        }
    });

</script>
