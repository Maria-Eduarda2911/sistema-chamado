<!-- resources/views/tickets/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalhes do Chamado</h1>
        <p><strong>ID:</strong> {{ $ticket->id }}</p>
        <p><strong>Título:</strong> {{ $ticket->title }}</p>
        <p><strong>Descrição:</strong> {{ $ticket->description }}</p>
        <!-- Adicione mais campos conforme necessário -->
    </div>
@endsection
