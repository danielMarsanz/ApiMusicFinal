<?php 

use Firebase\JWT\JWT;
class Controller_Songs extends Controller_Rest
{
    private $key = 'ifwueFewFWJfwopifh6854fwFWEFJweiofkweff5e4f';
    
    public function post_create()
    {
        try {
             $jwt = apache_request_headers()['Authorization'];
            if ( ! isset($_POST['title']) || $_POST['title'] == "" || ! isset($_POST['artist']) || $_POST['artist'] == "" || ! isset($_POST['url']) || $_POST['url'] == "") 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesitan todos los parametros'
                ));

                return $json;
            }

            if ($this->validateToken($jwt)) {
                $token = JWT::decode($jwt, $this->key, array('HS256'));

                $input = $_POST;
                $song = new Model_Songs();
                $song->titulo = $input['title'];
                $song->artista = $input['artist'];
                $song->url = $input['url'];
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

    public function get_songs()
    {
    	try{
            $jwt = apache_request_headers()['Authorization'];
            if($this->validateToken($jwt)){
              $token = JWT::decode($jwt, $this->key, array('HS256'));
              
              
              $songs = Model_Songs::find('all');

              if($songs != null){
                $json = $this->response(array(
                'code' => 200,
                'message' => 'canciones devueltas',
                'lists' => $songs
                ));

                return $json;
              }else{
               $json = $this->response(array(
                'code' => 200,
                'message' => 'No hay canciones',
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
           
                $song = Model_Songs::find($id);

                if($song != null){
                    $song->delete();
                    
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'cancion borrada',
                        'name' => $song->titulo;
                     ));

                    return $json;
                }else{
                   $json = $this->response(array(
                        'code' => 400,
                        'message' => 'cancion no borrada',
                        'name' => $song->titulo;
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

                $id = $_POST['id'];
           
                $song = Model_Songs::find($id);

                if($songs != null){
                    if (!empty($_POST['titulo'])){
                            $song->titulo = $_POST['title'];  
                        }
                    if (!empty($_POST['artista'])){
                        $song->artista = $_POST['artist'];
                    }
                    if (!empty($_POST['url'])){
                        $song->url = $_POST['url'];
                    }
                    $song->save();

                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'lista editada',
                        'name' => $list;
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