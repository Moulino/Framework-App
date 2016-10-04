<?php

use Phinx\Migration\AbstractMigration;

class CreateArticleTable extends AbstractMigration
{
    public function change()
    {
        $this->table('article')
            ->addColumn('label', 'string', array('limit' => 100))
            ->addColumn('content', 'text', array('null' => true))
            ->create();
    }
}
