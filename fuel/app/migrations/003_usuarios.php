<?php
namespace Fuel\Migrations;

class Usuarios
{

    function up()
    {
        \DBUtil::create_table('usuarios', array(
            'id' => array('type' => 'int', 'constraint' => 11, 'autos_increment' => true),
            'nombre' => array('type' => 'varchar', 'constraint' => 100),
            'contraseña' => array('type' => 'varchar', 'constraint' => 100),
            'email' => array('type' => 'varchar', 'constraint' => 100),
            'id_dispositivo' => array('type' => 'varchar', 'constraint' => 100),
            'foto_perfiles' => array('type' => 'varchar', 'constraint' => 100),
            'x' => array('type' => 'varchar', 'constraint' => 100),
            'y' => array('type' => 'varchar', 'constraint' => 100),
            'cumpleaños' => array('type' => 'varchar', 'constraint' => 100),
            'ciudad' => array('type' => 'varchar', 'constraint' => 100),
            'descripcion' => array('type' => 'varchar', 'constraint' => 100),
            'id_rol' => array('type' => 'int', 'constraint' => 11),
            'id_privacidad' => array('type' => 'int', 'constraint' => 11),

        ), array('id'),false, 'InnoDB', 'utf8_unicode_ci',
            array(
                array(
                    'constraint' => 'claveAjenaUsuariosARoles',
                    'key' => 'id_rol',
                    'reference' => array(
                        'table' => 'roles',
                        'column' => 'id',
                    ),
                    'on_update' => 'CASCADE',
                    'on_delete' => 'RESTRICT'
                ),
                array(
                    'constraint' => 'claveAjenaUsuariosAPrivacidad',
                    'key' => 'id_privacidad',
                    'reference' => array(
                        'table' => 'privacidad',
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
       \DBUtil::drop_table('usuarios');                  
    }
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 