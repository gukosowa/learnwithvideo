<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Expression;

class KanjiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //* Uncomment this if create new entries
        // DB::table("kanji")->truncate();
        $json_kanji_path = __DIR__ . "/kanjiDatabase_kanjidatabase.com.json";


        //! entry has failure. must replace "rei,    ..." with "rei, ..." and "i,  " -> "i,
        //! "On_within_Joyo": "rei,

        $data = file_get_contents ($json_kanji_path);
        $json = json_decode($data, true);


        if(DB::table('kanji')->count() != 0)
        {
            return;
        } else {
            echo "\n\nCreate Kanji DB\n";
        }


        $i = 0;
        foreach($json["database"]["Kanji_data"] as $kObject) {
            $i++;

            // if ($i >= 1200 && $i < 1220) {
            // } else {
            //     continue;
            // }

            DB::table('kanji')->insert([
                'kanji'             => $kObject["Kanji"],
                'strokes'           => $kObject["Strokes"],
                'reading'           => $kObject["Reading_within_Joyo"],
                'grade'             => $kObject["Grade"],
                'jlpt'              => ($kObject["JLPT-test"] != "-" ? $kObject["JLPT-test"] : -1),
                'freq'              => $kObject["Kanji_Frequency_with_Proper_Nouns"],
                'translation_on'    => (!isset($kObject["Translation_of_On"])) ? "" : $kObject["Translation_of_On"],
                'translation_kun'   => (!isset($kObject["Translation_of_Kun"])) ? "" : $kObject["Translation_of_Kun"],
                'created_at'        => now()
            ]);

            
        }
    }
}


interface JsonStreamingParser_Listener {
    public function file_position($line, $char);
    //this is called when the document starts
    public function start_document();
    
    //this is called on EOF
    public function end_document();
  
    //the start/end of an object
    public function start_object();
    public function end_object();
    
    //the start/end of an array
    public function start_array();
    public function end_array();
    
    // Called when a key is found
    public function key($key);
    
    // There it's a value
    public function value($value);
    
    public function whitespace($whitespace);
  }