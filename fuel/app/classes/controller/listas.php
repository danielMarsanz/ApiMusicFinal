<?php 

use Firebase\JWT\JWT;

class Controller_Lists extends Controller_Rest
{
    private $key = 'ifwueFewFWJfwopifh6854fwFWEFJweiofkweff5e4f';
    
    public function post_create()
    {
        try {
             $jwt = apache_request_headers()['Authorization'];
            if ( ! isset($_POST['title']) || $_POST['title'] == "") 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita el titulo'
                ));

                return $json;
            }

            if ($this->validateToken($jwt)) {
                $token = JWT::decode($jwt, $this->key, array('HS256'));

                $input = $_POST;
                $list = new Model_Lists();
                $list->titulo = $input['title'];
                $list->id_usuario = $token->data->id;
                $user->save();

                $json = $this->response(array(
                    'code' => 200,
                    'message' => 'lista creada',
                    'name' => $input['title']
                ));

                return $json;
            }
        } 
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        } 
    }

    public function get_lists()
    {
    	try{
            $jwt = apache_request_headers()['Authorization'];
            if($this->validateToken($jwt)){
              $token = JWT::decode($jwt, $this->key, array('HS256'));
              $id_usuario = $token->data->id;
              
              $lists = Model_Lists::find('all', array(
                    'where' => array(
                        array('id_usuario', $id_usuario),
                  )));
              if($lists != null){
                $json = $this->response(array(
                'code' => 200,
                'message' => 'listas devueltas',
                'lists' => $lists
                ));

                return $json;
              }else{
               $json = $this->response(array(
                'code' => 200,
                'message' => 'No hay listas',
                ));

                return $json;
              }
            }
        }catch (Exception $e) {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        }  
    }

    public function post_delete()
    {
        try{
            $jwt = apache_request_headers()['Authorization'];
            if($this->validateToken($jwt)){
                $token = JWT::decode($jwt, $this->key, array('HS256'));
                $id = $_POST['id'];
           
                $list = Model_Lists::find('first', array(
                    'where' => array(
                        array('id', $id),
                        array('id_usuario', $token->data->id)
                    )
                ));

                if($list != null){
                    $list->delete();
                    
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'lista borrada',
                        'name' => $list->titulo;
                     ));

                    return $json;
                }else{
                   $json = $this->response(array(
                        'code' => 400,
                        'message' => 'lista no borrada',
                        'name' => $list->titulo;
                    ));

                 return $json;
                }
            
            }
        }
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        } 
    }

    public function post_edit()
    {
        try{
            $jwt = apache_request_headers()['Authorization'];
            if($this->validateToken($jwt)){
                $token = JWT::decode($jwt, $this->key, array('HS256'));
                $id_usuario = $token->data->id;

                $id = $_POST['id'];
                $nuevoTitulo = $_POST['titulo'];
           
                $list = Model_Lists::find('first', array(
                    'where' => array(
                        array('id', $id),
                        array('id_usuario', $id_usuario)
                    )
                ));

                if($list != null){
                    $list->titulo = $nuevoTitulo;
                    $list->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'lista editada',
                'name' => $list->titulo;
            ));

            return $json;
        }
        catch (Exception $e) 
        {
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        } 
    }

    public function validateToken($jwt){
        $token = JWT::decode($jwt, $this->key, array('HS256'));
        $nombre = $token->data->nombre;
        $contraseña = $token->data->contraseña;
        $registeredUser = Model_Users::find('all', array(
        'where' => array(
            array('nombre', $nombre),
            array('contraseña', $contraseña)
            )
        ));
        if($registeredUser != null){
            return true;
        }else{
            return false;
        }
    }
}
