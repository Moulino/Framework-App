<?php

use Phinx\Migration\AbstractMigration;

class AlterColumnsInCardTable extends AbstractMigration
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
        $this->table('cards')
            ->renameColumn('title', 'title_fr')
            ->addColumn('title_en', 'text', array('limit' => 100))
            ->addColumn('title_de', 'text', array('limit' => 100))
            ->addColumn('title_nl', 'text', array('limit' => 100))
            ->renameColumn('content', 'content_fr')
            ->addColumn('content_en', 'text', array('null' => true))
            ->addColumn('content_de', 'text', array('null' => true))
            ->addColumn('content_nl', 'text', array('null' => true))
            ->save();
    }
}
