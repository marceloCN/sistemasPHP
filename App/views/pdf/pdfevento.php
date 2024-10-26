<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Marcaciones</title>
    <style>
        th {
            background-color: #2E64FE;
            color: #000000;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .td {
            padding: 2px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
            text-align: center;
        }

        .imagen {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 693px;
            height: 120px;
        }
    </style>
</head>

<body>
    <img src="<?= constant('URL') ?>/fondo.jpg" alt="Imagen" class="imagen">
    <div style=" font-family: serif ;">
        <br><br><br><br><br><br><br>
        <div class=" " style="margin: 2px; border: 1px solid #2196f3; font-size:13px; margin-bottom: 15px">
            <div class=" " style="background:#e8eaf6 ;font-size:14px; color:#01579b ;text-align: center; font-weight: bold;">Registro de Marcaciones</div>
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="" width="10%" style="margin: 10px;">
                        <div class=" " style="padding: 4px; margin: 5px; background:#e8eaf6  ;color:#01579b; font-weight: bold;">Cargo: </div>
                    </td>
                    <td class="" width="90%" style="margin: 10px;">
                        <div class="" style="padding: 4px; margin: 5px; text-align: center;"><?= $datos_funcionario['cargo'] ?></div>
                    </td>
                </tr>
            </table>
            <hr style="border: none; border-top: 1px solid #ccc; margin: 0; padding: 0;">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="" width="12%" style="margin: 10px;">
                        <div class="  " style="padding: 4px; margin: 5px; background:#e8eaf6 ;color:#01579b ; font-weight: bold;">Funcionario: </div>
                    </td>
                    <td class="" width="58%" style="margin: 10px;">
                        <div class="" style="padding: 4px; margin: 2px; font-size:14px ; text-align: center;"><?= $datos_funcionario['nombre'] ?> </div>
                    </td>
                    <td class="" width="5%" style="margin: 10px;">
                        <div class=" " style="padding: 4px; margin: 2px; background:#e8eaf6 ;color:#01579b ; font-weight: bold;">CI: </div>
                    </td>
                    <td class="" width="30%" style="margin: 10px;">
                        <div class="" style="padding: 4px; margin: 2px; font-size:14px ; text-align: center;"><?= $datos_funcionario['ci'] ?></div>
                    </td>
                <tr>
            </table>

            <hr style="border: none; border-top: 1px solid #ccc; margin: 0; padding: 0;">

            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="" width="20%" style="margin: 10px;">
                        <div class=" " style="padding: 4px; margin: 5px; background:#e8eaf6 ;color:#01579b ;font-weight: bold;">Minutos Acum: </div>
                    </td>
                    <td class="" width="30%" style="margin: 10px;">
                        <div class="" style="padding: 4px; margin: 2px;  font-size:14px ; text-align: center;"><?= $datos_funcionario['totalretrazo'] ?> minutos</div>
                    </td>
                    <td class="" width="15%" style="margin: 10px;">
                        <div class="  " style="padding: 4px; margin: 2px;  background:#e8eaf6 ;color:#01579b ;font-weight: bold;">Fecha Actual: </div>
                    </td>
                    <td class="" width="40%" style="margin: 10px;">
                        <div class="" style="padding: 4px; margin: 2px;  font-size:14px ; text-align: center;"><?= date('Y-m-d') ?></div>
                    </td>
                </tr>
            </table>
            <hr style="border: none; border-top: 1px solid #ccc; margin: 0; padding: 0;">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="" width="30%" style="margin: 10px;">
                        <div class=" " style="padding: 4px; margin: 5px; background:#e8eaf6 ;color:#01579b ;font-weight: bold;">Marcacion a partir de la fecha : </div>
                    </td>
                    <td class="" width="20%" style="margin: 10px;">
                        <div class="" style="padding: 4px; margin: 2px;  font-size:14px ; text-align: center;"><?= $datos_funcionario['fechainicio'] ?></div>
                    </td>
                    <td class="" width="10%" style="margin: 10px;">
                        <div class="  " style="padding: 4px; margin: 2px;  background:#e8eaf6 ;color:#01579b ;font-weight: bold;">Hasta: </div>
                    </td>
                    <td class="" width="40%" style="margin: 10px;">
                        <div class="" style="padding: 4px; margin: 2px;  font-size:14px ; text-align: center;"><?= $datos_funcionario['fechafin'] ?></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="" style="margin: 2px; border: 1px solid #2196f3; font-size:13px; margin-bottom: 5px">
            <table width="100%" cellspacing="0" cellpadding="0">
                <thead>
                    <tr>
                        <th>Fechas</th>
                        <th>Dias</th>
                        <th>1er Entrada</th>
                        <th>1er Salida</th>
                        <th>2da Entrada</th>
                        <th>2da Salida</th>
                        <th>Calculo</th>
                        <th>Ubicación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($calculosObj != null) {
                        foreach ($calculosObj as $calculo) {
                    ?>
                            <tr>
                                <td class="td"><?= $calculo['fecha'] ?></td>
                                <td class="td"><?= $calculo['dia'] ?></td>
                                <td class="td"><?= $calculo['hora1'] ?></td>
                                <td class="td"><?= $calculo['hora2'] ?></td>
                                <td class="td"><?= $calculo['hora3'] ?></td>
                                <td class="td"><?= $calculo['hora4'] ?></td>
                                <td class="td"><?= $calculo['minretrazo'] ?></td>
                                <td class="td">
                                    <?php
                                    //busca la ubicacion que corresponde dicho id
                                    $localizacion_id = $calculo['localizacion_id'];
                                    if ($localizacionObj != null) {
                                        foreach ($localizacionObj as $localizacion) {
                                            if ($localizacion['id'] == intval($localizacion_id)) {
                                                echo $localizacion['ubicacion'];
                                                break;
                                            }
                                        }
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>