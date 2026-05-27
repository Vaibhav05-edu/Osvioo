@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{translate('Invoices & Watermark Requests')}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{translate('Date')}}</th>
                                <th>{{translate('User')}}</th>
                                <th>{{translate('Brand Name')}}</th>
                                <th>{{translate('Amount')}}</th>
                                <th>{{translate('Watermark Status')}}</th>
                                <th>{{translate('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                            <tr>
                                <td>{{$invoice->created_at->format('M d, Y')}}</td>
                                <td>{{$invoice->user->name ?? 'Unknown'}} ({{$invoice->user->email ?? 'Unknown'}})</td>
                                <td>{{$invoice->brand_name ?? 'Platform'}}</td>
                                <td>{{num_format($invoice->amount)}}</td>
                                <td>
                                    @if($invoice->watermark_removed)
                                        <span class="badge bg-success">{{translate('Removed')}}</span>
                                    @elseif($invoice->watermark_request_status == 'pending')
                                        <span class="badge bg-warning text-dark">{{translate('Pending Request')}}</span>
                                    @elseif($invoice->watermark_request_status == 'rejected')
                                        <span class="badge bg-danger">{{translate('Rejected')}}</span>
                                    @else
                                        <span class="badge bg-secondary">{{translate('N/A')}}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('user.invoice.share', $invoice->uid)}}" class="btn btn-sm btn-info text-white" target="_blank"><i class="bi bi-eye"></i> View</a>
                                    
                                    @if($invoice->watermark_request_status == 'pending')
                                        <form action="{{route('admin.invoice.watermark.approve', $invoice->uid)}}" method="POST" class="d-inline-block">
                                            @csrf
                                            <button class="btn btn-sm btn-success" type="submit">{{translate('Approve')}}</button>
                                        </form>
                                        <form action="{{route('admin.invoice.watermark.reject', $invoice->uid)}}" method="POST" class="d-inline-block">
                                            @csrf
                                            <button class="btn btn-sm btn-danger" type="submit">{{translate('Reject')}}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">{{translate('No invoices found')}}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{$invoices->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
