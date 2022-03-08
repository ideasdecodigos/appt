<?php 

include("connection.php");
if(isset($_POST['dateOne']) and isset($_POST['dateTwo'])  and $_POST['dateOne']<=$_POST['dateTwo']){
    $fecha1 = $_POST['dateOne'];
    $fecha2 = $_POST['dateTwo'];
    $iduser = $_POST['iduser'];
    $percent = $_POST['percent'];
    
    $textoX="";
    $datoXfecha=array();
    $datoYtotal=array();
    $datoYtip=array();
    $datoYcash=array();
    $datoYcard=array();

    while($fecha1 <= $fecha2){
            $res = mysqli_query($con,"SELECT SUM(total)AS total, (SELECT SUM(total) FROM account WHERE user=$iduser AND tipo='cash' AND date LIKE '$fecha1%')AS cash, (SELECT SUM(total) FROM account WHERE user=$iduser AND tipo='card' AND date LIKE '$fecha1%')AS card, SUM(tip)AS tip, date FROM account WHERE user=$iduser AND date LIKE '$fecha1%' ORDER BY date"); 
            $textoX=date("M d",strtotime($fecha1));
   
        if(mysqli_num_rows($res) > 0 ){  
            while($fila=mysqli_fetch_array($res)){   
                if($fila['total']==null ){
                    $fila['total']=0;
                }
                if($fila['tip']==null){
                    $fila['tip']=0;
                }
                if($fila['cash']==null){
                    $fila['cash']=0;
                }
                if($fila['card']==null){
                    $fila['card']=0;
                } 
                
               $datoYtotal[]=$fila['total'];          
               $datoYtip[]=$fila['tip'];          
               $datoYcash[]=$fila['cash'];          
               $datoYcard[]=$fila['card']; 
               $datoPercent[]=($fila['total'] * $percent / 100); 
                
            } 
            $datoXfecha[]=$textoX;
            $fecha1 = date("Y-m-d",strtotime($dateOne.'+1 days')); 
           
        } 
    }

    $datosXfechas=json_encode($datoXfecha);
    $datosYtotal=json_encode($datoYtotal);    
    $datosYtip=json_encode($datoYtip);     
    $datosYcash=json_encode($datoYcash);     
    $datosYcard=json_encode($datoYcard); 
    $datosPercent=json_encode($datoPercent); 
    
    mysqli_free_result($res);  mysqli_close($con);   ?>

<script src="../js/plotly-latest.min.js"></script>
<center style="overflow-x: scroll;">
    <font color="red" size="+4" class="icon-sort" onclick="$('#formGrafica').toggle();"></font>
    <div id="myGraficas"></div>
</center>
<br><br>
<a id="bottom" style="font-size:2em;text-decoration:none;display:block;text-align:center;margin:0;padding:0" class="icon-jump-up" href="#btnTotales"></a>
<br><br>
<script> 
    function obtener(json) {
        var parsed = JSON.parse(json);
        var arr = [];
        for (var x in parsed) {
            arr.push(parsed[x]);
        }
        return arr;
    } 

    datosXfechas = obtener('<?php echo $datosXfechas; ?>');
    datosYtotal = obtener('<?php echo $datosYtotal; ?>');
    datosYcash = obtener('<?php echo $datosYcash; ?>');
    datosYcard = obtener('<?php echo $datosYcard; ?>');
    datosYtip = obtener('<?php echo $datosYtip; ?>');
    datosPercent = obtener('<?php echo $datosPercent; ?>');

    var trace1 = {
        x: datosXfechas,
        y: datosYtotal,
        type: '<?php echo $grafica; ?>',
//         orientation: 'h',
        // type: 'bar',
        // type: 'pie',
        name: 'Total <?php echo $intervalo; ?>',
        
        marker: {
            color: 'darkgreen',
            // line: {
            // width: 2.5
            //// color:'red'
            // }
        }
    };
    var trace2 = {
            x: datosXfechas,
            y: datosYcash,
            type: '<?php echo $grafica; ?>',
            name: 'Total Cash',
            marker: {
                color: 'blue'
            }
        }; 
    var trace3 = {
            x: datosXfechas,
            y: datosYcard,
            type: '<?php echo $grafica; ?>',
            name: 'Total Card',
            marker: {
                color: 'red'
            }
        };
    var trace4 = {
        x: datosXfechas,
        y: datosYtip,
        type: '<?php echo $grafica; ?>',
        name: 'Propinas',
        marker: {
            color: 'darkorange'
        }
    };
    var trace5 = {
        x: datosXfechas,
        y: datosPercent,
        type: '<?php echo $grafica; ?>',
        name: '<?php echo $percent ?>% Porciento',
        lengend:false, 
        marker: {
            color: 'dodgerblue'
        }
    };

    var layout = {
        title: "GRAFICAS DE TOTALES",
        showlengend: false,
        font: {
            size: 12
        },
        xaxis:{
        title:'Fechas',
            showline:false
    }, yaxis:{
        title:'Totales',
            showline:false
    }
    }
    var config = {
        showEditInChartStudio:true,
        responsive:true,
        showLink: true,
        plotlyServerURL: 'http://en4es.com',
        linkText: 'Sitio Ofical'
    }

    var data = [trace1,trace2,trace3, trace4, trace5];
    Plotly.newPlot("myGraficas", data, layout, config);

</script>
<?php } else{echo "<center><font color='red'>Sin resultados gráficos!</font></center>;<br><br><br>"; }?>
