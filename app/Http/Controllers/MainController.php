<?php

namespace App\Http\Controllers;
use App\Models\Ab_articlecategory;
use App\Models\ab_articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{

    public function getArticles(Request $request){

        //Post von /newarticles
        if (!empty($request->post())) {

            $name = $request->post("name") ?: null;
            $price = $request->post("price") ?:null;
            $beschreibung = $request->post("beschreibung") ?:null;

            //Holt die nächste ID aus der Datenbank
            $id = DB::select("SELECT nextval('ab_article_id_seq') as id")[0]->id;
            $id++;
            if($name != null && $price != null){
                try{
                    ab_articles::query()->insert([
                        "id" =>$id,
                        "ab_name" => $name,
                        "ab_price" => $price,
                        "ab_description" => $beschreibung,
                        "ab_creator_id" => 1, // den musst du natürlich setzen
                        "ab_createdate" => now(),
                        "created_at" => now(),
                        "updated_at" => now()
                    ]);

                    Session::flash("msg", "Der Artikel wurde erfolgreich erstellt");


                }
                catch (\Exception $exception){
                    //Logger::class->log(3,$exception->getMessage());
                    Session::flash("error", "Neuer Artikel nicht eingefügt. Schaue in Logs".$exception->getMessage());
                }


            }else{
                Session::flash("error", "Name oder Preis fehlt");
            }

        }


        //Wenn ein Artikel gesucht wird
        if($request->has('search')){

            $search = $request->input('search'); // Eingabe aus dem Suchfeld
            $query = ab_articles::query();

            if (!empty($search)) {
                //Der ab_name und der gesuchte Artikel beide einfach lowercase
                $query->whereRaw('LOWER(ab_name) LIKE LOWER(?)', ["%{$search}%"]);
            }
            try{
                $articles = $query->get();
                if(!$articles->isEmpty()){
                    return view('articlesView' ,['data'=>$articles]);
                }else{
                    Session::flash("msg", "Kein Artikel gefunden!");
                }

            }
            catch (\Exception $exception){
                Session::flash("error", "Gesuchter Artikel nicht gefunden");
            }
        }

        try{
            $data =  ab_articles::query()->select("*")->get();
        }
        catch (\Exception $exception){
            Session::flash("error", $exception->getMessage());
            $data = collect();
        }
        return view('articlesView' ,['data'=>$data]);

    }

    /**
     * Für die Javascript anfrage über GET
     * Gibt ein J-Son Object zurück
     */
    public function getCategories()
    {
        try {
            $data = Ab_articlecategory::query()->select("ab_name")->get();
            return response()->json($data);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function getNewArticle(){
        return view("newArticleView");
    }


}
