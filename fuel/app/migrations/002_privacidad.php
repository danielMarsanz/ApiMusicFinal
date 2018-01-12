<?php
namespace Fuel\Migrations;

class Privacidad
{

    function up()
    {
        \DBUtil::create_table('privacidad', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'autos_increment' => true),
            'perfil' => array('type' => 'int', 'constraint' => 1),
            'amigos' => array('type' => 'int', 'constraint' => 1),
            'listas' => array('type' => 'int', 'constraint' => 1),
            'notificaciones' => array('type' => 'int', 'constraint' => 1),
            'localizacion' => array('type' => 'int', 'constraint' => 1),

        ), array('id'));                                                    
    }                                             

    function down()
    {
       \DBUtil::drop_table('privacidad');                  
    }
} 