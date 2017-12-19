<?php 

use Firebase\JWT\JWT;
class Controller_Users extends Controller_Rest
{
    private $key = 'ifwueFewFWJfwopifh6854fwFWEFJweiofkweff5e4f';
    
    public function post_create()
    {
        try {
            if ( ! isset($_POST['name']) || $_POST['name'] == "" || ! isset($_POST['pass']) || $_POST['pass'] == "" || ! isset($_POST['email']) || $_POST['email'] == "") 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita el nombre y la contraseña'
                ));

                return $json;
            }

            $input = $_POST;
            $user = new Model_Users();
            $user->nombre = $input['name'];
            $user->contraseña = $input['pass'];
            $user->email = $input['email'];
            $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'name' => $input['name']
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

    public function get_login()
    {
        try {
            if ( ! isset($_POST['name']) || $_POST['name'] == "" || ! isset($_POST['pass']) || $_POST['pass'] == "" 
            {
                $json = $this->response(array(
                    'code' => 400,
                    'message' => 'parametro incorrecto, se necesita el nombre y la contraseña'
                ));

                return $json;
            }

            
            $nombre = $_GET['name'];
            $contraseña = $_GET['pass'];

            $registeredUser = Model_Users::find('first', array(
                'where' => array(
                array('nombre', $nombre),
                array('contraseña', $contraseña)
                ),
            ));

            if($registeredUser != null){ 
            
            $time = time();
            $token = array(
                'iat' => $time, 
                'data' => [ 
                    'id' => $registeredUser['id'],
                    'nombre' => $nombre,
                    'contraseña' => $contraseña
                ]
            );
            $jwt = JWT::encode($token, $this->$key);
            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario creado',
                'name' => $input['name']
            ));
            }else{
                $this->createResponse(400, 'El usuario no existe');          
                return $json;
            } 
        }
        catch (Exception $e){
            $json = $this->response(array(
                'code' => 500,
                'message' => 'error interno del servidor',
            ));

            return $json;
        }

    }

    public function get_users()
    {
    	$users = Model_Users::find('all');

    	return $this->response(Arr::reindex($users));
    }

    public function post_delete()
    {
        try{
            $jwt = apache_request_headers()['Authorization'];
            if($this->validateToken($jwt)){
                $token = JWT::decode($jwt, $this->key, array('HS256'));
                $id = $token->data->id;
           
                $user = Model_Users::find($id);
                if($user != null){
                    $user->delete();
                    
                    $json = $this->response(array(
                        'code' => 200,
                        'message' => 'usuario borrado',
                        'name' => $user->nombre;
                     ));

                    return $json;
                }else{
                   $json = $this->response(array(
                        'code' => 400,
                        'message' => 'usuario no borrado',
                        'name' => $user->nombre;
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
                $nuevaContraseña = $_POST['contraseña'];
                $token = JWT::decode($jwt, $this->key, array('HS256'));
                $id = $token->data->id;
           
                $user = Model_Users::find($id);
                if($user != null){
                    $user->contraseña = $nuevaContraseña;
                    $user->save();

            $json = $this->response(array(
                'code' => 200,
                'message' => 'usuario editado',
                'name' => $user->nombre;
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
