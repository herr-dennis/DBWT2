<?php

namespace App\Http\Controllers;

use App\Models\Ab_articlecategory;
use App\Models\ab_articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function Laravel\Prompts\text;

class MainController extends Controller
{

    public function getArticles(Request $request){

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
     *
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


}
