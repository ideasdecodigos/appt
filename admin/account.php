<?php 
    
 if(isset($_POST['dateOne'])){
     $date1=date("Y-m-d 00:00:00",strtotime($_POST['dateOne']));
     $date2=date("Y-m-d 23:59:59",strtotime($_POST['dateTwo']));
     
     $worked=0;
     $tips=0;
     $percent=0;
     $collected=0;
     $registros=0;
     $totalCash=0;
     $totalCard=0; 
     session_start();
     include ("../admin/connection.php");
     if(isset($_POST['root'])){ 
     $res = mysqli_query($con,"SELECT * FROM users RIGHT JOIN account ON users.iduser=account.user WHERE iduser='".$_POST['root']."' AND date>='$date1' AND date<='$date2' ORDER BY date");
     }else{
     $res = mysqli_query($con,"SELECT * FROM users RIGHT JOIN account ON users.iduser=account.user WHERE iduser='".$_SESSION['iduser']."' AND date>='$date1' AND date<='$date2' ORDER BY date");
     }
     
     if(mysqli_num_rows($res) > 0 ){    $registros=mysqli_num_rows($res); ?>

<center><a class="icon-down flechasDown" href="#btnTotales"></a></center>
 
<div id="divInforme">
    <table>
        <h2 style="text-align:center">CUADRE <?php echo strtoupper($_SESSION['periodo']); ?>:</h2>
        <thead>
            <tr>
                <th>Propina</th>
                <th>Trabajado</th>                
                <th><?php  echo $_SESSION['percent']."%"; ?></th>
                <th colspan="2" style="text-align:center">
                <span class="icon-list-ol" style="width:20%;display:inline-block;cursor:pointer;"></span>
                <span class="icon-list-ul" style="width:20%;display:inline-block;cursor:pointer;"></span>
                <span class="icon-print" style="width:20%;display:inline-block;cursor:pointer;" onclick="imprSelecion('divInforme');"></span>
                    
                    <script>
                        var list_ol = true;
                        $('.icon-list-ol').click(function() {
                            if (list_ol) {
                                $('.thdiario,.tddiario').css("display", "table-row");
                                $('.content').css("display", "none");
                                list_ol = false;
                            } else {
                                $('.thdiario,.tddiario').css("display", "none");
                                $('.content').css("display", "table-row");
                                list_ol = true;
                            }
                        });

                        var list_ul = true;
                        $('.icon-list-ul').click(function() {
                            if (list_ul) {
                                $('.thdiario,.tddiario,.content').css("display", "table-row");
                                list_ul = false;
                            } else {
                                $('.content').css("display", "table-row");
                                $('.thdiario,.tddiario').css("display", "none");
                                list_ul = true;
                            }
                        });
                    </script>
                    
                </th>
            </tr>
        </thead>

        <tbody>
            <?php    
            $fech=date("M j, Y",strtotime("08-04-2010 22:15:00"));
            $cash=0; $card=0; $propn=0;  $dias=0;  $cont=0;  $idTr=0; $contCash=0; $contCard=0; $from9to6=0; $from9to7=0;
                                    
            while($fila=mysqli_fetch_array($res)){
                $date=date("D j M",strtotime($fila['date']));   
                $cont++;
                     //MUESTRA LA FECHA POR GRUPO
                if(date("M j, Y",strtotime($fila['date']))!=$fech){ 
                   $dias++;   
                    
                       //CALCULA LAS HORAS TRABAJADAS PARA EL PROMEDIO         
                if(date("D",strtotime($fila['date']))==="Mon" or date("D",strtotime($fila['date']))==="Tue" or date("D",strtotime($fila['date']))==="Wed"){
                    $from9to6++;
                }else{ 
                    $from9to7++;
                }
                    
                   if($cash!=0 || $card!=0){ ?>
            <!--TOTALES POR DIA--> 
            <tr class='tddiario' id="<?php echo 'th'.$idTr; ?>">
                <td colspan="2" style="color:purple"><?php echo "(".$contCash.") Cash = $".$cash; ?></td>
                <td colspan="2" style="color:blue"><?php echo "(".$contCard.") Card = $".$card; ?></td>
                <td></td>
            </tr>
            <tr class='thdiario' id="<?php echo 'th'.$idTr; ?>">
                <th>Services</th>
                <th>Propina</th>
                <th>Trabajado</th>
                <th><?php echo $fila['percent'] ."%"; ?></th>
                <th class="td">Total</th>
            </tr>
            <tr class='tddiario' id="<?php echo 'td'.$idTr; ?>">
                <td><?php echo $cont; ?></td>
                <td><?php echo $propn; ?></td>
                <td><?php echo ($cash + $card); ?> </td>
                <td><?php echo ((($cash + $card) * $fila['percent']) /100);  ?> </td>
                <td class="td"><?php echo (((($cash + $card) * $fila['percent']) /100) + $propn); ?></td>
            </tr>
            <tr>
                <td colspan="5"><br></td>
            </tr>
            <?php }  ?>
            <tr>
                <th class="icon-list" style="text-align:center" onclick="$('#th<?php echo ($idTr + 1) ?>,#td<?php echo ($idTr + 1) ?>').slideToggle();"></th>
                <script>
                
                </script>
                <th colspan="5" style="text-align:center"><?php echo date("l, M j, Y",strtotime($fila['date']));  ?> </th>
            </tr>
            <?php  
                $idTr++; $cash=0; $card=0; $totalpordias=0;  $propn=0;   $cont=0;  $contCash=0; $contCard=0;                  
            }//fin del if fecha ordenada
                if($fila['tipo']=="Cash"){
                    $contCash++;
                    $cash+=$fila['total'];
                    $totalCash+=$fila['total'];
                }else{
                    $card+=$fila['total']; 
                    $totalCard+=$fila['total']; 
                    $contCard++;                    
                }
                $propn+=$fila['tip']; 
                $fech=date("M j, Y",strtotime($fila['date']));
            ?>

            <tr class="content">
               <td><?php echo $fila['tip']; ?></td>
                <td>
                    <?php echo $fila['total'];
                    echo ( $fila['tipo']=="Cash" ? " <font color='purple'>". $fila['tipo']."</front>" : " <font color='blue'>". $fila['tipo']."</front>" ); ?>
                </td>
                
                <td><?php echo ($fila['total'] * $fila['percent']) /100; ?></td>
                <td><?php echo date("h:i a",strtotime($fila['date'])); ?></td>
                <td style="text-align:center;">
                    <button onclick="del(<?php echo $fila['id']; ?>);" class="icon-trash" title="Eliminar"></button>
                </td>
            </tr>

            <?php   
                    $worked+=$fila['total']; 
                    $tips+=$fila['tip'];
                    $percent=($worked * $fila['percent']) /100;
                    $collected=$percent + $tips;                                                  
         }//*******FIN DEL CICLO WHILE*******   
                                                   
              $horasTrabajadas = ($from9to6 * 9.5)+($from9to7 * 10.5);
              $horasTrabajadasDiarias = ($horasTrabajadas/$dias);
            ?>    
         
        </tbody>
       
        <!--TOTALES POR DIA PARA LA ULTIMA SUMA-->
        <tr class='tddiario' id="<?php echo 'th'.$idTr; ?>">
            <td colspan="2" style="color:purple"><?php echo "(".$contCash.") Cash=".$cash; ?></td>
            <td colspan="2" style="color:blue"><?php echo "(".$contCard.") Card=".$card; ?></td>
            <td></td>
        </tr>
        <tr class='thdiario' id="<?php echo 'th'.$idTr; ?>">
            <th>Services</th>
            <th> Propina </th>
            <th> Trabajado </th>
            <th> <?php echo $_SESSION['percent'] ."%"; ?></th>
            <th class="td">Total</th>
        </tr>
        <tr class='tddiario' id="<?php echo 'td'.$idTr; ?>">
            <td><?php echo ($cont+1); ?></td>
            <td> <?php echo $propn; ?></td>
            <td> <?php echo ($cash + $card); ?> </td>
            <td> <?php echo ((($cash + $card) * $_SESSION['percent']) /100);  ?> </td>
            <td class="td"><?php echo (((($cash + $card) * $_SESSION['percent']) /100) + $propn); ?></td>
        </tr>  
        <tr>
            <td colspan="5" id="btnTotales">
        </tr>      
        <tr>
            <td colspan="5">
                <a class="icon-up flechasUp" href="#top"></a>
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <a class="icon-down flechasDown" href="#bottom"></a>
            </td>
        </tr>
       
        <tbody class="tfoot">
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <th colspan="5" style="text-align: center;">TOTALES:</th>
            </tr>
            <tr>
                <td colspan="2"><?php echo $registros; ?> Servivios</td>
                <td colspan="2"> <?php echo $horasTrabajadas; ?>Horas</td>
                <td ><?php echo $dias; ?> Dias</td>
            </tr>
             <tr>
                <td colspan="3">Trabajado: <?php echo "$".$worked; ?></td>

                <td colspan="2" style="text-align:left"><?php echo $_SESSION['percent']."%: <font color='red' size='+2'>$<b>".$percent."</b></font>"; ?></td>
            </tr>          
            <tr>
                <td colspan="3">Total Cash: <?php echo "$".$totalCash; ?></td>

                <td colspan="2" style="text-align:left">Propinas: <?php echo  "$".$tips; ?></td>
            </tr>
            <tr>
                <td colspan="3">Total Card: <?php echo  "$".$totalCard; ?></td>

                <td colspan="2" style="text-align:left"><b>Total: <?php echo  "$".$collected; ?></b></td>
            </tr>


            <?php                                      
//                include ("../admin/connection.php");
     
                $res = mysqli_query($con,"SELECT SUM(total)AS media,AVG(total)AS mediaTotal, AVG(tip)AS mediaTip, MIN(total)AS minTotal, MAX(total)AS maxTotal, MIN(tip)AS minTip, MAX(tip)AS maxTip FROM users RIGHT JOIN account ON users.iduser=account.user WHERE iduser='".$_SESSION['iduser']."' AND date>='$date1' AND date<='$date2' ORDER BY date");
     
     if(mysqli_num_rows($res) > 0 ){   
       while($fila=mysqli_fetch_array($res)){ ?>
            <tr>
                <td colspan="5"><br></td>
            </tr>
            <tr>
                <th colspan="5" style="text-align: center;">MIN & MAX:</th>
            </tr>
            <tr>
                <td colspan="3">Min Cobrado: <?php echo "$".$fila['minTotal']; ?></td>

                <td colspan="2" style="text-align:left">Max Cobrado: <?php echo "$".$fila['maxTotal']; ?></td>
            </tr>
            <tr>
                <td colspan="3">Min Propina: <?php echo "$".$fila['minTip']; ?></td>

                <td colspan="2" style="text-align:left">Max Propina: <?php echo "$".$fila['maxTip']; ?></td>
            </tr>
            <tr>
                <td colspan="5"><br></td>
            </tr>
            <tr>
                <th colspan="5" style="text-align: center;">PROMEDIO DIARIO:</th>
            </tr>
            <tr>
                <td colspan="3"><?php echo round($registros / $dias,1) . " Servicios por día a: $".round($fila['mediaTotal'],1); ?> </td>
                <td colspan="2" style="text-align:left"><?php echo $_SESSION['percent']."%: <font color='dodgerblue'>$<b>".round(($fila['mediaTotal'] * $_SESSION['percent']) /100,0)."</b></font>"; ?></td>
            </tr>
            <tr>
                <td colspan="3"><?php echo round($horasTrabajadasDiarias,1)." Horas trabajadas a: $". round($fila['media'] /($horasTrabajadas),0); ?></td>
                <td colspan="2"><?php echo $_SESSION['percent']."%: <font color='dodgerblue'>$<b>". round((($fila['media'] * $_SESSION['percent'])/100)/($horasTrabajadas),0)."</b></font>"; ?></td>
            </tr>
               
            <tr>
                <td colspan="2">Trabajado: <?php echo  "$".round($fila['media']/$dias,0); ?></td>
                <td></td>
                <td colspan="2" style="text-align:left"><?php echo $_SESSION['percent']."%: <font color='dodgerblue'>$<b>".round((($fila['media'] /$dias) * $_SESSION['percent']) /100,0)."</b></font>"; ?></td>
            </tr>
            <tr>
                <td colspan="3">Propina: <?php echo  "$".round($fila['mediaTip'],1); ?></td>
           
                <td colspan="2"><b>Total: $<?php echo round(((($fila['media'] /$dias) * $_SESSION['percent']) /100)+ $fila['mediaTip'],0); ?></b></td>
            </tr>

            <?php }} ?>
        </tbody>
    </table>
</div>
<br><br>
<script>
    function del(id) {
        var eliminar = confirm('Al hacer clic en aceptar, se eliminará el registro seleccionado. ¿Seguro que deseas eliminarlo?');
        if (eliminar) {
            $.ajax({
                type: 'post',
                url: '../admin/manage.php',
                data: {
                    delc: id
                },
                success: function(data) {
                    $('#formhistory').submit();
                }
            });
        }
    }

</script>


<?php } else{
           echo "<br><Br><center class='icon-calendar-o'> Sin Registros!</center>"; 
     }

//******EL SIGUIENTE CODIGO CREA Y MUESTRA LA GRAFICA
    $fecha1 = $_POST['dateOne'];
    $fecha2 = $_POST['dateTwo'];
    $iduser = (isset($_POST['root']) ? $_POST['root'] : $_POST['iduser']);
    $percent = $_POST['percent'];
    
    $textoX="";
    $datoXfecha=array();
    $datoYtotalTrabajado=array();
    $datoYtotalDiario=array();
    $datoYtip=array();
    $datoYcash=array();
    $datoYcard=array();
    $datoPercent=array();
    $datoTotalDiario=array();

    while($fecha1 <= $fecha2){
            $res = mysqli_query($con,"SELECT SUM(total)AS total, (SELECT SUM(total) FROM account WHERE user=$iduser AND tipo='cash' AND date LIKE '$fecha1%')AS cash, (SELECT SUM(total) FROM account WHERE user=$iduser AND tipo='card' AND date LIKE '$fecha1%')AS card, SUM(tip)AS tip, date FROM account WHERE user=$iduser AND date LIKE '$fecha1%' ORDER BY date"); 
            $textoX=date("D d",strtotime($fecha1));
   
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
               $datoYtotalTrabajado[]=$fila['total'];          
               $datoYtip[]=$fila['tip'];          
               $datoYcash[]=$fila['cash'];          
               $datoYcard[]=$fila['card']; 
               $datoPercent[]=($fila['total'] * $percent / 100); 
               $datoTotalDiario[]= (($fila['total'] * $percent / 100) + $fila['tip']) ; 
                
            } 
            $datoXfecha[]=$textoX;
            $fecha1 = date("Y-m-d",strtotime($fecha1.'+1 days')); 
           
        } 
    }

    $datosXfechas=json_encode($datoXfecha);
    $datosYtotalTrabajado=json_encode($datoYtotalTrabajado);    
    $datosYtip=json_encode($datoYtip);     
    $datosYcash=json_encode($datoYcash);     
    $datosYcard=json_encode($datoYcard); 
    $datosPercent=json_encode($datoPercent); 
    $datosTotalDiario=json_encode($datoTotalDiario);
    
    mysqli_free_result($res);  mysqli_close($con);   ?>

