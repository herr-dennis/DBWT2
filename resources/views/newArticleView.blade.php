@extends("layouts.defaultLayout")
@section("head")
    {{-- Für die Verwaltung des csrf-Token
        Speichert das aktuelle Token in <meta> Tag
        Wird dann von Javasscript geholt
     --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section("main-content")

    <script src="{{ asset('js/artikeleingabe.js') }}"></script>
@endsection
