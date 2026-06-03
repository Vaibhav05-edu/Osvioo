@extends('layouts.master')
@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="icon-box bg--danger-soft text--danger" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-x-circle fs-24"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">{{translate('Failed Transactions')}}</h4>
                    <p class="mb-0 text-muted">{{translate('Review your unsuccessful payment attempts.')}}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle custom-table">
                    <thead>
                        <tr>
                            <th>{{translate('Transaction ID')}}</th>
                            <th>{{translate('Method')}}</th>
                            <th>{{translate('Amount')}}</th>
                            <th>{{translate('Date')}}</th>
                            <th>{{translate('Status')}}</th>
                            <th>{{translate('Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td><span class="fw-bold">{{$report->trx_code}}</span></td>
                            <td>{{@$report->method->name ?? 'N/A'}}</td>
                            <td><span class="fw-bold text-danger">{{short_amount($report->amount)}}</span> {{session()->get('currency')?->code}}</td>
                            <td>{{get_date_time($report->created_at)}}</td>
                            <td><span class="badge bg-danger-soft text-danger capsuled">{{translate('Failed')}}</span></td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-outline-primary capsuled" onclick="alert('{{translate('Please try a different payment method or contact support.')}}')">{{translate('Retry')}}</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-inbox fs-1 text-muted mb-2"></i>
                                    <p class="mb-0 text-muted">{{translate('No failed transactions found.')}}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-end">
                {{$reports->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
