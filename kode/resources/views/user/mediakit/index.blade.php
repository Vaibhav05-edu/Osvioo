@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="i-card-md">
            <div class="card-header">
                <h4 class="card-title">
                    {{translate('Previous Media Kits')}}
                </h4>
                <a href="{{route('user.mediakit.create')}}" class="i-btn btn--md success">
                    <i class="bi bi-plus"></i> {{translate('Create New')}}
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th>{{translate('Title')}}</th>
                                <th>{{translate('Cover')}}</th>
                                <th>{{translate('Stats')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Watermark')}}</th>
                                <th>{{translate('Views')}}</th>
                                <th>{{translate('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mediaKits as $kit)
                            <tr>
                                <td>{{$kit->title}}</td>
                                <td>
                                    @if($kit->cover_image)
                                    <img src="{{ asset('assets/images/frontend/profile/' . $kit->cover_image) }}" alt="Cover" style="height: 40px; border-radius: 5px;">
                                    @else
                                    <span class="badge bg-secondary">{{translate('No Cover')}}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{number_format($kit->total_followers)}} {{translate('Followers')}}</span>
                                </td>
                                <td>
                                    @if($kit->is_public)
                                    <span class="badge bg-success">{{translate('Public')}}</span>
                                    @else
                                    <span class="badge bg-danger">{{translate('Private')}}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($kit->watermark_removed)
                                        <span class="badge bg-success">{{ translate('Removed') }}</span>
                                    @elseif($kit->watermark_request_status == 'pending')
                                        <span class="badge bg-warning">{{ translate('Pending Request') }}</span>
                                    @else
                                        <form action="{{ route('user.mediakit.watermark.request', $kit->uid) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="i-btn btn--sm warning" data-bs-toggle="tooltip" title="{{ translate('Request Watermark Removal') }}">
                                                <i class="bi bi-droplet-half"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{$kit->views}}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{route('mediakit.public', ['username' => auth_user('web')->username ?? auth_user('web')->user_name, 'uid' => $kit->uid])}}" target="_blank" class="i-btn btn--sm info" data-bs-toggle="tooltip" title="{{translate('View Public Kit')}}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{route('user.mediakit.edit', $kit->id)}}" class="i-btn btn--sm primary" data-bs-toggle="tooltip" title="{{translate('Edit')}}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{route('user.mediakit.delete', $kit->id)}}" method="POST" onsubmit="return confirm('{{translate('Are you sure?')}}');">
                                            @csrf
                                            <button type="submit" class="i-btn btn--sm danger" data-bs-toggle="tooltip" title="{{translate('Delete')}}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="p-4">
                                        <i class="bi bi-person-badge text-muted" style="font-size: 3rem;"></i>
                                        <h5 class="mt-3">{{translate('No Media Kits Found')}}</h5>
                                        <p class="text-muted">{{translate('Create your first AI-powered media kit to showcase to brands.')}}</p>
                                        <a href="{{route('user.mediakit.create')}}" class="i-btn btn--md primary mt-2">{{translate('Create Now')}}</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{$mediaKits->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
