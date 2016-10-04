<?php

use Phinx\Migration\AbstractMigration;

class CreateSlidesTable extends AbstractMigration
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
        $this->table('slides')
            ->addColumn('title', 'string', array('limit' => 100))
            ->addColumn('picture_file', 'string', array('limit' => 200))
            ->addColumn('article_position', 'string', array('limit' => 100))
            ->addColumn('article_content', 'text', array('null' => true))
            ->addColumn('slider_id', 'integer')
            ->addForeignKey('slider_id', 'sliders', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->create();
    }
}
