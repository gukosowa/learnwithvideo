<?php


use Phinx\Migration\AbstractMigration;

class Words extends AbstractMigration
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
        $table = $this->table('words');
        $table
                ->addColumn('definition_id', 'biginteger')
                ->addColumn('dialogue_id', 'biginteger')
                ->addColumn('start_char', 'integer')
                ->addColumn('word', 'string')
                ->addColumn('custom_definition', 'string')
                ->addColumn('custom_word', 'string', ['limit' => 60])
                ->addColumn('custom_furigana', 'string', ['limit' => 60])
                ->addColumn('ispeech_id', 'integer')
                ->addTimestamps()
                ->addForeignKey('definition_id', 'definitions', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
                ->addForeignKey('dialogue_id', 'dialogues', 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
                ->save();
    }
}
