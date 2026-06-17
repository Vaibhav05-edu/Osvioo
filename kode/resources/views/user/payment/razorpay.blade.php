@extends('layouts.master')
@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-xl-6 col-lg-8 col-md-10">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white p-4 text-center border-0">
                <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle mb-3 shadow" style="width: 80px; height: 80px;">
                    <img src='{{imageURL(@$log->method->file,"payment_method",true)}}' alt="Razorpay" style="width: 50px; height: 50px; object-fit: contain;">
                </div>
                <h3 class="mb-0 text-white fw-bold">Pay via Razorpay</h3>
                <p class="text-white-50 mb-0 mt-1">Complete your secure payment below</p>
            </div>
            
            <div class="card-body p-5 bg-white">
                <div class="bg-light p-4 rounded-3 mb-4 text-center border">
                    <p class="text-muted mb-1 text-uppercase fw-semibold" style="letter-spacing: 1px;">Amount to Pay</p>
                    <h2 class="text-dark fw-bold mb-0 display-5">{{num_format($log->final_amount, $log->method->currency)}}</h2>
                </div>

                <form action="{{$data->url}}" method="{{$data->method}}" id="razorpay-form">
                    @csrf
                    <input type="hidden" custom="{{$data->custom}}" name="hidden">
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $data->val['order_id'] }}">
                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                    
                    <button type="button" id="rzp-button1" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2" style="font-size: 1.1rem; border-radius: 12px;">
                        <i class="bi bi-shield-lock-fill fs-5"></i>
                        {{translate('Proceed to Payment')}}
                    </button>
                </form>
                
                <div class="text-center mt-4 text-muted small">
                    <i class="bi bi-lock-fill text-success"></i> Secured by Razorpay. 100% Safe & Secure.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-push')
<script nonce="{{ csp_nonce() }}" src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script nonce="{{ csp_nonce() }}">
    "use strict";
    $(document).ready(function () {
        var options = {
            "key": "{{ $data->val['key'] }}",
            "amount": Math.round({{ $data->val['amount'] }}),
            "currency": "{{ $data->val['currency'] }}",
            "name": "{{ $data->val['name'] ?? 'Osvioo' }}",
            "description": "{{ $data->val['description'] }}",
            "image": "{{ $data->val['image'] }}",
            "order_id": "{{ $data->val['order_id'] }}",
            "handler": function (response){
                $('#razorpay_payment_id').val(response.razorpay_payment_id);
                $('#razorpay_signature').val(response.razorpay_signature);
                $('#razorpay-form').submit();
            },
            "prefill": {
                "name": "{{ $data->val['prefill.name'] ?? '' }}",
                "email": "{{ $data->val['prefill.email'] ?? '' }}",
                "contact": "{{ $data->val['prefill.contact'] ?? '' }}"
            },
            "theme": {
                "color": "{{ $data->val['theme.color'] ?? '#3399cc' }}"
            }
        };
        
        var rzp1 = new Razorpay(options);
        
        rzp1.on('payment.failed', function (response){
            if (typeof toastr !== 'undefined') {
                toastr.error(response.error.description || 'Payment Failed');
            } else {
                alert(response.error.description || 'Payment Failed');
            }
        });

        $('#rzp-button1').on('click', function(e){
            rzp1.open();
            e.preventDefault();
        });

        // Automatically open the Razorpay popup on load to save a click
        setTimeout(function() {
            rzp1.open();
        }, 500);
    });
</script>

@endpush
