<aside class="aside glass-panel">
    @php
    $user = auth_user('web');
    $subscription = $user->runningSubscription;
    $webhookAccess = @optional($subscription->package->social_access)->webhook_access;
    $accessPlatforms = (array) ($subscription ? @$subscription?->package?->social_access?->platform_access : []);

    $platforms = get_platform()
    ->whereIn('id', $accessPlatforms )
    ->where("status",App\Enums\StatusEnum::true->status())
    ->where("is_integrated",App\Enums\StatusEnum::true->status());

    $platform = $platforms?->first();
    $lastSegment = collect(request()->segments())->last();
    @endphp
    
    <div class="side-content">
        <a href="{{route('user.home')}}" class="sidebar-logo d-block mb-4" style="text-decoration: none;">
            <div class="site-logo d-flex align-items-center gap-2">
                <div class="logo-icon-wrapper d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: var(--primary-gradient); border-radius: 12px; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="white"/>
                        <path d="M12 6C8.69 6 6 8.69 6 12C6 15.31 8.69 18 12 18C15.31 18 18 15.31 18 12C18 8.69 15.31 6 12 6ZM12 16C9.79 16 8 14.21 8 12C8 9.79 9.79 8 12 8C14.21 8 16 9.79 16 12C16 14.21 14.21 16 12 16Z" fill="white"/>
                    </svg>
                </div>
                <span class="gradient-text" style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.6rem; letter-spacing: -1px;">osvioo</span>
            </div>
        </a>

        <div class="sidemenu-wrapper">
            <div class="sidebar-body" data-simplebar>
                <ul class="sidemenu-list">
                    <li class="side-menu-title">{{translate("Main")}}</li>

                    <li class="sidemenu-item">
                        <a href="{{route('user.home')}}" class="sidemenu-link {{request()->routeIs('user.home') ? 'active' :''}}">
                            <div class="sidemenu-icon"><i class="bi bi-grid-1x2"></i></div>
                            <span>{{translate('Dashboard')}}</span>
                        </a>
                    </li>

                    {{-- AUTO DM SECTION --}}
                    <li class="side-menu-title">{{translate("Automation")}}</li>
                    <li class="sidemenu-item">
                        <a href="{{route('user.social.auto_dm.list')}}" class="sidemenu-link {{request()->routeIs('user.social.auto_dm.list') ? 'active' :''}}">
                            <div class="sidemenu-icon"><i class="bi bi-chat-dots"></i></div>
                            <span>{{translate("Auto DM")}}</span>
                        </a>
                    </li>

                    <li class="sidemenu-item">
                        <a href="javascript:void(0)" class="sidemenu-link sidemenu-collapse">
                            <div class="sidemenu-icon"><i class="bi bi-send"></i></div>
                            <span>
                                {{translate("Auto Post")}}
                                <small><i class="bi bi-chevron-down"></i></small>
                            </span>
                        </a>
                        <div class="side-menu-dropdown">
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-instagram"></i></span><p>{{translate('Insta')}}</p></a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- MEDIA KIT SECTION --}}
                    <li class="side-menu-title">{{translate("Creator Tools")}}</li>
                    <li class="sidemenu-item">
                        <a href="javascript:void(0)" class="sidemenu-link sidemenu-collapse">
                            <div class="sidemenu-icon"><i class="bi bi-person-badge"></i></div>
                            <span>
                                {{translate("Media Kit")}}
                                <small><i class="bi bi-chevron-down"></i></small>
                            </span>
                        </a>
                        <div class="side-menu-dropdown">
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-stars"></i></span><p>{{translate('Media Kit AI Maker')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-clock-history"></i></span><p>{{translate('Previous Media Kit')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-pencil-square"></i></span><p>{{translate('Media Kit Edit')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-bar-chart-line"></i></span><p>{{translate('Media Kit Insights')}}</p></a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="sidemenu-item">
                        <a href="javascript:void(0)" class="sidemenu-link sidemenu-collapse">
                            <div class="sidemenu-icon"><i class="bi bi-receipt"></i></div>
                            <span>
                                {{translate("Invoice Maker")}}
                                <small><i class="bi bi-chevron-down"></i></small>
                            </span>
                        </a>
                        <div class="side-menu-dropdown">
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-plus-circle"></i></span><p>{{translate('Make Invoice')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-share"></i></span><p>{{translate('Shared Invoice')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-files"></i></span><p>{{translate('Total Invoice')}}</p></a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- SOCIAL MEDIA SECTION --}}
                    <li class="side-menu-title">{{translate("Social Media")}}</li>
                    <li class="sidemenu-item">
                        <a href="{{route('user.social.post.create')}}" class="sidemenu-link {{request()->routeIs('user.social.post.create') ? 'active' :''}}">
                            <div class="sidemenu-icon"><i class="bi bi-calendar-plus"></i></div>
                            <span>{{translate("Schedule Post")}}</span>
                        </a>
                    </li>

                    <li class="sidemenu-item">
                        <a href="javascript:void(0)" class="sidemenu-link sidemenu-collapse">
                            <div class="sidemenu-icon"><i class="bi bi-lightbulb"></i></div>
                            <span>
                                {{translate("AI Suggestions")}}
                                <small><i class="bi bi-chevron-down"></i></small>
                            </span>
                        </a>
                        <div class="side-menu-dropdown">
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-hash"></i></span><p>{{translate('AI Post Hashtag')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-chat-left-text"></i></span><p>{{translate('AI Post Suggestion')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-clock"></i></span><p>{{translate('AI Post Timing')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-graph-up-arrow"></i></span><p>{{translate('AI Current Trend')}}</p></a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- INSTAGRAM SECTION --}}
                    <li class="side-menu-title">{{translate("Instagram")}}</li>
                    <li class="sidemenu-item">
                        <a href="javascript:void(0)" class="sidemenu-link sidemenu-collapse">
                            <div class="sidemenu-icon"><i class="bi bi-instagram"></i></div>
                            <span>
                                {{translate("Manage Account")}}
                                <small><i class="bi bi-chevron-down"></i></small>
                            </span>
                        </a>
                        <div class="side-menu-dropdown">
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="{{route('user.social.account.platform')}}"><span><i class="bi bi-plus-circle"></i></span><p>{{translate('Connect Account')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="{{ $platform ? route('user.social.account.list',['platform' => 'instagram']) : route('user.social.account.list') }}"><span><i class="bi bi-person-check"></i></span><p>{{translate('Connected Account')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-bar-chart"></i></span><p>{{translate('Instagram Insights')}}</p></a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- PLANS & BILLING SECTION --}}
                    <li class="side-menu-title">{{translate("Plans & Billing")}}</li>
                    <li class="sidemenu-item">
                        <a href="javascript:void(0)" class="sidemenu-link sidemenu-collapse">
                            <div class="sidemenu-icon"><i class="bi bi-box-seam"></i></div>
                            <span>
                                {{translate("Plans")}}
                                <small><i class="bi bi-chevron-down"></i></small>
                            </span>
                        </a>
                        <div class="side-menu-dropdown">
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a class="sidebar-menu-link {{request()->routeIs('user.plan.active') ? 'active' :''}}" href="{{route('user.plan.active')}}"><span><i class="bi bi-check-circle"></i></span><p>{{translate('Active Plan')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link {{request()->routeIs('user.plan.history') ? 'active' :''}}" href="{{route('user.plan.history')}}"><span><i class="bi bi-clock-history"></i></span><p>{{translate('Previous Plan')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="{{route('user.transaction.report.list')}}"><span><i class="bi bi-receipt"></i></span><p>{{translate('Invoice')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link {{request()->routeIs('user.plan.billing.upcoming') ? 'active' :''}}" href="{{route('user.plan.billing.upcoming')}}"><span><i class="bi bi-calendar-event"></i></span><p>{{translate('Upcoming Billing')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="{{route('user.transaction.report.list')}}"><span><i class="bi bi-arrow-left-right"></i></span><p>{{translate('Previous Transaction')}}</p></a></li>
                                <li class="sub-menu-item"><a class="sidebar-menu-link" href="#"><span><i class="bi bi-x-circle"></i></span><p>{{translate('Failed Transaction')}}</p></a></li>
                            </ul>
                        </div>
                    </li>

                    {{-- ACCOUNT SETTINGS --}}
                    <li class="side-menu-title">{{translate("Account Settings")}}</li>
                    <li class="sidemenu-item">
                        <a href="{{route('user.profile')}}" class="sidemenu-link {{request()->routeIs('user.profile') ? 'active' :''}}">
                            <div class="sidemenu-icon"><i class="bi bi-person-gear"></i></div>
                            <span>{{translate("Profile Settings")}}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-footer">
                <div class="header-right-item">
                    <div class="dropdown currency">
                        <button class="dropdown-toggle" type="button" @if($currencies->count() > 0)
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            @endif>
                            {{session()->get('currency')?->code}}
                        </button>
                        @if($currencies->count() > 0)
                        <ul class="dropdown-menu dropdown-menu-end">
                            @foreach($currencies as $currency)
                            <li><a class="dropdown-item" href="{{route('currency.change',$currency->code)}}"> {{$currency->code}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>

                <a href="{{route('user.logout')}}" class="logout-btn frosted-btn-outline w-100 mt-3" style="border-radius: 12px; font-size: 14px;">
                    <span><i class="bi bi-box-arrow-right"></i></span>
                    {{translate('Logout')}}
                </a>
            </div>
        </div>
    </div>
</aside>
