<?php
include "config.php";
include "utils.php";
$dbConn =  connect($db);
/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id']))
    {
      //Mostrar un post
      $sql = $dbConn->prepare("SELECT origen, destino, diayhora FROM vuelos where idVuelo=:idVuelo");
      $sql->bindValue(':idVuelo', $_GET['idVuelo']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
    }
    else {
      //Mostrar lista de post
      $sql = $dbConn->prepare("SELECT origen, destino, diayhora FROM vuelos");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      //echo "<pre>";
      echo json_encode( $sql->fetchAll(), JSON_PRETTY_PRINT  );
      //echo "<pre>";
      exit();
  }
}
// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO vuelos
          (diayhora, origen, destino, precio, plazas_totales, plazas_libres)
          VALUES
          (:diayhora, :origen, :destino, :precio, :plazas_totales, :plazas_libres)";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    $postId = $dbConn->lastInsertId();
    if($postId)
    {
      $input['id'] = $postId;
      header("HTTP/1.1 200 OK");
      echo json_encode($input);
      exit();
   }
}
//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
  $idVuelo = $_GET['idVuelo'];
  $statement = $dbConn->prepare("DELETE FROM vuelos where idVuelo=:idVuelo");
  $statement->bindValue(':idVuelo', $idVuelo);
  $statement->execute();
  header("HTTP/1.1 200 OK");
  exit();
}
//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postId = $input['idVuelo'];
    $fields = getParams($input);
    $sql = "
          UPDATE vuelos
          SET $fields
          WHERE idVuelo='$postId'
           ";
    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);
    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}
//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
?>
