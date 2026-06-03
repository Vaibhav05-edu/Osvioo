@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="i-card-md">
            <div class="card-header">
                <h4 class="card-title">
                    {{translate('Media Kit Insights')}}
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="p-4 border rounded shadow-sm text-center">
                            <i class="bi bi-eye text-primary mb-2" style="font-size: 2rem;"></i>
                            <h2 class="mb-1" style="font-weight: 800; font-family: 'Outfit', sans-serif;">{{ number_format($totalViews) }}</h2>
                            <p class="text-muted mb-0">{{translate('Total Profile Views')}}</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="p-4 border rounded shadow-sm text-center">
                            <i class="bi bi-file-earmark-person text-success mb-2" style="font-size: 2rem;"></i>
                            <h2 class="mb-1" style="font-weight: 800; font-family: 'Outfit', sans-serif;">{{ $mediaKits->count() }}</h2>
                            <p class="text-muted mb-0">{{translate('Active Media Kits')}}</p>
                        </div>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">{{translate('Performance by Kit')}}</h5>
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th>{{translate('Title')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Views')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mediaKits as $kit)
                            <tr>
                                <td>{{$kit->title}}</td>
                                <td>
                                    @if($kit->is_public)
                                    <span class="badge bg-success">{{translate('Public')}}</span>
                                    @else
                                    <span class="badge bg-danger">{{translate('Private')}}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                            @php
                                                $percentage = $totalViews > 0 ? ($kit->views / $totalViews) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{$percentage}}%;" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span>{{$kit->views}}</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">{{translate('No data available.')}}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
