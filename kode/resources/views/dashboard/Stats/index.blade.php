@extends('dashboard.layout.main')
@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between mb-4">
        <h2 class="fw-bold">Feature Stats</h2>
        <a href="{{ route('osvioo-admin.stats.create') }}" class="btn btn-dark">Add New Stat</a>
    </div>
    <div class="card border-0 shadow-sm p-4">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats as $stat)
                <tr>
                    <td>#{{ $stat->order }}</td>
                    <td><img src="{{ asset('storage/'.$stat->image) }}" width="50" class="rounded"></td>
                    <td>{{ $stat->title }}</td>
                    <td><span class="badge {{ $stat->status ? 'bg-success' : 'bg-danger' }}">{{ $stat->status ? 'Active' : 'Inactive' }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('osvioo-admin.stats.edit', $stat->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('osvioo-admin.stats.destroy', $stat->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $stats->links() }}
    </div>
</div>
@endsection