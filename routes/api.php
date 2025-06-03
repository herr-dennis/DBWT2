<?php
use App\Models\ab_articles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/articles', function (Request $request) {
    $search = $request->input('search');
    $data = ab_articles::query();
    $limit = null;

    if($search) {
        if(is_numeric($search)){
            $limit = $search;
        }
    }

    if ($search && $limit===null) {
        $search = strtolower($search);

        $data->select("*")
            //whereRaw nativ SQL
            ->whereRaw('LOWER(ab_name) LIKE ?', ['%' . $search . '%']);
    }
    elseif ($limit){
        $data->inRandomOrder($limit)->limit($limit);
    }
    else {
        $data->select("*");
    }

    $articles = $data->get();

    return response()->json($articles);
});


Route::post('/articles', function (Request $request) {

    $name = $request->post("name") ?: null;
    $price = $request->post("preis") ?: null;
    $description = $request->post("beschreibung") ?: null;

    if (!empty($name) && !empty($price) && !empty($description) && $price > 0) {

        $id = DB::select("SELECT nextval('ab_article_id_seq') as id")[0]->id;
        $id++;

        try {
            ab_articles::query()->insert([
                "id" => $id,
                "ab_name" => $name,
                "ab_price" => $price,
                "ab_description" => $description,
                "ab_creator_id" => 1,
                "ab_createdate" => now(),
                "created_at" => now(),
                "updated_at" => now()
            ]);

            return response()->json(["id" => $id],200);
        } catch (\Exception $exception) {
            return response()->json(["error" => $exception->getMessage()],400);
        }
    } else {
        return response()->json(["error" => "Fehler beim Einpflegen in die Datenbank!"], 500);
    }
});

Route::delete('/shoppingcart/{shoppingcartid}/articles/{articleId}', function ($shoppingcartid, $articleId) {
    try {
        $deleted = DB::table('ab_shoppingcart_item')
            ->where('ab_article_id', $articleId)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => $deleted], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::post("/shoppingcart", function(Request $request) {

    //return response()->json($request->all());

    $user_name = $request->post("ab_name");
    $article_name = $request->post("article_name"); //

    if(!$article_name){
        return response()->json(['error' => '$article_name nicht gefunden'], 404);
    }
    if(!$user_name){
        return response()->json(['error' => '$user_name nicht gefunden'], 404);
    }
    try {
        // Hole die ID des Users
        $user_id = DB::table("ab_user")
            ->where('ab_name', $user_name)
            ->value("id");

        if (!$user_id) {
            return response()->json(['error' => 'User nicht gefunden'], 404);
        }

        // Hole die ID des Artikels
        $article_id = DB::table("ab_article")
            ->where("ab_name", $article_name)
            ->value("id");

        if (!$article_id) {
            return response()->json(['error' => 'Artikel nicht gefunden'], 404);
        }

        // Hole den Warenkorb des Users, falls vorhanden
        $warenkorb_id = DB::table("ab_shoppingcart")
            ->where("ab_creator_id", $user_id)
            ->value("id");

        // Wenn kein Warenkorb existiert, erstelle einen
        if (!$warenkorb_id) {
            $warenkorb_id = DB::table("ab_shoppingcart")->insertGetId([
                "ab_creator_id" => $user_id,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        // Füge den Artikel in den Warenkorb ein
        DB::table("ab_shoppingcart_item")->insert([
            "ab_shoppingcart_id" => $warenkorb_id,
            "ab_article_id" => $article_id,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        return response()->json(['success' => true]);

    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});


Route::get("shoppingcart", function(Request $request) {

    $user_name = $request->input("ab_name");
    $user_id = DB::table("ab_user")->where("ab_name", $user_name)->value("id");

$articles = DB::table('ab_user as u')
    ->join('ab_shoppingcart as sc', 'sc.ab_creator_id', '=', 'u.id')
    ->join('ab_shoppingcart_item as sci', 'sci.ab_shoppingcart_id', '=', 'sc.id')
    ->join('ab_article as a', 'a.id', '=', 'sci.ab_article_id')
    ->where('u.id', $user_id)
    ->select('a.*', 'sci.created_at as hinzugefügt_am' , 'sc.id', 'sci.ab_article_id' )
    ->get();

   return response()->json($articles);

});
