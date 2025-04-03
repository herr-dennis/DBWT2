<?php

namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class DevelopmentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedUsers();
        $this->seedArticles();
        $this->seedArticleCategories();
    }

    /**
     * @return void
     *  !!!  League\Csv\Reader über composer installieren!!!
     */
    private function seedArticleCategories()
    {
        $csv = Reader::createFromPath(database_path('seeders/data/articlecategory.csv'), 'r');
        $csv->setDelimiter(';');  // Setzen des Trennzeichens auf ;
        //Liest die erste Zeile für der as. Array ein
        $csv->setHeaderOffset(0);

        foreach ($csv as $item) {
            DB::table('ab_articlecategory')->insert([
                'id' => $item['id'],
                'ab_name' => $item['ab_name'],
                'ab_parent' => $item['ab_parent'] === 'NULL' ? null : $item['ab_parent'],
            ]);
        }
    }

    private function seedArticles()
    {
        $csv = Reader::createFromPath(database_path('seeders/data/articles.csv'), 'r');
        $csv->setDelimiter(';');  // Setzen des Trennzeichens auf ;
        $csv->setHeaderOffset(0);    //Liest die erste Zeile für der as. Array ein

        foreach ($csv as $item) {
           // $item['ab_createdate'] = Carbon::createFromFormat('d/m/y H:i', $item['ab_createdate'])->format('Y-m-d H:i:s');
            DB::table('ab_article')->insert([
                'id' => $item['id'],
                'ab_name' => $item['ab_name'],
                'ab_price' => floatval(['ab_price']),
                'ab_description' => floatval($item['ab_description']), // Konvertierung zu Float
                'ab_creator_id' => $item['ab_creator_id'],
                'ab_createdate' => $item['ab_createdate'],
            ]);
        }
    }

    private function seedUsers()
    {
        $csv = Reader::createFromPath(database_path('seeders/data/user.csv'), 'r');
        $csv->setDelimiter(';');  // Trennzeichens auf ;
        $csv->setHeaderOffset(0);    //Liest die erste Zeile für der as. Array ein

        foreach ($csv as $item) {
            DB::table('ab_user')->insert([
                'id' => $item['id'],
                'ab_name' => $item['ab_name'],
                'ab_mail' => $item['ab_mail'],
                'ab_password' => bcrypt($item['ab_password']), // Passwort hashen Blowfish-Algorithmus
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
