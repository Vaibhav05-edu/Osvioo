@extends('admin.layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{translate('Media Kits & Watermarks')}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>{{translate('User')}}</th>
                                <th>{{translate('Title')}}</th>
                                <th>{{translate('Views')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Watermark')}}</th>
                                <th>{{translate('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mediaKits as $kit)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{@$kit->user->name}}</span><br>
                                    <small class="text-muted">{{@$kit->user->email}}</small>
                                </td>
                                <td>{{$kit->title}}</td>
                                <td>{{$kit->views}}</td>
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
                                    @elseif($kit->watermark_request_status == 'rejected')
                                        <span class="badge bg-danger">{{ translate('Rejected') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ translate('Intact') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{route('mediakit.public', ['username' => @$kit->user->username ?? @$kit->user->user_name ?? 'user', 'uid' => $kit->uid])}}" target="_blank" class="btn btn-sm btn-info" title="{{translate('View')}}">
                                            <i class="las la-eye"></i>
                                        </a>

                                        @if($kit->watermark_request_status == 'pending')
                                            <form action="{{route('admin.mediakit.watermark.approve', $kit->uid)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button class="btn btn-sm btn-success" type="submit" title="Approve Watermark Removal">
                                                    <i class="las la-check"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{route('admin.mediakit.watermark.reject', $kit->uid)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit" title="Reject Watermark Removal">
                                                    <i class="las la-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">{{translate('No media kits found')}}</td>
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
