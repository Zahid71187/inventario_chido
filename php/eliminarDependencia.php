<?php
// Incluir archivo de conexión a la base de datos
require 'db_connection.php';

$id = $_POST['id'];

$datos = array();

// Verificar si se ha enviado un ID de dependencia
if (isset($id)) {
    // Obtener el ID de la dependencia
    try {
        // Eliminar la dependencia de la base de datos
        $query = "DELETE FROM tblDependencia WHERE idDependencia = ?";
        $params = array($id);
        $result = sqlsrv_query($connection, $query, $params);

        // Verificar si se eliminó la dependencia correctamente
        if ($result) {
            $datos['status'] = 1;
            $datos['msg'] = "Dependencia eliminada correctamente.";
        } else {
            // Si hubo un error al eliminar la dependencia, enviar una respuesta JSON al cliente
            $datos['status'] = 0;
            $errors = sqlsrv_errors();
            $datos['msg'] =  "Error al eliminar el registro: " . $errors[0]['message'];
        }
    } catch (Exception $e) {
        $datos['status'] = 0;
        $datos['msg'] =  "Error al eliminar el registro: ".$e->getMessage();
    }
    sqlsrv_close($connection);
    $json = json_encode($datos);
    echo $json;
}
