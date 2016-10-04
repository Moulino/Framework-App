<?php

use Phinx\Migration\AbstractMigration;

class InitTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('users')
            ->addColumn('user_id', 'string', array('limit' => 100))
            ->addColumn('name', 'string', array('limit' => 100))
            ->addColumn('password', 'string', array('limit' => 100))
            ->addColumn('mail', 'string', array('limit' => 100))
            ->addColumn('roles', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('errors', 'integer')
            ->addIndex(array('user_id'), array('unique' => true))
            ->create();

        $this->table('articles')
            ->addColumn('label', 'string', array('limit' => 100))
            ->addColumn('content_fr', 'text', array('null' => true))
            ->addColumn('content_en', 'text', array('null' => true))
            ->addColumn('content_nl', 'text', array('null' => true))
            ->addColumn('content_de', 'text', array('null' => true))
            ->addColumn('order', 'integer', array('null' => true))
            ->addColumn('inverted', 'boolean', array('null' => true))
            ->addColumn('parallax', 'boolean', array('null' => true))
            ->addColumn('picture_file', 'string', array('limit' => 200, 'null' => true))
            ->create();
    }
}
