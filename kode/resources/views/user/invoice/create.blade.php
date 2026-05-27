@extends('user.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{translate('Create Invoice')}}</h4>
    </div>
    <div class="card-body">
        <form action="{{route('user.invoice.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{translate('Brand Name')}}</label>
                    <input type="text" name="brand_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{translate('Amount')}}</label>
                    <input type="number" name="amount" class="form-control" step="0.01" required>
                </div>
                
                <!-- Dynamic Invoice Details -->
                <div class="col-12 mb-3">
                    <label class="form-label">{{translate('Invoice Items/Details')}}</label>
                    <div id="details-container">
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <input type="text" name="details[0][description]" class="form-control" placeholder="{{translate('Description')}}" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="details[0][price]" class="form-control" placeholder="{{translate('Price')}}" step="0.01" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="i-btn btn--primary btn--md mt-3 capsuled">{{translate('Save Invoice')}}</button>
        </form>
    </div>
</div>
@endsection
