    <select name="user" required id="iduser">   
        <option value="" selected>Empleados</option>
        <option value="Anybody">Cualquiera</option>

        <?php if(session_id() ===""){ session_start();}
            include("../admin/connection.php"); 
            $res = mysqli_query($con, "SELECT iduser, user FROM users WHERE business='".$_SESSION['business']."' AND status='enabled' AND iduser!=".$_SESSION['iduser']." ORDER BY user"); 
            if( mysqli_num_rows($res) > 0 ){ 
                while($rs=mysqli_fetch_array($res)){ ?>
                    <option value="<?php echo $rs['iduser']; ?>"><?php echo $rs['user']; ?></option>
        <?php   }
            } mysqli_close($con);  mysqli_free_result($res); ?>
    </select>

<!--CODIGO JAVASCRIPT-->
<script>
    $("#iduser").change(function() {
        $('#employee').val($('#iduser option:selected').text());
        $('#empleado').val($('#iduser option:selected').val());


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
