<?php
use Migrations\AbstractMigration;

class CreateSlides extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('slides');
        $table->addColumn('priority', 'integer', [
                'default' => 0,
                'null' => false,
              ])
              ->addColumn('file', 'string', [
                  'default' => null,
                  'null' => false,
              ])
              ->addColumn('name', 'string', [
                  'default' => null,
                  'null' => true,
              ])
              ->addColumn('dir', 'string', [
                  'default' => null,
                  'null' => true,
              ])
              ->addColumn('size', 'string', [
                  'default' => null,
                  'null' => true,
              ])
              ->addColumn('type', 'string', [
                  'default' => null,
                  'null' => true,
              ])
              ->addColumn('created', 'datetime', [
                'null' => false,
              ])
              ->addColumn('modified', 'datetime', [
                'null' => false,
              ])
              ->create();
    }
}
