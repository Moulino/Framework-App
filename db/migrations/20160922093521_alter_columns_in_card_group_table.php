<?php

use Phinx\Migration\AbstractMigration;

class AlterColumnsInCardGroupTable extends AbstractMigration
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
        $cardgroups = $this->table('card_groups');
        $cardgroups->renameColumn('title', 'label');
        $cardgroups->renameColumn('description', 'description_fr');
        $cardgroups->addColumn('description_en', 'text', array('null' => true))
            ->addColumn('description_de', 'text', array('null' => true))
            ->addColumn('description_nl', 'text', array('null' => true))
            ->save();
    }
}
