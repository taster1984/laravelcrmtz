@extends('layouts.admin')

@section('content')
    <h1>Заявка #{{ $ticket->id }}</h1>

    <p><strong>Клиент:</strong> {{ $ticket->customer->name }}</p>
    <p><strong>Email:</strong> {{ $ticket->customer->email }}</p>
    <p><strong>Телефон:</strong> {{ $ticket->customer->phone }}</p>
    <p><strong>Тема:</strong> {{ $ticket->subject }}</p>
    <p><strong>Текст:</strong> {{ $ticket->body }}</p>
    @if($ticket->status == 'processed')
        <p><strong>Дата ответа:</strong> {{ $ticket->response_date }}</p>
    @endif
    <h4>Файлы</h4>
    <ul>
        @foreach($ticket->files as $file)
            @foreach($file->getMedia('files') as $media)
                <li><a href="{{ $media->getUrl() }}" target="_blank">{{ $file->title }}</a></li>
            @endforeach
        @endforeach
    </ul>

    <form method="POST" action="{{ route('admin.tickets.updateStatus', $ticket) }}">
        @csrf
        <label for="status">Статус</label>
        <select name="status" id="status" class="form-select mb-2">
            <option value="new" @selected($ticket->status=='new')>New</option>
            <option value="in_progress" @selected($ticket->status=='in_progress')>In Progress</option>
            <option value="processed" @selected($ticket->status=='processed')>Processed</option>
        </select>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
@endsection
