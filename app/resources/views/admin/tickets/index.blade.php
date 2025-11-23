@extends('layouts.admin')

@section('content')
    <h1>Список заявок</h1>

    <form method="GET" class="row g-2 mb-3">
        <div class="col">
            <input type="text" name="email" placeholder="Email" value="{{ request('email') }}" class="form-control">
        </div>
        <div class="col">
            <input type="text" name="phone" placeholder="Телефон" value="{{ request('phone') }}" class="form-control">
        </div>
        <div class="col">
            <select name="status" class="form-select">
                <option value="">Все статусы</option>
                <option value="new" @selected(request('status')=='new')>New</option>
                <option value="in_progress" @selected(request('status')=='in_progress')>In Progress</option>
                <option value="processed" @selected(request('status')=='processed')>Processed</option>
            </select>
        </div>
        <div class="col">
            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
        </div>
        <div class="col">
            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary">Фильтровать</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Клиент</th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Тема</th>
            <th>Статус</th>
            <th>Создан</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->customer->name }}</td>
                <td>{{ $ticket->customer->email }}</td>
                <td>{{ $ticket->customer->phone }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>{{ $ticket->status }}</td>
                <td>{{ $ticket->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-info">Просмотр</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $tickets->links() }}
@endsection
