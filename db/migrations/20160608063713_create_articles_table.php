<?php

use Phinx\Migration\AbstractMigration;

class CreateArticlesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('articles')
            ->addColumn('label', 'string', array('limit' => 100))
            ->addColumn('content', 'text', array('null' => true))
            ->addColumn('picture_file', 'string', array('limit' => 200, 'null' => true))
            ->addColumn('page_id', 'integer')
            ->addForeignKey('page_id', 'pages', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->create();
    }
}
