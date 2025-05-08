<?php
use App\Models\ab_articles;
use App\Models\warenkorb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/articles', function (Request $request) {

    $search = $request->input('search');
    $data = ab_articles::query();

    //echo $search -> Hat so einen Json Fehler geführt!?

    if ($search) {
        $data->select("ab_name","id")->where('ab_name', 'like', '%' . $search . '%');
    }
    else{
        $data->select("ab_name","id");
    }

    $articles = $data->get();
    $jsonData = json_encode($articles);

    return response()->json($jsonData);

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

Route::delete('/articles/{id}', function ($id) {
    try {
        $deleted = ab_articles::destroy($id);

        if ($deleted) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Artikel nicht gefunden'], 400);
        }

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::post("/warenkorb/articles", function(Request $request){

    $user_id = $request->input("id");


    try {
        $warenkorb = warenkorb::query()->insert([

        ])
    }

});
