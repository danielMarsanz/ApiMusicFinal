<?php
namespace Fuel\Migrations;

class Contienen
{

    function up()
    {
        \DBUtil::create_table('contienen', array(
            'id_lista' => array('type' => 'int', 'constraint' => 11),
            'id_cancion' => array('type' => 'int', 'constraint' => 11),
            
        ), 

        array('id_lista', 'id_cancion'), false, 'InnoDB', 'utf8_unicode_ci',
            array(
                array(
                    'constraint' => 'claveAjenaContienenAListas',
                    'key' => 'id_lista',
                    'reference' => array(
                        'table' => 'listas',
                        'column' => 'id',
                    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'RESTRICT'
                ),
                array(
                    'constraint' => 'claveAjenaConitnenACanciones',
                    'key' => 'id_cancion',
                    'reference' => array(
                        'table' => 'canciones',
                        'column' => 'id',
                    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'RESTRICT'
                )
                
            )
        );
    }

    function down()
    {
       \DBUtil::drop_table('contienen');
    }
}