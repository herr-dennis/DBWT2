<?php

namespace App\Http\Controllers;

use App\Models\Ab_TestData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DatenbankController
{
    public function getTestData()
    {
        try {
            $data = Ab_TestData::query()->select("*")->get();
        } catch (\Exception $exception) {
            Log::error("Fehler beim Abrufen der Testdaten: " . $exception->getMessage());
            Session::flash("error", "Fehler beim Abrufen der Daten.");

            return view("testDataView", ['data' => collect()]);
        }

        return view("testDataView", ['data' => $data]);
    }}
