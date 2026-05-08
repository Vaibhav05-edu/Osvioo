@php
    $cardsRow1 = [
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/1587009/pexels-photo-1587009.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#FF8A00'],
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/hm.png'), 'bg' => '#FFFFFF'],
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/1181686/pexels-photo-1181686.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#FFD200'],
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/flipkart.png'), 'bg' => '#FFFFFF'],
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/3772506/pexels-photo-3772506.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#7C3AED'],
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/nike.png'), 'bg' => '#FFFFFF'],
    ];

    $cardsRow2 = [
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/shein.png'), 'bg' => '#000000'],
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#F472B6'],
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/zara.png'), 'bg' => '#FFFFFF'],
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/1845534/pexels-photo-1845534.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#34D399'],
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/myntra.png'), 'bg' => '#FFFFFF'],
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/1130626/pexels-photo-1130626.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#60A5FA'],
    ];

    $cardsRow3 = [
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#FB923C'],
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/ajio.png'), 'bg' => '#FFFFFF'],
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#FFD200'],
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/puma.png'), 'bg' => '#000000'],
        ['type' => 'creator', 'img' => 'https://images.pexels.com/photos/1065084/pexels-photo-1065084.jpeg?auto=compress&cs=tinysrgb&w=500', 'bg' => '#8B5CF6'],
        ['type' => 'logo', 'img' => asset('assets/frontend/images/logos/hm.png'), 'bg' => '#FFFFFF'],
    ];
@endphp

<section class="section-brand-marquee">
    <div class="container-fluid px-0">
        <h2 class="marquee-heading">Loved by Creators, trusted by Brands</h2>
        <p class="marquee-subtext">Join forces with fellow Creators, partner with leading Brands like never before</p>

        <div class="marquee-wrapper">
            <!-- Row 1: Right -->
            <div class="marquee-row">
                <div class="marquee-content">
                    @foreach(array_merge($cardsRow1, $cardsRow1) as $card)
                        <div class="chunky-card {{ $card['type'] == 'logo' ? 'logo-card' : '' }}" style="background-color: {{ $card['bg'] }}">
                            <img src="{{ $card['img'] }}" alt="Marquee Item">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Row 2: Left -->
            <div class="marquee-row">
                <div class="marquee-content reverse">
                    @foreach(array_merge($cardsRow2, $cardsRow2) as $card)
                        <div class="chunky-card {{ $card['type'] == 'logo' ? 'logo-card' : '' }}" style="background-color: {{ $card['bg'] }}">
                            <img src="{{ $card['img'] }}" alt="Marquee Item">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Row 3: Right -->
            <div class="marquee-row">
                <div class="marquee-content">
                    @foreach(array_merge($cardsRow3, $cardsRow3) as $card)
                        <div class="chunky-card {{ $card['type'] == 'logo' ? 'logo-card' : '' }}" style="background-color: {{ $card['bg'] }}">
                            <img src="{{ $card['img'] }}" alt="Marquee Item">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
