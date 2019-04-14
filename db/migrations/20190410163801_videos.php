<?php


use Phinx\Migration\AbstractMigration;

class Videos extends AbstractMigration
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
        $table = $this->table('videos');
        $table
                ->addColumn('video_link', 'string')
                ->addColumn('video_plattform', 'string', ['default' => "youtube"])
                ->addColumn('title', 'string')
                ->addColumn('description', 'string')
                ->addColumn('views', 'integer')
                ->addColumn('difficulty', 'integer', ['limit' => 2])
                ->addTimestamps()
                ->save();
    }
}
