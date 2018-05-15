<?php

require_once 'vendor/autoload.php';


$app = new \Slim\Slim();

$db= new mysqli('127.0.0.1','root','', 'curso_angular4');


$app->get("/pruebas",function() use($app, $db){

    echo "Hola mundo desde Slim PHP";
    var_dump($db);
});


//Listar todos los productos 
$app->get("/productos",function() use($app, $db){
   
    $sql = "Select * From  productos  ORDER BY id Desc;";
    $query= $db->query($sql);

    $productos = array();

    while ($producto = $query->fetch_assoc()) {
        $productos[] = $producto;
    }

    $result= array(
        'status' => 'success',
        'code' => 200,
        'data' => $productos
    );

    echo json_encode($result);
});



//Devolver un producto
$app->get("/productos/:id",function($id) use($app, $db){
   $sql = 'SELECT * FROM productos WHERE id= '.$id;
   $query=$db->query($sql);

   
    $result = array(
      "status" => 'error',
      "code" => 404,
      "message" => 'Producto no disponible'
    );

   if($query->num_rows == 1){
    $producto= $query->fetch_assoc();
    
    $result = array(
        "status" => 'success',
        "code" => 200,
        "message" => $producto
    );
   }
  
   echo json_encode($result);

});

//Eliminar producto

//Actualizar producto


//Subir imagen



//Guardar productos
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