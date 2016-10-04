<?php

use Phinx\Migration\AbstractMigration;

class AlterColumnsInSlidesTable extends AbstractMigration
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
            ->renameColumn('title', 'title_fr')
            ->addColumn('title_en', 'text', array('limit' => 100))
            ->addColumn('title_de', 'text', array('limit' => 100))
            ->addColumn('title_nl', 'text', array('limit' => 100))
            ->renameColumn('article_position', 'text_position')
            ->renameColumn('article_content', 'text_fr')
            ->addColumn('text_en', 'text', array('null' => true))
            ->addColumn('text_de', 'text', array('null' => true))
            ->addColumn('text_nl', 'text', array('null' => true))
            ->renameColumn('picture_file', 'picture')
            ->save();
    }
}
