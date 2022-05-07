@extends('site.layouts.main')

@section('title', 'Busca por: '. $term)

@section('content')
    @foreach($clients as $client)
        <p>Nome: {{ $client->name }} | Documento: {{ $client->document['value'] }}</p>
    @endforeach

@endsection

