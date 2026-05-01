<?php ob_start();

include_once("../../controlador/conexion.php");
include_once("../../controlador/Subcotizacion.php");
include_once("../../class/Fecha.php");
include_once("../../class/Conversion.php");
include_once("../../class/Helper.php");
include_once("../../class/Header.php");
require_once("../../dependencias/dompdf/autoload.inc.php");

  $id = (int) base64_decode($_GET['cotizacion']);
  if(!filter_var($id,FILTER_VALIDATE_INT)){ echo "LA URL NO ES VALIDA :("; return false;}

 //Se crea el objeto
 $oCot = new Subcotizacion();
 $nControl = 6;

$resp = $oCot->Print($id);

$importe = 0;
//Codigo para encriptación de imagen y poder renderizar en dompdf
$path = '../../dependencias/img/mspnew.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

if (isset($_GET['iva']) && $_GET['iva'] === 'true') {$iva = true; } else { $iva = false;}

$dolar = isset($_GET['moneda']) && @$_GET['moneda'] === 'true' ?true : false;

//Obtenemos información del array de encabezados
$index = null;
$sucursal = $resp['fksucursal'];
$resultado = array_filter($header, function($elemento) use ($nControl, $sucursal) {
    return $elemento['control'] == $nControl && $elemento['sucursal'] == $sucursal;
});

if(!empty($resultado)){
    $index = key($resultado);
}else{
    echo "No se encontro el encabezado, consulte con el administrador.";
    return false;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRINT - SUBCOTIZACIÓN</title>
    <style>
        @page {
            margin: 20px;
            margin-left: 40px;
            margin-top: 410px;
            margin-bottom: 50px;
        }

        header {
            position: fixed;
            top: -400px;
            bottom: 0;
            left: 0;
            right: 0;
        }

        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;

            /* height: 30px; */
            /* Altura del pie de página */
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin-left: unset;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 11px;
            width: 100%;
            border-collapse: collapse;
        }

        .header-table,
        .content-table,
        .table-header-title {
            width: 100%;
            border: 1px solid black; 
        }

        #img-h1 {
            width: 15%;
        }

        .header-table td {
            border: none;
            padding: 5px;
        }

        .content-table th,
        .content-table td {
            border: 1px solid black;
            padding: 2px;
            text-align: left;
        }

        .header {
            text-align: right;
        }

        .contact-info {
            text-align: center;
            width: 45%;
        }

        .title {
            text-align: center;
            font-weight: bold;
        }

        .title-table-td {
            background-color: #D1D1D1;
        }

        .text-center {
            text-align: center;
        }

        .table-header-title thead th {
            border: 1px solid black;
        }

        .table-header-title tr td {
            /* border-bottom: 1.5px solid black; */
            padding: 3px
        }

        .observaciones {
            height: auto;
        }

        .signature-table .left {
            text-align: center;
        }

        .signature-table .right {
            text-align: center;
        }
        table.encabezado tr th,table.encabezado tr td{
                text-align: left;
        }
        table.encabezado tr td.sub{
                font-size: 10px;
        }
        table tr td small{
            color:green;
            font-size: 11px;
        }
        table tr td small span{
            color:black;
        }
    </style>
</head>

