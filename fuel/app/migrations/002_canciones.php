<?php
namespace Fuel\Migrations;

class Canciones
{

    function up()
    {
        \DBUtil::create_table('canciones', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'autos_increment' => true),
            'titulo' => array('type' => 'varchar', 'constraint' => 100),
            'artista' => array('type' => 'varchar', 'constraint' => 100),
            'url' => array('type' => 'varchar', 'constraint' => 100),
        ), array('id'));
    }

    function down()
    {
       \DBUtil::drop_table('canciones');
    }
}