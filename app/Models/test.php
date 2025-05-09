<?php

use App\Models\ab_articles;
$article_name = "Iphone X";
$article_id = ab_articles::query()->where("ab_name", $article_name)->value("id");
