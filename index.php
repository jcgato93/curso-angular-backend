<?php

require_once 'vendor/autoload.php';


$app = new \Slim\Slim();

$db= new mysqli('127.0.0.1','root','', 'curso_angular4');


$app->get("/pruebas",function() use($app, $db){

    echo "Hola mundo desde Slim PHP";
    var_dump($db);
});

$app->post('/productos', function() use($app, $db){
    $json = $app->request->post('json');
    $data = json_decode($json,true);
    
    if (!isset($data['nombre'])) {
        $data['nombre']=null;
    }

    if (!isset($data['imagen'])) {
        $data['imagen']=null;
    }

    if (!isset($data['descripcion'])) {
        $data['descripcion']=null;
    }

    if (!isset($data['precio'])) {
        $data['precio']=null;
    }

    $query = "INSERT INTO productos VALUES(NULL,".
              "'{$data['nombre']}',".
              "'{$data['descripcion']}',".
              "'{$data['precio']}',".
              "'{$data['imagen']}'".
              ");";

     $insert = $db->query($query);

     $result= array(
        'status' => 'error',
        'code' => 404,
        'message' => 'Producto No se ha creado correctamente'
    );

     if ($insert) {
         $result= array(
             'status' => 'success',
             'code' => 200,
             'message' => 'Producto creado correctamente'
         );
        
     }

     echo json_encode($result);

});


$app->run();