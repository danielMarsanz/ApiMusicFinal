<?php
class Model_Songs extends Orm\Model {
	protected static $_table_name = 'canciones';
	protected static $_primary_key = array('id');
	protected static $_properties = array(
        'id',
        'titulo' => array(
            'data_type' => 'text'   
        ),
        'artista' => array(
            'data_type' => 'text'   
        ),
        'url' => array(
            'data_type' => 'text' 
    );
        protected static $_belongs_to = array(
            'usuario' => array(
                'key_from' => 'id_usuario',
                'model_to' => 'Model_Users',
                'key_to' => 'id',
                'cascade_save' => true,
                'cascade_delete' => false,
            )
    );
}