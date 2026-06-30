@extends('layouts.dashboard')

@section('title', 'Pharmacy Categories')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pharmacy Categories</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.pharmacy-categories.create') }}" class="btn btn-primary-custom">
                <i class="bi bi-plus-circle"></i> Add Category
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($categories->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-capsule text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">No pharmacy categories found</h4>
                    <p class="text-muted">Create your first category to organize pharmaceutical inventory.</p>
                    <a href="{{ route('admin.pharmacy-categories.create') }}" class="btn btn-primary-custom">
                        <i class="bi bi-plus-circle"></i> Create First Category
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="fw-semibold">{{ $category->name }}</td>
                                    <td>{{ $category->description ?: '-' }}</td>
                                    <td>
                                        @if ($category->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.pharmacy-categories.edit', $category) }}"
                                                class="btn btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('admin.pharmacy-categories.toggle-status', $category) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="btn btn-outline-{{ $category->is_active ? 'warning' : 'success' }}">
                                                    <i class="bi bi-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.pharmacy-categories.destroy', $category) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this category?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
