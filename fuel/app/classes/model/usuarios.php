<?php
class Model_Users extends Orm\Model {
	protected static $_table_name = 'usuarios';
	protected static $_primary_key = array('id');
	protected static $_properties = array(
        'id',
        'nombre' => array(
            'data_type' => 'text'   
        ),
        'contraseña' => array(
            'data_type' => 'text'   
        ),
        'email' => array(
            'data_type' => 'text'  
    );
    protected static $_has_many = array(
    	'listas' => array(
	        'key_from' => 'id',
	        'model_to' => 'Model_Users',
	        'key_to' => 'id_usuario',
	        'cascade_save' => true,
	        'cascade_delete' => false,
   	 	)
	);
}