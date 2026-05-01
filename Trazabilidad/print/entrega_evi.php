<?php ob_start();

include_once("../../controlador/conexion.php");
include_once("../../controlador/Entrega.php");
include_once("../../class/Fecha.php");
include_once("../../class/Header.php");
require_once("../../dependencias/dompdf/autoload.inc.php");

$idEntrega = (int) base64_decode($_GET['entrega']);
if(!filter_var($idEntrega,FILTER_VALIDATE_INT)){ echo "LA URL NO ES VALIDA :("; return false;}

//Se crea el objeto
$oEntrega = new Entrega();
$nControl = 8;

$resp = $oEntrega->Print($idEntrega);

//Codigo para encriptación de imagen y poder renderizar en dompdf
$path = '../../dependencias/img/mspnew.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

if(!empty($resp['evidencia'])){
    $path2 = $resp['evidencia'];
    $type2 = pathinfo($path2, PATHINFO_EXTENSION);
    $data2 = file_get_contents($path2);
    $base642 = 'data:image/' . $type2 . ';base64,' . base64_encode($data2);
}

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
    <title>PRINT - ENTREGA</title>
    <style>
    @page {
        margin: 20px;
        margin-left: 40px;
        margin-top: 245px;
        margin-bottom: 160px;
    }

    header {
        position: fixed;
        top: -230px;
        bottom: 0;
        left: 0;
        right: 0;
    }

    footer {
        position: fixed;
        bottom: -140px;
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
    #img-h1{
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
        border-bottom: 1.5px solid black;
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
                <td id="img-h1"><img src="<?php echo @$base64;?>"  style="width:200px;height:100px;position:relative;top:-20px"></td>
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

        <table class="content-table" style="margin-top:10px">
            <tr>
                <th class="title-table-td" style="width:13%">Cliente:</th>
                <td><?php echo $resp['nombre_cli']; ?></td>
                <th class="title-table-td" style="width:8%">O.T.</th>
                <td  style="width:10%;text-align:center;color:crimson"><strong><?php echo $resp['folio']; ?></strong></td>
            </tr>
            <tr>
                <th class="title-table-td">Solicitó:</th>
                <td><?php echo $resp['titulo'].'. '.$resp['nombre_user']; ?></td>
                <th class="title-table-td">Fecha:</th>
                <td style="text-align:center"><?php echo Fecha::convertir($resp['fecha']); ?></td>
            </tr>
            <tr>
                <th class="title-table-td">Departamento:</th>
                <td><?php echo $resp['depto']; ?></td>
                <th class="title-table-td">Cotización:</th>
                <td style="text-align:center"><?php echo $resp['folio_cot']; ?></td>
            </tr>
        </table>

        <table class="table-header-title" style="margin-top:10px">
            <thead>
                <th style="width: 6.3%;" class="title-table-td">Pda.</th>
                <th style="width: 6.6%;" class="title-table-td">Cantidad</th>
                <th style="width: 8%;" class="title-table-td"> Unidad</th>
                <th class="title-table-td">Descripción</th>
            </thead>
        </table>
    </header>
    <footer>
        <table class="signature-table content-table">
            <tr>
                <td class="left">
                    <strong>ENTREGA POR M.S.P.</strong>
                </td>
                <td class="right">
                <strong>RECIBE POR EL CLIENTE</strong>
                </td>
            </tr>
            <tr>
                <td class="left" style="height: 80px;">
                    <p style="margin-bottom:-30px">
                        ____________________________________ <br>
                        <strong><?php echo $resp['nombre'].' '.$resp['apellidos']; ?></strong> <br> JEFE DE VENTAS
                    </p>

                </td>
                <td class="right">
                    <p style="margin-bottom:-30px">

                        ____________________________________ <br>
                        <strong><?php echo $resp['nombre_recibe']; ?></strong><br>(Nombre y Firma)
                    </p>

                </td>
            </tr>
           
        </table>
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
        <table class="table-header-title" style="border:unset">
            <?php foreach($oEntrega->Servprint($resp['pkentrega']) as $result){ ?>
            <tr>
                <td valign="top" style="width: 6.3%;text-align:right"><?php echo $result['pda']; ?></td>
                <td valign="top" style="width: 6.6%;text-align:right"><?php echo $result['cantidad']; ?></td>
                <td valign="top" style="width: 8%;text-align:center"><?php echo $result['nombre']; ?></td>
                <td><?php echo nl2br($result['descripcion']); ?>
                </td>
            </tr>
            <?php } ?>
            
        </table>

        <table class="content-table" style="margin-top:20px">
            <tr class="title-table-td ">
                <th colspan="2" style="text-align: center;">Observaciones</th>
            </tr>
            <tr>
                <td class="observaciones" colspan="2">
                    <?php echo $resp['observaciones']; ?>
                </td>
            </tr>
        </table>
        <table class="content-table" style="margin-top:20px">
            <tr class="title-table-td ">
                <th colspan="2" style="text-align: center;">Evidencia</th>
            </tr>
            <tr>
                <td class="observaciones" colspan="2">
                    <center><img src="<?php echo $base642;?>"  style="windth:180px;height:180px;"></center>
                </td>
            </tr>
        </table>
        
    </main>

</body>



</html>


<?php
$folio =substr($resp['folio'],0,-3) ;

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
$dompdf->stream("ENT.-{$folio}.pdf", array("Attachment" => false));


?>