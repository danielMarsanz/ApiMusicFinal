<?php
class Model_Lists extends Orm\Model {
	protected static $_table_name = 'listas';
	protected static $_primary_key = array('id');
	protected static $_properties = array(
        'id',
        'titulo' => array(
            'data_type' => 'text'   
        ),
        'id_usuario' => array(
            'data_type' => 'int'   
        )
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