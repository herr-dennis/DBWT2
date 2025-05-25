<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
class UpdateJsonController extends Controller
{

    /*
     * Änder das Json Object in public/static
     */
    function updateJson(){

        // Neue Datenstruktur
        $data = [
            'message' => "Willkommen bei Abalo",
            'time' => now()->format('H:i:s')
        ];

        // Datei speichern
        File::put(public_path('static/message.json'), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    }

}
