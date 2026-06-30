@extends('layouts.dashboard')

@section('title', 'Legacy Admin Feature Map')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Legacy Admin Feature Map</h1>
    </div>

    <div class="alert alert-info">
        Legacy project এর admin panel থেকে feature mapping এখানে grouped করে দেখানো হয়েছে।
        Pharmacy Categories মডিউল live করা হয়েছে এবং বাকি মডিউলগুলো একই প্যাটার্নে পর্যায়ক্রমে migrate করা যাবে।
    </div>

    <div class="row g-3">
        @foreach ($featureGroups as $group)
            <div class="col-12 col-lg-6">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <strong>{{ $group['title'] }}</strong>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            @foreach ($group['features'] as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card mt-4">
        <div class="card-body d-flex flex-wrap gap-2 align-items-center">
            <span class="fw-semibold">Live module:</span>
            <a href="{{ route('admin.pharmacy-categories.index') }}" class="btn btn-sm btn-primary-custom">
                <i class="bi bi-capsule"></i> Pharmacy Categories
            </a>
        </div>
    </div>
@endsection
