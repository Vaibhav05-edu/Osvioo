@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title">{{translate('My Invoices')}}</h4>
        <a href="{{route('user.invoice.create')}}" class="i-btn btn--primary btn--md capsuled">{{translate('Create Invoice')}}</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>{{translate('Date')}}</th>
                        <th>{{translate('Brand Name')}}</th>
                        <th>{{translate('Amount')}}</th>
                        <th>{{translate('Status')}}</th>
                        <th>{{translate('Watermark')}}</th>
                        <th>{{translate('Actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    <tr>
                        <td>{{$invoice->created_at->format('M d, Y')}}</td>
                        <td>{{$invoice->brand_name ?? 'Platform'}}</td>
                        <td>{{num_format($invoice->amount)}}</td>
                        <td>
                            @if($invoice->status == 'paid')
                                <span class="badge bg-success">{{translate('Paid')}}</span>
                            @else
                                <span class="badge bg-warning">{{translate('Unpaid')}}</span>
                            @endif
                        </td>
                        <td>
                            @if($invoice->watermark_removed)
                                <span class="badge bg-success">{{translate('Removed')}}</span>
                            @elseif($invoice->watermark_request_status == 'pending')
                                <span class="badge bg-warning">{{translate('Requested')}}</span>
                            @else
                                <form action="{{route('user.invoice.watermark.request', $invoice->uid)}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-primary">{{translate('Request Removal')}}</button>
                                </form>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('user.invoice.share', $invoice->uid)}}" class="btn btn-sm btn-info text-white" target="_blank"><i class="bi bi-eye"></i></a>
                            <a href="{{route('user.invoice.download', $invoice->uid)}}" class="btn btn-sm btn-success text-white"><i class="bi bi-download"></i></a>
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
@endsection
