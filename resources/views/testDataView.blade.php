@extends("layouts.defaultLayout")


@section("main-content")
    <p>Die Daten!</p>
    <ul>
        @foreach($data as $value =>$item)
            <li>{{$item}}</li>
        @endforeach

        @if(\Illuminate\Support\Facades\Session::has("error"))
            <p style="color: red">{{\Illuminate\Support\Facades\Session::get("error")}}</p>
        @endif

    </ul>
@endsection


