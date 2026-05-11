
<style nonce="{{ csp_nonce() }}">
    .pricing-container {
        font-family: 'Outfit', sans-serif !important;
        background-color: #fff;
    }
    .pricing-card-predis {
        background: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 20px;
        padding: 30px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        position: relative;
        text-align: left;
    }
    .pricing-card-predis.featured {
        border: 2px solid #3B82F6;
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.1);
    }
    .popular-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #3B82F6;
        color: white;
        padding: 5px 15px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 15px;
    }
    .price-box {
        display: flex;
        align-items: baseline;
        color: #2563EB;
        margin-bottom: 5px;
    }
    .currency-symbol {
        font-size: 1.5rem;
        font-weight: 600;
        margin-right: 2px;
    }
    .price-amount {
        font-size: 3.5rem;
        font-weight: 800;
        letter-spacing: -2px;
    }
    .original-price {
        font-size: 1.1rem;
        color: #6B7280;
        text-decoration: line-through;
        margin-left: 10px;
        font-weight: 500;
    }
    .price-period {
        font-size: 1rem;
        color: #6B7280;
        margin-left: 5px;
        font-weight: 500;
    }
    .billed-yearly-text {
        font-size: 0.85rem;
        color: #374151;
        font-weight: 600;
        margin-bottom: 20px;
        min-height: 1.2rem;
    }
    
    .btn-split-predis {
        display: flex;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 15px;
        text-decoration: none !important;
        border: none;
    }
    .btn-split-left {
        background: #EFF6FF;
        color: #2563EB;
        flex-grow: 1;
        padding: 12px;
        font-weight: 700;
        text-align: center;
        border: 1px solid #DBEAFE;
    }
    .btn-split-right {
        background: #2563EB;
        color: white;
        padding: 12px 20px;
        font-weight: 700;
        text-align: center;
        border: 1px solid #2563EB;
    }
    .featured .btn-split-left { background: #1F2937; color: white; border-color: #1F2937; }
    .featured .btn-split-right { background: #1E40AF; border-color: #1E40AF; }

    .trial-info {
        font-size: 0.85rem;
        color: #6B7280;
        text-align: center;
        margin-bottom: 25px;
    }

    .credits-box {
        text-align: center;
        margin-bottom: 25px;
    }
    .total-credits {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1F2937;
        margin-bottom: 5px;
    }
    .bonus-text {
        font-size: 0.8rem;
        color: #6B7280;
        margin-bottom: 12px;
    }
    .progress-bar-predis {
        height: 8px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 8px;
    }
    .progress-fill {
        height: 100%;
        background: #3B82F6;
        width: 100%;
    }
    .extra-output-text {
        font-size: 0.75rem;
        color: #2563EB;
        font-weight: 700;
        text-align: right;
    }

    .feature-list {
        list-style: none;
        padding: 0;
        margin: 0 0 30px 0;
    }
    .feature-list li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        font-size: 0.95rem;
        color: #374151;
        font-weight: 500;
    }
    .check-icon-predis {
        color: #10B981;
        font-size: 1.2rem;
    }

    .addons-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #6B7280;
        margin-bottom: 15px;
        border-top: 1px solid #F3F4F6;
        padding-top: 15px;
    }
    .addon-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .addon-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        max-width: 60%;
    }
    .addon-counter {
        display: flex;
        align-items: center;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 4px;
        gap: 10px;
    }
    .counter-btn {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #6B7280;
        border: none;
        background: none;
        font-size: 1.2rem;
    }
    .counter-value {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1F2937;
        min-width: 15px;
        text-align: center;
    }
</style>

