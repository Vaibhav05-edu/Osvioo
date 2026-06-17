@extends('layouts.master')
@section('content')
    @php
        $balance         = auth_user("web")->affiliate_balance;
        $currency        = session('currency')?? base_currency();
        $currencySymbol  = $currency->symbol;
    @endphp
<div class="row">
    <div class="col-12">
      <div
        class="w-100 d-flex align-items-center justify-content-between gap-lg-5 gap-3 flex-md-nowrap flex-wrap mb-4">
          <div>
              <h4>{{translate(Arr::get($meta_data,'title'))}}</h4>
          </div>
          <div>
              <a href="{{route('user.withdraw.report.list')}}" class="i-btn btn--primary-outline btn--md capsuled">
                    {{translate("Withdraw Reports")}}
                <i class="bi bi-arrow-right"></i></a>
          </div>
      </div>

      <div class="i-card-md">
        <div class="card-body">
          <form action="{{route('user.withdraw.request.process')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <h6 class="mb-3">{{translate('Withdraw methods')}}</h6>
                    <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-2 g-md-3 g-2">
                        @foreach ($methods as  $method)
                            <div class="col">
                                <label class="payment-card-item">
                                    <input  {{ $loop->index == 0 ? 'checked' : '' }} name="id" data-method="{{$method}}" data-img="{{imageURL(@$method->file,'withdraw_method',true)}}" value="{{$method->id}}" class="radio withdraw-method" type="radio" >
                                    <span class="image">
                                        <img src='{{imageURL(@$method->file,"withdraw_method",true)}}' alt="{{$method->name . 'Preview image'}}" >
                                    </span>
                                    <span class="title">{{$method->name}}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @if($methods->count() == 0)
                        <div>
                            @include('admin.partials.not_found',['custom_message' => 'No methods found'])
                        </div>
                    @endif
                </div>

                <div class="col-lg-4 ps-lg-5">
                    <div class="payment-flip-card">
                        <div class="balance-info-card" id="balanceCard">
                            <span class="balance-icon">
                                <i class="bi bi-wallet2"></i>
                            </span>
                            <p>{{translate('Affiliate Balance')}}</p>
                            <h4>{{num_format(number:$balance,calC:true)}}</h4>
                            <span class="balance-shape">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" x="0" y="0" viewBox="0 0 64 64" xml:space="preserve"><g><g fill="none" stroke="#0a1c28" stroke-linejoin="round" data-name="cradit card"><g stroke-width="2"><path d="M38 34a2 2 0 1 0-2-2 2 2 0 1 1-2-2M30 32h2M40 32h2M35 57h5"  opacity="1"></path><path d="M49 48V10a3 3 0 0 1-3-3H26a3 3 0 0 1-3 3v27"  opacity="1"></path><path d="M19 37V3h34v45M40 61H19M53 48 40 61V50a2 2 0 0 1 2-2z"  opacity="1"></path><path d="M46 55h8a3 3 0 0 1 3-3V12a3 3 0 0 1-3-3h-1"  opacity="1"></path><path d="M53 5h8v54H42M28.52 37A9 9 0 1 1 36 41h-1"  opacity="1"></path><rect width="32" height="24" x="3" y="37" rx="2"  opacity="1"></rect></g><path stroke-width="4" d="M3 44h32"  opacity="1"></path><circle cx="29" cy="55" r="2" stroke-width="2"  opacity="1"></circle><path stroke-width="2" d="M6 57h2M10 57h2"  opacity="1"></path></g></g></svg>
                            </span>
                        </div>

                        <div class="payment-card-form mt-4" id="formStepOne">
                            <div class="d-flex align-items-center justify-content-between payment-form-top d-none payment-header">
                            </div>

                            <div class="payment-details-wrapper">
                                <div class="alert alert-info d-flex align-items-center d-none payment-note-section mb-4" role="alert"></div>
                                <div class="card border-0 shadow-sm mb-4 d-none withdraw-details-card">
                                    <ul class="withdraw-details payment-details list-group list-group-flush"></ul>
                                </div>
                            </div>
                            <div class="p-0">
                                <div class="form-inner">
                                    <label for="amount">
                                        {{translate("Amount")}} <span class="text--danger">*</span></label>
                                    <div class="input-group">
                                        <input required placeholder="{{translate('Enter amount')}}" name="amount" type="number" class="form-control"id="amount" value="{{old('amount')}}"/>
                                        <span class="input-group-text">
                                            {{ $currencySymbol}}
                                        </span>
                                    </div>
                                </div>

                                <button type="submit" class="i-btn btn--lg btn--primary capsuled">
                                    {{translate('Submit')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

@endsection


@push('script-push')
<script nonce="{{ csp_nonce() }}">
	(function($){
        "use strict";




        var selectedMethod =  $('input[name="id"]:checked');

        if(selectedMethod){

            var method =  JSON.parse( $('input[name="id"]:checked').attr('data-method'));

            var img =  ( $('input[name="id"]:checked').attr('data-img'));

            var amount = ($('#amount').val());

            amount    = amount? parseFloat(amount) : 0;

            if(method)  withdrawCalculation(method,img,amount)

        }

        $(document).on("click",'.withdraw-method',function(e){
            var method =  JSON.parse($(this).attr('data-method'));
            var img =  ($(this).attr('data-img'));
            var amount = parseFloat($('#amount').val());

            if(method && amount){
                withdrawCalculation(method,img,amount)
            }
        });



        




        $(document).on("keyup",'#amount',function(e){
            var methodId =  $('input[name="id"]:checked').val();
            var amount = parseFloat($(this).val());
            if(methodId && amount){
                var img =  ($('input[name="id"]:checked').attr('data-img'));
                var method =  JSON.parse($('input[name="id"]:checked').attr('data-method'));
                withdrawCalculation(method,img,amount)
            }
            else{
                $('.withdraw-details').addClass('d-none');
                if(!methodId){
                    toastr("{{translate('Select a method first')}}",'danger')
                }
            }
        })

        function withdrawCalculation(method , img,amount){
            var paymentNote = method.note?? "{{translate('Payment with')}} "+method.name ;
            $('.payment-note-section').removeClass('d-none');
            $('.payment-header').removeClass('d-none');
            $('.withdraw-details-card').removeClass('d-none');
            $('.payment-note-section').html(`<i class="bi bi-info-circle-fill me-2 fs-5"></i> <div><strong>Note:</strong> ${paymentNote}</div>`)
            $('.payment-header').html(` <div class="d-flex align-items-center gap-3 mb-3">
                                            <div class="avatar-sm">
                                                <img src="${img}" alt="method image" class="rounded-circle border">
                                            </div>
                                            <h5 class="payment-method-title mb-0">${method.name}</h5>
                                        </div>`)
            var fixedCharge   =  parseFloat(method.fixed_charge);
            var percentCharge =  parseFloat(method.percent_charge);

            var netCharge     =  parseFloat(fixedCharge + (amount  * percentCharge / 100));
            var netAmount     =  (amount + netCharge);
            var  rate         = parseFloat({{$currency->exchange_rate}})
            var minLimit      = parseFloat(method.minimum_amount * rate)
            var maxLimit     = parseFloat(method.maximum_amount * rate)

            var list  =  `<li class="list-group-item bg-light text-dark fw-bold" aria-current="true">
                             <i class="bi bi-receipt me-2"></i> {{translate("Withdraw Details")}}
                          </li>`;

                list += `<li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">{{translate("Limit")}}</span>
                            <span class="fw-semibold">{{$currencySymbol}}${minLimit} - {{$currencySymbol}}${maxLimit}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted">{{translate("Charge")}}</span>
                            <span class="fw-semibold text-danger">{{$currencySymbol}}${netCharge} <small class="text-muted">({{$currencySymbol}}${fixedCharge} + ${percentCharge}%)</small></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                            <span class="fw-bold">{{translate("Final Deducted Amount")}}</span>
                            <span class="fw-bold text-primary">{{$currencySymbol}}${netAmount}</span>
                        </li>`;

            $('.withdraw-details').removeClass('d-none');
            var cleanContent = DOMPurify.sanitize(list);
            $('.withdraw-details').html(cleanContent)
        }
	})(jQuery);
</script>
@endpush
