<?php

use Phinx\Migration\AbstractMigration;

class CreatePageTable extends AbstractMigration
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
        $this->table('pages')
            ->addColumn('title', 'string', array('limit' => 100))
            ->addColumn('banner_file', 'string', array('limit' => 200, 'null' => true))
            ->addColumn('slider_id', 'integer', array('null' => true))
            ->addColumn('tile_group_id', 'integer', array('null' => true))
            ->addForeignKey('slider_id', 'sliders', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->addForeignKey('tile_group_id', 'tile_groups', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->create();
    }
}
