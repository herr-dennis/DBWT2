<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Article::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('ab_name', 'like', "%{$search}%")
                    ->orWhere('ab_description', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('id', 'desc')->get();

        foreach ($articles as $article) {
            $pngPath = public_path('articleimages/' . $article->id . '.png');
            $jpgPath = public_path('articleimages/' . $article->id . '.jpg');

            if (file_exists($pngPath)) {
                $article->computed_image_path = 'articleimages/' . $article->id . '.png';
            } elseif (file_exists($jpgPath)) {
                $article->computed_image_path = 'articleimages/' . $article->id . '.jpg';
            } else {
                $article->computed_image_path = null;
            }
        }

        return view('articles.index', compact('articles', 'search'));
    }


}
