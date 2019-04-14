<?php


use Phinx\Migration\AbstractMigration;

class Kanjis extends AbstractMigration
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
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // create the table
        $table = $this->table('kanjis');
        $table
                ->addColumn('kanji', 'string', ['limit' => 10])
                ->addColumn('strokes', 'integer', ['limit' => 2])
                ->addColumn('reading', 'string')
                ->addColumn('grade', 'integer', ['limit' => 1])
                ->addColumn('jlpt', 'integer', ['limit' => 1])
                ->addColumn('freq', 'integer')
                ->addColumn('translation_on', 'text')
                ->addColumn('translation_kun', 'text')
                ->addTimestamps()
                ->save();
    }
}
