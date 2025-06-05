<?php

require_once "global.php";
//conexion a la base de datos
$conexion = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
//SETEAMOS EL code de la BD
mysqli_query($conexion, "SET NAMES '" . DB_ENCODE . "'");
if (mysqli_connect_error()) {
    printf("Fallo la conexion a la BD: %s\n", mysqli_connect_error());
    exit();
}

if (!function_exists('ejecutarConsulta')) {
    function ejecutarConsulta($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $query;
    }

    function ejecutarConsultaSecuencial($sql)
    {
        global $conexion;
        $query = $conexion->multi_query($sql);
        return $query;
    }
    function ejecutarUpdate($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);


        if (!mysqli_query($conexion, $sql)) {
            return ('Error de update: ' . mysqli_error($conexion));
        } else {
            return $query;
        }
    }
    function ejecutarConsultaSimpleFila($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }
    function ejecutarConsultaId($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->insert_id;
    }
    function limpiarCadena($str)
    {
        global $conexion;
        $str = mysqli_real_escape_string($conexion, trim($str));
        return htmlspecialchars($str);
    }
}
