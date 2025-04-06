<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\AbUser;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $path = base_path('database/seeders/data/user.csv');
        $this->importUsersFromCSV($path);

        $path = base_path('database/seeders/data/articles.csv');
        $this->importArticlesFromCSV($path);

        $path = base_path('database/seeders/data/articlecategory.csv');
        $this->importArticleCategoriesFromCSV($path);


    }

    private function importUsersFromCSV($csvFilePath)
    {
        if (!file_exists($csvFilePath)) {
            $this->command->info("Файл $csvFilePath не найден!");
            return;
        }

        $handle = fopen($csvFilePath, 'r');
        fgetcsv($handle, 0, ';');

        while (($data = fgetcsv($handle, 0, ';')) !== false) {
            AbUser::create([
                'ab_name'     => $data[0],
                'ab_mail'    => $data[1],
                'ab_password' => bcrypt($data[2]),
            ]);
        }
        fclose($handle);
    }

    private function importArticlesFromCSV($csvFilePath)
    {
        if (!file_exists($csvFilePath)) {
            $this->command->error("Файл $csvFilePath не найден.");
            return;
        }

        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            fgetcsv($handle, 0, ';');

            while (($data = fgetcsv($handle, 0, ';')) !== false) {
                $price = str_replace('.', '', $data[2]);

                try {
                    $createdate = Carbon::createFromFormat('d.m.y H:i', $data[5])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $createdate = null;
                }

                // Вставляем данные в таблицу "articles"
                DB::table('articles')->insert([
                    'id'             => $data[0],
                    'ab_name'        => $data[1],
                    'ab_price'       => $price,
                    'ab_description' => $data[3],
                    'ab_creator_id'  => $data[4],
                    'ab_createdate'  => $createdate,
                ]);
            }
            fclose($handle);
        }
    }
    private function importArticleCategoriesFromCSV($csvFilePath)
    {
        if (!file_exists($csvFilePath)) {
            $this->command->error("Файл $csvFilePath не найден.");
            return;
        }

        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            fgetcsv($handle, 0, ';');

            while (($data = fgetcsv($handle, 0, ';')) !== false) {
                $parent = ($data[2] === '' || strtolower($data[2]) === 'null') ? null : $data[2];

                DB::table('articlecategories')->insert([
                    'id'       => $data[0],
                    'ab_name'  => $data[1],
                    'ab_parent'=> $parent,
                ]);
            }
            fclose($handle);
        }
    }
}
