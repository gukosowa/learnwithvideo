<?php


use Phinx\Seed\AbstractSeed;

class KanjiSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        //* Uncomment this if create new entries
        // DB::table("kanji")->truncate();
        $table = $this->table('kanji');
        $table->truncate();

        $json_kanji_path = __DIR__ . "/kanjidatabase.com.json";


        //! entry has failure. must replace "rei,    ..." with "rei, ..." and "i,  " -> "i,
        //! "On_within_Joyo": "rei,

        $data = file_get_contents ($json_kanji_path);
        $json = json_decode($data, true);

        $count = count($this->query('SELECT * FROM kanji')->fetchAll());
        if($count != 0)
        {
            return;
        } else {
            echo "\n\nCreate Kanji DB\n";
        }


        $i = 0;
        $data = [];
        foreach($json["database"]["Kanji_data"] as $kObject) {
            $i++;

            $data[] = [
                'kanji'             => $kObject["Kanji"],
                'strokes'           => $kObject["Strokes"],
                'reading'           => $kObject["Reading_within_Joyo"],
                'grade'             => $kObject["Grade"],
                'jlpt'              => ($kObject["JLPT-test"] != "-" ? $kObject["JLPT-test"] : -1),
                'freq'              => $kObject["Kanji_Frequency_with_Proper_Nouns"],
                'translation_on'    => (!isset($kObject["Translation_of_On"])) ? "" : $kObject["Translation_of_On"],
                'translation_kun'   => (!isset($kObject["Translation_of_Kun"])) ? "" : $kObject["Translation_of_Kun"],
                'created_at'        => date('Y-m-d H:i:s')
            ];
        }

        $this->table('kanji')->insert($data)->save();
    }
}