<body>

    <header>
        <table class="header-table">
            <tr style="text-align:right">
                <td colspan="3" style="color:#33BEFF">
                    <strong><?php echo $header[$index]['texto1']; ?></strong>
                </td>
            </tr>
            <tr>
                <td id="img-h1"><img src="<?php echo $base64; ?>" style="width:200px;height:100px;position:relative;top:-20px"></td>
                <td class="contact-info">
                    <strong><?php echo $header[$index]['titulodesc']; ?></strong><br>
                    <?php echo $header[$index]['descripcion']; ?><br>
                    <a href="mailto:<?php echo $header[$index]['correo']; ?>"><?php echo $header[$index]['correo']; ?></a>
                </td>
                <td class="header">
                    <div style="margin-right:0px;position:relative;width:130%;margin-top:-55px;right:30%">
                        <strong><?php echo $header[$index]['texto2']; ?><br>
                        <?php echo $header[$index]['texto3']; ?><br>
                        <?php echo $header[$index]['texto4']; ?></strong>
                    </div>

                </td>
            </tr>
        </table>

        <table style="margin-top:10px" >
            <table>
                <tr>
                    <td style="width:70%" valign="top">
                        <table class="encabezado">
                            <tr>
                                <th valign="top" style="width:10%">Cliente:</th>
                                <td class="sub"><?php echo $resp['nombre']; ?></td>
                            </tr>
                            <tr>
                                <th valign="top">At'n:</th>
                                <td class="sub"><?php echo $resp['titulo_atn'].". ".$resp['nombre_atn']; ?></td>
                            </tr>
                            <tr>
                                <th valign="top">Cargo:</th>
                                <td class="sub"><?php echo $resp['cargo']; ?></td>
                            </tr>
                            <tr>
                                <th valign="top">Solicito:</th>
                                <td class="sub"><?php echo $resp['titulo'].". ".$resp['nombre_usercli']; ?></td>
                            </tr>
                            <tr>
                                <th valign="top">Dirección:</th>
                                <td style="white-space: nowrap;" class="sub"><?php echo substr($resp['direccion'],0,75); ?></td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top">
                    <table class="encabezado">
                            <tr>
                                <th style="width:10%;font-size:15px;color:green">COTIZACIÓN:</th>
                                <td style="width:10%;font-size:10pt;font-weight:bold"><?php echo $resp['folio']; ?></td>
                            </tr>
                            <tr>
                                <th style="width:10%;font-size:15px;color:green">FECHA:</th>
                                <td style="width:10%;font-size:13px;"><?php echo Fecha::convertir($resp['fecha']); ?></td>
                            </tr>
                            <?php if($resp['pkcliente'] == '115' || $resp['pkcliente'] == '407' || $resp['pkcliente'] == '475'|| $resp['pkcliente'] == '806'){ ?>
                                <tr>
                                    <th style="width:20%;font-size:15px;color:green">Number vendor:</th>
                                    <td style="width:10%;font-size:13px;">1163335</td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
            </table>
            
        </table>

        <table class="encabezado" style="margin-top:10px;">
            <tr >
                <th width="20%" valign="top" >DATOS NORMATIVOS:</th>
                <td class="sub" valign="top" width="50%"><?php echo $resp['dnormativos']; ?></td>
                <th valign="top" width="20%">DATOS TECNICOS:</th>
                <td class="sub" valign="top" width="30%"><?php echo $resp['dattecnicos']; ?></td>
            </tr>
            <tr>
                <th valign="top" style="padding-top:15px;">ESTANDARES DE FABRICACIÓN:</th>
                <td class="sub" valign="top" style="padding-top:15px;"><?php echo $resp['efabricacion']; ?></td>
                <th valign="top" style="padding-top:15px">REQUISITOS LEGALES:</th>
                <td class="sub" valign="top" style="padding-top:15px"><?php echo $resp['doclegal']; ?></td>
            </tr>
            <tr>
                <th valign="top" style="padding-top:15px">PROCESOS DE CALIDAD:</th>
                <td class="sub" valign="top" style="padding-top:15px"><?php echo $resp['dnormativos']; ?></td>
                <th></th>
                <td></td>
            </tr>
            <tr>
                <th colspan="4" style="padding-top:10px">Desviaciones / Excepciones / Requisitos No contempladas por el cliente:</th>
            </tr>
            <tr>
                <td colspan="4" style="padding-top:3px;font-size:14px;color:green;font-style:italic">De acuerdo a su amable solicitud ponemos a su disposición la siguiente cotización:</td>
            </tr>
        </table>

        <table class="table-header-title">
            <thead>
                <th style="width: 5%;" class="title-table-td">PDA</th>
                <th style="width: 6%;" class="title-table-td">CANT.</th>
                <th style="width: 8%;" class="title-table-td"> UNIDAD</th>
                <th class="title-table-td">DESCRIPCIÓN</th>
                <th style="width: 8%;" class="title-table-td">CLAVE</th>
                <th style="width: 7%;" class="title-table-td">ITEM</th>
                <th style="width: 9%;" class="title-table-td">P/UNIT</th>
                <th style="width: 10%;" class="title-table-td">IMPORTE</th>

            </thead>
        </table>
    </header>
    <footer>
        <div style="border:0.1px solid black;width:100%;margin-bottom:3px"></div>
        <small style="font-size:10px">
            DOCUMENTO CONTROLADO<br>
            La copia de este documento sólo se deberá utilizar como referencia<br>
            Queda prohibida su reproducción total o parcial sin autorización de Maquinados y Servicios
            Petroleros<br>
        </small>
        <!-- <script type="text/php">
    
        if ( isset($pdf) ) {
            $dompdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->page_text(1,1, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
            ');
        }
    
</script> -->

    </footer>


    <main>
        <table class="table-header-title" style="border:unset;table-layout: fixed;">
            <?php  $anterior = 0; foreach($oCot->Servprint($resp['pksubcotizacion']) as $serv){
               
                    $redondeo = intval($serv['pda']);

                    $importe += $serv['subtotal'];
                   
                ?>
                <tr>
                    <td valign="top" style="width: 5%;text-align:center"><?php if($redondeo == $anterior){ echo "";}else{ echo $redondeo;} ?></td>
                    <td valign="top" style="width: 6%;text-align:center"><?php echo $serv['cant']; ?></td>
                    <td valign="top" style="width: 8%;text-align:center"><?php echo $serv['nombre']; ?></td>
                    <td valign="top" style="width:47%"><?php echo nl2br($serv['descripcion']); ?></td>
                    <td valign="top" style="width: 8%;text-align:center;word-wrap: break-word"><?php echo $serv['clave']; ?></td>
                    <td valign="top" style="width: 7%;text-align:center;word-wrap: break-word"><?php echo $serv['item']; ?></td>
                    <?php if($dolar){
                         ?>
                        <td valign="top" style="width: 9%;text-align:right"><?php echo "$".number_format(($serv['preciounit']/$resp['tipocambio']),2,".",",") ; ?></td>
                        <td valign="top" style="width: 10%;text-align:right"><?php echo "$".number_format(($serv['subtotal']/$resp['tipocambio']),2,".",","); ?></td>
                    <?php }else{ ?>
                    <td valign="top" style="width: 9%;text-align:right"><?php if($serv['preciounit'] != 0.00){ echo "$".number_format($serv['preciounit'],2,".",",") ; }?></td>
                    <td valign="top" style="width: 10%;text-align:right"><?php if($serv['subtotal'] != 0.00){ echo "$".number_format($serv['subtotal'],2,".",","); } ?></td>
                    <?php } ?>
                </tr>
                <?php $anterior = $redondeo; }  ?>
            
        </table>
        <div style="border:0.1px solid black;width:100%;margin-bottom:10px"></div>
        <table>
            <?php if($resp['descto'] == "0.00"){  
                if($iva){ 
                    $importeIva = ($importe * ($resp['iva']/100));
                    $importe2 = ($importeIva + $importe);
                    if($dolar){
                    ?>
                    
                <th  style="width:80%;text-align:left">(<?php echo strtoupper(Conversion::convertirNumeroALetras($importe2/$resp['tipocambio'],'DOLARES')); ?>)</th>
                <table>
                         <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">SUBTOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($resp['subtotal1']/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>
                     <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">IVA:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importeIva/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>
                        <tr style="background:#D9F2D0">
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">TOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importe2/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>
                </table>
            <?php }else{ ?>
                <th  style="width:80%;text-align:left">(<?php echo strtoupper(Conversion::convertirNumeroALetras($importe2,'PESOS')); ?>)</th>
                <table>
                         <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">SUBTOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($resp['subtotal1'], 2, '.', ','); ?></td>
                        </tr>
                     <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">IVA:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importeIva, 2, '.', ','); ?></td>
                        </tr>
                        <tr style="background:#D9F2D0">
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">TOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importe2, 2, '.', ','); ?></td>
                        </tr>
                </table>

            <?php }  }else{
                     if($dolar){
                ?>
            <tr>
                <th  style="width:80%;text-align:left">(<?php echo strtoupper(Conversion::convertirNumeroALetras($importe/$resp['tipocambio'],'DOLARES')); ?>)</th>
                <th style="width:10%;text-align:left;font-size:12px;color:green;border:1px solid grey">IMPORTE:</th>
                <td style="width:10%;text-align:center;font-size:12px;border:1px solid grey">
                    <strong>$<?php echo number_format($importe/$resp['tipocambio'], 2, '.', ','); ?></strong>
                </td>
            </tr>
            <?php }else{ ?>
            <tr>
                <th  style="width:80%;text-align:left">(<?php echo strtoupper(Conversion::convertirNumeroALetras($importe, 'PESOS')); ?>)</th>
                <th style="width:10%;text-align:left;font-size:12px;color:green;border:1px solid grey">IMPORTE:</th>
                <td style="width:10%;text-align:center;font-size:12px;border:1px solid grey">
                    <strong>$<?php echo number_format($importe, 2, '.', ','); ?></strong>
                </td>
            </tr>

            <?php } }
            
            }else{ 
                    $porcentaje = ($resp['subtotal1'] * $resp['descto']);
                    $importe = floatval(($resp['subtotal1'] - $porcentaje));
                ?>
            <tr>
            <?php if(!$iva){ 
                if($dolar){ ?>
                <th valign="top" style="width:65%;text-align:left">(<?php echo strtoupper(Conversion::convertirNumeroALetras($importe/$resp['tipocambio'], 'DOLARES')); ?>)</th>
               <?php }else{
                ?>
                <th valign="top" style="width:65%;text-align:left">(<?php echo strtoupper(Conversion::convertirNumeroALetras($importe,'PESOS')); ?>)</th>
                   <?php } }else {
                         $importeIva = ($importe * ($resp['iva']/100));
                         $importe2 = ($importeIva + $importe);

                         if($dolar){ ?>
                        <th valign="top" style="width:65%;text-align:left">(<?php echo strtoupper(Conversion::convertirNumeroALetras($importe2/$resp['tipocambio'],'DOLARES')); ?>)</th>

                         <?php }else{
                    ?> 
                        <th valign="top" style="width:65%;text-align:left">(<?php echo strtoupper(Conversion::convertirNumeroALetras($importe2,'PESOS')); ?>)</th>
                    <?php } } if($dolar){ ?>

                    
                <th style="width:35%;">
                    <table>
                        <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">SUBTOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($resp['subtotal1']/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">DESCUENTO: <small style="color:black"><?php echo Helper::porcentaje(floatval($resp['descto'])); ?></small></td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($porcentaje/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>

                        <?php if($iva){ ?>
                        <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">IMPORTE:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importe/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">IVA:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importeIva/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>
                        <tr style="background:#D9F2D0">
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">TOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importe2/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>
                        <?php }else{ ?>
                            <tr style="background:#D9F2D0">
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">TOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importe/$resp['tipocambio'], 2, '.', ','); ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </th>
                <?php }else { ?>
                    <th style="width:35%;">
                    <table>
                        <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">SUBTOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($resp['subtotal1'], 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">DESCUENTO: <small style="color:black"><?php echo Helper::porcentaje(floatval($resp['descto'])); ?></small></td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($porcentaje, 2, '.', ','); ?></td>
                        </tr>

                        <?php if($iva){ ?>
                        <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">IMPORTE:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importe, 2, '.', ','); ?></td>
                        </tr>
                        <tr>
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">IVA:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importeIva, 2, '.', ','); ?></td>
                        </tr>
                        <tr style="background:#D9F2D0">
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">TOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importe2, 2, '.', ','); ?></td>
                        </tr>
                        <?php }else{ ?>
                            <tr style="background:#D9F2D0">
                            <td style="width:50%;text-align:left;border: 1px solid grey;color:green;font-size:14px">TOTAL:</td>
                            <td style="width:50%;text-align:right;border: 1px solid grey;font-size:14px">$<?php echo number_format($importe, 2, '.', ','); ?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </th>

              <?php  } ?>
            </tr>
           <?php } ?>
        </table>
        <div style="font-size:11px;font-weight:bold;margin-top:30px"><?php echo $resp['observacion']; ?></div>
        <div style="border:0.1px solid black;width:100%;margin-top:3px"></div>
        <table>
            <tr>
                <td>
                    <small>La presente cotización tendra una vigencia de: <span><?php echo $resp['vigencia']; ?></span></small><br>
                    <small>Las condiciones de pago: <span><?php echo $resp['dcredito']; ?></span></small><br>
                    <small>Precios en: <span><?php echo "MONEDA".' '.$resp['moneda']; ?></span></small><br>
                    <?php if(!$iva){ ?><small>Estos precios no incluyen I.V.A.</small><br><?php } ?>
                    <small>Tiempo de entrega: <span><?php echo $resp['tiempoent']; ?></span></small><br>
                    <small>Para proceder es necesario requisición autorizada u orden de compra.</small><br>
                    
                </td>
            </tr>
        </table>
        <table style="margin-top:10px">
            <tr> 
                <td style="font-size:13px;text-align:center; padding-bottom:30px" colspan="2">
                    Maquinados y Servicios Petroleros, Metal mecánica lntegral, Certificación API en cada pieza, 
                    Calidad en cada proceso y la puntualidad que su proyecto exige.<br>
                    <strong>Certificada por AMERICAN PETROLEUM INSTITUTE -API</strong><br>
                    Bajo los números de licencias: Q1_4727, 7-1_1667, 6A_2513
                </td>
            </tr>
            <tr>
                <td style="font-size:11px;text-align:center;width:50%">
                    ELABORÓ<br><br><br><br>

                    _____________________________________<br>
                    <strong><?php echo $resp['nombre_empleado'].' '.$resp['apellidos']; ?></strong><br>
                    JEFE DE VENTAS
                </td>
                
                <td style="font-size:11px;text-align:center;width:50%">
                    VALIDÓ<br><br><br><br>

                    _____________________________________<br>
                    <strong>HENRRY HERNANDEZ PEREZ</strong><br>
                    GERENTE GENERAL
                </td>
                
            </tr>
        </table>
    </main>

</body>

</html>


<?php
$folio = substr($resp['folio'],0,-3) ;

$html = ob_get_clean();

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set('isHtml5ParserEnabled', true);
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);


//se carga el contenido
$dompdf->loadHtml($html);


$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->getCanvas()->page_text(535,755, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0,0,0));
$dompdf->stream("COT.-{$folio}.pdf", array("Attachment" => false));


?>