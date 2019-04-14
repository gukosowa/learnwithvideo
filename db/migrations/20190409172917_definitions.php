<?php


use Phinx\Migration\AbstractMigration;

class Definitions extends AbstractMigration
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
        $table = $this->table('definitions');
        $table
                ->addColumn('word', 'string', ['limit' => 25])
                ->addColumn('furigana', 'string', ['limit' => 25])
                ->addColumn('part_of_speech', 'string', ['limit' => 3, 'comment' => 'n = noun, v = verb, a = Adj, i = iAdj, in = interjection na = naAdj, 
                c = conjunction, adv = adverb, pA = prenounAdjective, p = particle, su = suffix, pr = prefix, pp = preposition, mw = measure word'])
                ->addColumn('definition', 'string')
                ->addColumn('jlpt', 'integer')
                ->addColumn('tags', 'string')
                ->addColumn('image', 'string')
                ->addColumn('ispeech_id', 'integer')
                ->addTimestamps()
                ->save();
    }
}
