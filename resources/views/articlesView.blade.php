@extends("layouts.defaultLayout")

@section("title","Artikel")
@section("main-content")

    <h2>Artikelübersicht</h2>

@if(\Illuminate\Support\Facades\Session::has("error"))
    <p>{{\Illuminate\Support\Facades\Session::get("error")}}</p>
@endif
    @if(\Illuminate\Support\Facades\Session::has("msg"))
        <p style="color: red">{{\Illuminate\Support\Facades\Session::get("msg")}}</p>
    @endif


 <div  id="app">

 </div>


    {{-- <table class="table" border="1">
        <thead>
        <tr>
            <th>+</th>
            <th>Name</th>
            <th>Preis</th>
            <th>Beschreibung</th>
            <th>Ersteller-ID</th>
            <th>Erstelldatum</th>
            <th>Bild</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr id="row-{{$item['ab_name']}}">
                <td>
                    <div class="choice">
                        <input name="id" type="hidden" value="{{$item["ab_name"]}}">
                        <label>+</label>
                    </div>
                </td>
                <td>{{ $item['ab_name'] }}</td>
                <td>{{ $item['ab_price'] }} €</td>
                <td>{{ $item['ab_description'] }}</td>
                <td>{{ $item['ab_creator_id'] }}</td>
                <td>{{ \Carbon\Carbon::parse($item['ab_createdate'])->format('d.m.Y H:i') }}</td>
                @php
                    $format = ['png', 'jpg'];
                    foreach ($format as $ext) {
                        //Wenn File exists, dann $imageUrl -> richtiges Format
                        if (file_exists(public_path("images/{$item['id']}.$ext"))) {
                            $imageUrl = asset("images/{$item['id']}.$ext");
                            break;
                        }
                    }
                @endphp
                <td><img style="width: 100px; height: auto;" src="{{$imageUrl??asset("images/see-no-evil-3444212_640.jpg") }}" alt="Kein Bild vorhanden"></td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <form method="get" action="">
        <label for="searchInput">Artikel suchen:</label>
        <input id="searchInput" type="text" name="search" value="{{ request('search') }}">
        <input type="submit" value="Suchen">
    </form>--}}


@endsection
