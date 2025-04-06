@extends('layouts.app')

@section('content')
    <h1>Artikelübersicht</h1>

    <form action="{{ route('articles.index') }}" method="GET">
        <input type="text" name="search" placeholder="Suche..." value="{{ $search }}">
        <button type="submit">Suchen</button>
    </form>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Preis</th>
            <th>Beschreibung</th>
            <th>Bild</th>
        </tr>
        </thead>
        <tbody>
        @forelse($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->ab_name }}</td>
                <td>{{ $article->ab_price }}</td>
                <td>{{ $article->ab_description }}</td>
                <td>
                    @if($article->computed_image_path)
                        <img src="{{ asset($article->computed_image_path) }}" alt="Image" width="150">
                    @else
                        <span>Kein Bild</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Keine Artikel gefunden.</td></tr>
        @endforelse
        </tbody>
    </table>
@endsection
