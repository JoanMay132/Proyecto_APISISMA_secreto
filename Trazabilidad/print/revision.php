<?php ob_start();

include_once("../../controlador/conexion.php");
include_once("../../controlador/Revpreeliminar.php");
include_once("../../class/Fecha.php");
include_once("../../class/Header.php");
require_once("../../dependencias/dompdf/autoload.inc.php");

$idRev = (int) base64_decode($_GET['revision']);
if(!filter_var($idRev,FILTER_VALIDATE_INT)){ echo "LA URL NO ES VALIDA :("; return false;}

 //Se crea el objeto
$oRev = new Revpreeliminar();
$nControl = 5;

$resp = $oRev->Print($idRev);

//Codigo para encriptación de imagen y poder renderizar en dompdf
$path = '../../dependencias/img/mspnew.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

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
    <title>PRINT - REVISION</title>
    <style>
    @page {
        margin: 20px;
        margin-left: 40px;
        margin-top: 240px;
        margin-bottom: 60px;
    }

    header {
        position: fixed;
        top: -220px;
        bottom: 0;
        left: 0;
        right: 0;
    }

    footer {
        position: fixed;
        bottom: -38px;
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
        border-bottom: 1.5px solid black;
        padding: 3px
    }

    .observaciones {
        height: auto;
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
                <td id="img-h1" style="padding:0px;"><img src="<?php echo $base64; ?>" style="width:150px;height:60px;position:relative;top:-20px;margin-left:5px"></td>
                <td class="contact-info">
                    <!-- <strong>HENRRY HERNANDEZ PEREZ</strong><br>
                    CALLE OCHO, LT-1-C MZA-III, FRACCIONAMIENTO DEIT,<br>
                    RIA. ANACLETO CANABAL 1RA. SECC.<br>
                    CENTRO, TABASCO, CP. 86287<br>
                    TEL: (993) 337 9968<br>
                    <a href="mailto:ventas01@mspetroleros.com">ventas01@mspetroleros.com</a> -->
                </td>
                <td class="header">
                    <div style="margin-right:0px;position:relative;width:130%;margin-top:-35px;right:30%">
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
                <td><?= $resp['nombre_cli']; ?></td>
                <th style="width:8%" rowspan="2" class="title-table-td">FOLIO</th>
                <td valign="middle" rowspan="2" style="width:10%;text-align:center;color:crimson">
                    <strong><?= $resp['folio'] ?></strong></td>
            </tr>
            <tr>
                <th class="title-table-td">Solicitó:</th>
                <td><?= $resp['titulo'].'. '.$resp['nombre_user']; ?></td>
            </tr>
            <tr>
                <th class="title-table-td">Departamento:</th>
                <td><?= $resp['depto'] ?></td>
                <th class="title-table-td">Fecha:</th>
                <td style="text-align:center"><?= Fecha::convertir($resp['fecha']); ?></td>
            </tr>
            <tr>
                <th valign="top" class="title-table-td">Proyecto:</th>
                <td colspan="3"><?= $resp['proyecto'] ?></td>
            </tr>
        </table>

        <table class="table-header-title" style="margin-top:10px">
            <tr>
                <th colspan="4" class="title-table-td" style="text-align:left">Trabajo a realizar:</th>
            </tr>
            <thead>
                <th style="width: 6.3%;" class="title-table-td">Pda.</th>
                <th style="width: 6.6%;" class="title-table-td">Cantidad</th>
                <th style="width: 8%;" class="title-table-td"> Unidad</th>
                <th style="width: 79.1%;" class="title-table-td">Descripción</th>
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
    </footer>


    <main>
        <table class="table-header-title" style="border:unset">
            <?php foreach($oRev->Servprint($resp['pkrevpreeliminar']) as $row){ ?>
            <tr>
                <td valign="top" style="width: 6.3%;text-align:right"><?=  $row['pda']; ?></td>
                <td valign="top" style="width: 6.6%;text-align:right"><?=  $row['cantidad']; ?></td>
                <td valign="top" style="width: 8%;text-align:center"><?=  $row['nombre']; ?></td>
                <td><?= nl2br($row['descripcion']); ?></td>
            </tr>
            <?php } ?>

        </table>
        <table class="signature-table content-table" style="margin-top:10px">
            <tr>
                <td colspan="2" class="title-table-td">
                    <strong>Requisitos de Inspección y Documentación</strong>
                </td>
            </tr>
            <tr>
                <td style="height:40px" colspan="2" valign="top"><?= nl2br($resp['reqinsdoc']); ?></td>
            </tr>
            <tr>
                <th width="50%" class="title-table-td">Requisitos Legales y Reglamentarios</th>
                <th width="50%" class="title-table-td">Requisitos de Entrega</th>
            </tr>
            <tr>
                <td style="height:40px" valign="top"><?= nl2br($resp['reqlegales']); ?></td>
                <td valign="top"><?= nl2br($resp['reqent']); ?></td>
            </tr>
            <tr>
                <th width="50%" class="title-table-td">Condiciones de Pago</th>
                <th width="50%" class="title-table-td">Requisitos Especiales del Servicio</th>
            </tr>
            <tr>
                <td style="height:40px" valign="top"><?= nl2br($resp['condpago']); ?></td>
                <td valign="top"><?= nl2br($resp['reqespserv']); ?></td>
            </tr>
            <tr>
                <th width="50%" class="title-table-td">Desviaciones/Excepciones</th>
                <th width="50%" class="title-table-td">Uso de Propiedad del Cliente</th>
            </tr>
            <tr>
                <td style="height:40px" valign="top"><?= $resp['desviacionexc']; ?></td>
                <td valign="top"><?= nl2br($resp['propcli']); ?></td>
            </tr>
            <tr>
                <th colspan="2"  valign="top" >
                    Revisiones (Fecha y firma)<br><br>
                    <div style="white-space:nowrap;padding:30px;">
                        <div style="white-space:nowrap;margin-left:40px;display:inline-block">
                            <p style="display:inline-block;margin:0">Ventas:</p>
                            <small style="display:inline-block;margin:0;margin-left:10px;font-weight:normal"><?= $resp['nombre_ventas'].' '.$resp['apellido_ventas']; ?></small>
                        </div>

                        <div style="white-space:nowrap;margin-left:150px;display:inline-block">
                            <p style="display:inline-block;margin:0">Producción:</p>
                            <small style="display:inline-block;margin:0;margin-left:10px;font-weight:normal"><?= $resp['nombre_produccion'].' '.$resp['apellido_produccion']; ?></small>
                        </div><br>

                        
                    </div>
                    <div style="white-space:nowrap;padding:30px;margin-top:-10px">
                         <div style="white-space:nowrap;margin-left:40px;display:inline-block">
                            <p style="display:inline-block;margin:0">Calidad:</p>
                            <small style="display:inline-block;margin:0;margin-left:10px;font-weight:normal"><?= $resp['nombre_calidad'].' '.$resp['apellido_calidad']; ?></small>
                        </div>
                    </div>
                </th>
            </tr>
        </table>
    </main>

</body>



</html>


<?php
$folio = substr($resp['folio'],0,-3);

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
$dompdf->stream("REV.-{$folio}.pdf", array("Attachment" => false));


?>