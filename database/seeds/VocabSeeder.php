<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use PhpParser\Node\Stmt\Expression;

class VocabSeeder extends Seeder
{
    private $emptyTable = false;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::table("vocab")->truncate();
        return;
        
        $adj            = json_decode(file_get_contents (__DIR__ . "/JapaneseJsons/adj.json"), true);
        $adverbs        = json_decode(file_get_contents (__DIR__ . "/JapaneseJsons/adverbs.json"), true);
        $conjunction    = json_decode(file_get_contents (__DIR__ . "/JapaneseJsons/conjunction.json"), true);
        $interjection   = json_decode(file_get_contents (__DIR__ . "/JapaneseJsons/interjection.json"), true);
        $nouns          = json_decode(file_get_contents (__DIR__ . "/JapaneseJsons/nouns.json"), true);
        $preAdj         = json_decode(file_get_contents (__DIR__ . "/JapaneseJsons/preAdj.json"), true);
        $verbs          = json_decode(file_get_contents (__DIR__ . "/JapaneseJsons/verbs.json"), true);

        if(DB::table('vocab')->count() != 0)
        {
            $this->emptyTable = false;
        } else {
            echo "\n\nCreate Vocabs DB\n";
            $this->emptyTable = true;
        }

        $this->insertTable($adj,            "a");
        $this->insertTable($adverbs,        "adv");
        $this->insertTable($conjunction,    "c");
        $this->insertTable($interjection,   "in");
        $this->insertTable($nouns,          "n");
        $this->insertTable($preAdj,         "pA");
        $this->insertTable($verbs,          "v");

    }

    function insertTable($json, $cat) {
        foreach($json as $word) {
            $jlptLevel = -1;
            $jpWord = "";
            $jpReading = "";
            $tags = "";
            $descString = "";
            try {
                $client = new Client();
                $res = $client->request('GET', 'https://jisho.org/api/v1/search/words?keyword=' . urlencode($word["Kanji"]));
                $jishoResult = json_decode($res->getBody()->getContents())->data;
                $jlptLevel  = (!isset($jishoResult[0]->jlpt[0])) ? -1 : str_replace("jlpt-n", "", $jishoResult[0]->jlpt[0]);
                
                $jpWord     = (!isset($jishoResult[0]->japanese[0]->word)) ? "" : $jishoResult[0]->japanese[0]->word;
                $jpReading  = (!isset($jishoResult[0]->japanese[0]->reading)) ? "" : $jishoResult[0]->japanese[0]->reading;
                $tags       = (isset($jishoResult[0]->senses[0]->tags[0])) ? $jishoResult[0]->senses[0]->tags[0] : "";
                $descString = "";

                echo $jpWord . "\n";
                echo $jpReading . "\n";
                echo "JLPT " . $jlptLevel . "\n";
                echo $tags . "\n";
                echo $descString . "\n";

                if (isset($jishoResult[0]->senses[0]->english_definitions)) {
                    foreach($jishoResult[0]->senses[0]->english_definitions as $desc) {
                        $descString .= $desc . ";";
                    }
                }
    
                $descString = substr($descString, 0, -1);
            } catch(Expression $e) {
                
            }

            if ($this->emptyTable) {
                DB::table('vocab')->insert([
                    'word'              => ($jpWord != "") ? $jpWord : $word["Kanji"],
                    'furigana'          => ($jpReading != "") ? $jpReading : $word["Kana"],
                    'type'              => $cat,
                    'jlpt'              => $jlptLevel,
                    'description'       => $descString,
                    'tags'              => $tags,
                    'image'             => "",
                    'ispeech_id'        => -1,
                    'kanji'             => "",
                    'created_at'        => now()
                ]);
            }
        }
    }
}