<div class="pricing-container py-4">
    <div class="glider-nav mb-5">
        <ul class="nav plan-tab glider-tab d-flex justify-content-center mx-auto position-relative" role="tablist" style="background: #F3F4F6; padding: 5px; border-radius: 12px; width: fit-content;">
            @foreach (App\Enums\PlanDuration::toArray() as $key => $value)
                <li class="nav-item" role="presentation">
                    <a href="javascript:void(0)" class="nav-link {{$loop->first ? 'active' : ''}} px-4 py-2" id="{{$value}}-tab" data-bs-toggle="tab" data-bs-target="#{{$value}}-tab-pane" role="tab" style="border-radius: 8px; color: #6B7280; font-weight: 600; border: none !important;">
                        {{$key}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="tab-content">
        @foreach (App\Enums\PlanDuration::toArray() as $key => $value)
            <div class="tab-pane fade {{$loop->first ? 'show active' : ''}}" id="{{$value}}-tab-pane" role="tabpanel">
                @php
                    $purchasePlans = $plans->where('duration', $value);
                @endphp
                <div class="row g-4 justify-content-center">
                    @forelse ($purchasePlans as $plan)
                        <div class="col-lg-4 col-md-6">
                            <div class="pricing-card-predis {{ $plan->is_recommended == 1 ? 'featured' : '' }}">
                                @if($plan->is_recommended == 1)
                                    <span class="popular-badge">Most Popular</span>
                                @endif

                                <h3 class="card-title">{{$plan->title}}</h3>
                                
                                <div class="price-box">
                                    <span class="currency-symbol">$</span>
                                    <span class="price-amount">{{ (int)$plan->discount_price > 0 ? (int)$plan->discount_price : (int)$plan->price }}</span>
                                    @if((int)$plan->discount_price > 0)
                                        <span class="original-price">{{ (int)$plan->price }}</span>
                                    @endif
                                    <span class="price-period">/{{ $value == 'monthly' ? 'month' : 'year' }}</span>
                                </div>
                                <div class="billed-yearly-text">
                                    @if($value == 'yearly')
                                        ${{ ((int)$plan->discount_price > 0 ? (int)$plan->discount_price : (int)$plan->price) * 12 }} Billed Yearly
                                    @endif
                                </div>

                                <a href="javascript:void(0)" data-href="{{route('user.plan.purchase',$plan->slug)}}" class="btn-split-predis subscribe-plan">
                                    <div class="btn-split-left">Start for free</div>
                                    <div class="btn-split-right">50% off</div>
                                </a>
                                <div class="trial-info">$0 for 7 Days</div>

                                <div class="credits-box">
                                    <div class="total-credits">4,480 Total Credits</div>
                                    <div class="bonus-text">(3200 + 1280 Bonus)</div>
                                    <div class="progress-bar-predis">
                                        <div class="progress-fill"></div>
                                    </div>
                                    <div class="extra-output-text">40% extra output</div>
                                </div>

                                <ul class="feature-list">
                                    @foreach (plan_configuration($plan) as $configKey => $configVal)
                                        <li>
                                            <i class="bi bi-check-circle-fill check-icon-predis"></i>
                                            <span>
                                                @if(!is_bool($configVal)) <strong>{{$configVal}}</strong> @endif 
                                                {{k2t($configKey)}}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="addons-title">Add-ons</div>
                                <div class="addon-item">
                                    <div class="addon-label">Extra Social Channels ($25/month)</div>
                                    <div class="addon-counter">
                                        <button class="counter-btn" onclick="updateCounter(this, -1)">−</button>
                                        <span class="counter-value">0</span>
                                        <button class="counter-btn" onclick="updateCounter(this, 1)">+</button>
                                    </div>
                                </div>
                                <div class="addon-item">
                                    <div class="addon-label">Extra Credits ($29/month)</div>
                                    <div class="addon-counter">
                                        <button class="counter-btn" onclick="updateCounter(this, -1)">−</button>
                                        <span class="counter-value">0</span>
                                        <button class="counter-btn" onclick="updateCounter(this, 1)">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h4 class="text-muted">No plans available for this duration.</h4>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

<script nonce="{{ csp_nonce() }}">
    function updateCounter(btn, change) {
        const counter = btn.closest('.addon-counter').querySelector('.counter-value');
        let value = parseInt(counter.innerText);
        value = Math.max(0, value + change);
        counter.innerText = value;
    }
</script>

