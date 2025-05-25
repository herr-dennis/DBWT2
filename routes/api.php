<?php
use App\Models\ab_articles;
use App\Models\Ab_User;
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
        try {
            $article = ab_articles::create([
                "ab_name" => $name,
                "ab_price" => $price,
                "ab_description" => $description,
                "ab_creator_id" => 1,
                "ab_createdate" => now(),
            ]);

            return response()->json([
                "message" => "Artikel erfolgreich gespeichert!",
                "id" => $article->id
            ], 200);
        } catch (\Exception $exception) {
            return response()->json(["error" => $exception->getMessage()], 400);
        }
    } else {
        return response()->json(["error" => "Fehler beim Einpflegen in die Datenbank!"], 500);
    }
});

Route::delete('/shoppingcart/{shoppingcartid}/articles/{articleId}', function ($shoppingcartid, $articleId) {
    try {
        $deleted = DB::table('ab_shoppingcart_item')
            ->where('ab_shoppingcart_id', $shoppingcartid)
            ->where('ab_article_id', $articleId)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Artikel nicht im Warenkorb gefunden'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::post('/shoppingcart', function(Request $request) {
    $userName    = $request->input('ab_name');
    $articleName = $request->input('article_name');

    if (! $userName) {
        return response()->json(['error' => 'user_name nicht gefunden'], 400);
    }
    if (! $articleName) {
        return response()->json(['error' => 'article_name nicht gefunden'], 400);
    }

    try {
        $userId = DB::table('ab_user')
            ->where('ab_name', $userName)
            ->value('id');
        if (! $userId) {
            return response()->json(['error' => 'User nicht gefunden'], 404);
        }

        $articleId = DB::table('ab_article')
            ->where('ab_name', $articleName)
            ->value('id');
        if (! $articleId) {
            return response()->json(['error' => 'Artikel nicht gefunden'], 404);
        }

        $cartId = DB::table('ab_shoppingcart')
            ->where('ab_creator_id', $userId)
            ->value('id');
        if (! $cartId) {
            $cartId = DB::table('ab_shoppingcart')->insertGetId([
                'ab_creator_id' => $userId,
                'ab_createdate' => now(),
            ]);
        }

        DB::table('ab_shoppingcart_item')->insert([
            'ab_shoppingcart_id' => $cartId,
            'ab_article_id'      => $articleId,
            'ab_createdate'      => now(),
        ]);

        return response()->json([
            'success'     => true,
            'cart_id'     => $cartId,
            'article_id'  => $articleId,
        ], 200);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::get('/shoppingcart', function(Request $request) {
    $user_name = $request->input('ab_name');
    $user_id   = DB::table('ab_user')->where('ab_name', $user_name)->value('id');

    $articles = DB::table('ab_user as u')
        ->join('ab_shoppingcart as sc', 'sc.ab_creator_id',   '=', 'u.id')
        ->join('ab_shoppingcart_item as sci', 'sci.ab_shoppingcart_id', '=', 'sc.id')
        ->join('ab_article as a', 'a.id',                     '=', 'sci.ab_article_id')
        ->where('u.id', $user_id)
        ->select('a.*', 'sci.ab_createdate as hinzugefuegt_am')
        ->get();

    return response()->json($articles);
});