<script src="../js/plotly-latest.min.js"></script>
<center style="overflow-x: scroll; max-width:1220px;margin:auto;">
    <div id="myGraficas"></div>
</center>
<br><br>
<a id="bottom"  class="icon-up flechasUp" href="#btnTotales"></a>
<br><br>
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
    datosYtotalTrabajado = obtener('<?php echo $datosYtotalTrabajado; ?>');
    datosYcash = obtener('<?php echo $datosYcash; ?>');
    datosYcard = obtener('<?php echo $datosYcard; ?>');
    datosYtip = obtener('<?php echo $datosYtip; ?>');
    datosPercent = obtener('<?php echo $datosPercent; ?>');
    datosTotalDiario= obtener('<?php echo $datosTotalDiario; ?>');

   
    var trace1 = {
            x: datosXfechas,
            y: datosYcash,
            type: 'scatter',
            name: 'Total Cash',
            visible:'legendonly',
            marker: {
                color: 'purple'
            }
        }; 
    var trace2 = {
            x: datosXfechas,
            y: datosYcard,
            type: 'scatter',
            name: 'Total Card',
            visible:'legendonly',
            marker: {
                color: 'blue'
            }
        };
    var trace3 = {
        x: datosXfechas,
        y: datosYtotalTrabajado,
        type: 'scatter',
        name: 'Total Trabajado',
        visible:'legendonly',
        marker: {
            color: 'dodgerblue'
        }
    };
    var trace4 = {
        x: datosXfechas,
        y: datosPercent,
        type: 'scatter',
        name: '<?php echo $percent ?>% Porciento',
        marker: {
            color: 'red'
        }
    };
    var trace5 = {
        x: datosXfechas,
        y: datosYtip,
        type: 'scatter',
        name: 'Propinas',
        marker: {
            color: 'darkgreen'
        }
    };
    var trace6 = {
        x: datosXfechas,
        y: datosTotalDiario,
        type: 'scatter',
        name: 'Total Diario',
        visible:'legendonly',
        marker: {
            color: 'darkorange'
        }
    };

    var layout = {
        title: "GRAFICAS DE TOTALES",
        
        legend:{
            x:0,
            y:-1.5
        },  
        xaxis:{
        title:'<?php echo date("F",strtotime($fecha1)) ?>',
            showline:false
        
    }, yaxis:{
        title:'Totales',
            showline:false
    }
    };
    var config = {
        displayModeBar:true,
//        modeBarButtonsToAdd:['drawLine'],
        modeBarButtonsToRemove:['hoverCompareCartesian','hoverClosestCartesian','pan2d','select2d','lasso2d','resetScale2d','toggleSpikelines','zoom2d','sendDataToCloud','resetViowMapbox','togglehover','hoverClosestPie'],
        displaylogo:false,
        responsive:true
//        showEditInChartStudio:true,
//        showLink: true,
//        plotlyServerURL: 'https://en4es.com',
//        linkText: 'Sitio Ofical'
    };

    var data = [trace1,trace2,trace3, trace4, trace5, trace6];
    Plotly.newPlot("myGraficas", data, layout, config);

</script>
<?php }else{echo "<center><font color='red'>Sin resultados gráficos!</font></center>;<br><br><br>"; }?>
       
      
     
    
   