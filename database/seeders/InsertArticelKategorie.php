<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class InsertArticelKategorie extends Seeder
{


    public function run(){
     $this->seedArtikelCategories();
    }


    public function seedArtikelCategories()
    {
        $csv = Reader::createFromPath(database_path("seeders/data/article_has_articlecategory.csv", 'r'));
        $csv->setDelimiter(';');  // Setzen des Trennzeichens auf ;
        //Liest die erste Zeile für der as. Array ein
        $csv->setHeaderOffset(0);


        try{
            foreach ($csv as $record) {

                DB::table('ab_article_has_articlecategory')->insert([

                    "ab_article_id"   => $record["ab_article_id"],
                    "ab_articlecategory_id" => $record["ab_articlecategory_id"],
                    "created_at"     => now(),
                    "updated_at"     => now()
                ]);

            }
        }
        catch (\Exception $e){
            echo $e->getMessage();
        }


    }


}
