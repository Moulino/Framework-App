<?php

use Phinx\Migration\AbstractMigration;

class CreateTilesTable extends AbstractMigration
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
        $this->table('tiles')
            ->addColumn('title', 'string', array('limit' => 100))
            ->addColumn('content', 'text', array('null' => true))
            ->addColumn('picture_file', 'string', array('limit' => 500))
            ->addColumn('uri', 'string', array('limit' => 100))
            ->addColumn('tile_group_id', 'integer')
            ->addForeignKey('tile_group_id', 'tile_groups', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->create();
    }
}
