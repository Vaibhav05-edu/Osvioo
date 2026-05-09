@php
    // No specific categories needed for this new section
@endphp

<section class="section-transform" id="transform">
    <div class="container-fluid px-0">
        <!-- Title Section -->
        <div class="text-center pt-5 pb-0 transform-header animate__animated animate__fadeIn">
            <h2 class="display-3 fw-bold mb-3" style="font-family: 'Outfit', sans-serif !important; line-height: 1.2;">
                Stop working overtime.<br>
                <span class="highlight-strip">Start replying in real time.</span>
            </h2>
            <p class="fs-4 text-muted mx-auto" style="max-width: 800px; font-family: 'Outfit', sans-serif !important;">
                Keep collecting W's even while catching Z's.
            </p>
        </div>

        <!-- Sticky Animation Wrapper -->
        <div class="transform-sticky-container">
            <div class="transform-cards-wrapper">
                <!-- BEFORE CARD -->
                <div class="transform-card before-card">
                    <div class="card-tag">Before Socialyt:</div>
                    <h3 class="card-title">You're doing IG<br>the hard way</h3>
                    
                    <ul class="benefit-list">
                        <li>
                            <span class="text">Wasting time replying the same tired reply to every DM.</span>
                            <span class="check-icon"><i class="fas fa-check-square"></i></span>
                        </li>
                        <li>
                            <span class="text">Missing leads because you can't respond fast enough.</span>
                            <span class="check-icon"><i class="fas fa-check-square"></i></span>
                        </li>
                        <li>
                            <span class="text">Letting comments pile up while you're busy doing everything else.</span>
                            <span class="check-icon"><i class="fas fa-check-square"></i></span>
                        </li>
                        <li>
                            <span class="text">Losing hours in your inbox when you should be growing your business.</span>
                            <span class="check-icon"><i class="fas fa-check-square"></i></span>
                        </li>
                    </ul>

                    <div class="card-footer">
                        <a href="{{route('auth.register')}}" class="btn-transform-dark">GET STARTED</a>
                    </div>
                </div>

                <!-- AFTER CARD -->
                <div class="transform-card after-card">
                    <div class="card-tag">After Socialyt:</div>
                    <h3 class="card-title">K.I.S.S. Keep it<br>simple... silly</h3>
                    
                    <div class="blob-accent">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <path fill="var(--royal-yellow)" d="M44.7,-76.4C58.1,-69.2,69.2,-58.1,76.4,-44.7C83.6,-31.3,86.9,-15.7,85.2,-0.9C83.6,13.8,77.1,27.7,68.2,39.4C59.3,51.1,48.1,60.7,35.4,68.2C22.7,75.7,8.6,81.1,-5.6,81.1C-19.8,81.1,-34.1,75.7,-46.8,68.2C-59.5,60.7,-70.7,51.1,-78.3,39.4C-85.9,27.7,-89.9,13.8,-88.3,-0.9C-86.7,-15.7,-79.5,-31.3,-69.2,-44.7C-58.9,-58.1,-45.6,-69.2,-31.1,-76.4C-16.7,-83.6,-8.3,-86.9,4.2,-86.9C16.7,-86.9,31.3,-83.6,44.7,-76.4Z" transform="translate(100 100)" />
                        </svg>
                    </div>

                    <ul class="benefit-list">
                        <li>
                            <span class="text">Every question gets answered. Fast.</span>
                            <span class="check-icon"><i class="fas fa-check-square"></i></span>
                        </li>
                        <li>
                            <span class="text">Leads? Saved, tagged, tracked — basically gift-wrapped for you.</span>
                            <span class="check-icon"><i class="fas fa-check-square"></i></span>
                        </li>
                        <li>
                            <span class="text">Every DM or comment becomes a chance to sell (even when you're offline).</span>
                            <span class="check-icon"><i class="fas fa-check-square"></i></span>
                        </li>
                        <li>
                            <span class="text">And you? Finally, free to kick back and sip your coffee while it's still hot.</span>
                            <span class="check-icon"><i class="fas fa-check-square"></i></span>
                        </li>
                    </ul>

                    <div class="card-footer">
                        <a href="{{route('auth.register')}}" class="btn-transform-light">GET STARTED</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style nonce="{{ csp_nonce() }}">
    .section-transform {
        background-color: var(--royal-white);
        overflow: visible;
        margin-bottom: -40vh !important; /* Pull up next section precisely */
        position: relative;
        z-index: 10;
        padding: 0 !important;
    }

    /* Force remove space from next section */
    .section-engagement-action {
        padding-top: 0 !important;
        margin-top: 0 !important;
        position: relative;
        z-index: 20;
    }

    .highlight-strip {
        position: relative;
        white-space: nowrap;
        display: inline-block;
        z-index: 1;
        padding: 0 10px;
    }

    .highlight-strip::after {
        content: "";
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 45%;
        background-color: var(--royal-yellow);
        z-index: -1;
        transform: rotate(-1deg);
        border-radius: 4px;
    }

    .transform-sticky-container {
        position: relative;
        height: 140vh; 
    }

    .transform-cards-wrapper {
        position: sticky;
        top: 8vh;
        display: flex;
        justify-content: center;
        gap: 30px;
        width: 100%;
        perspective: 2000px;
        padding: 0;
    }

    .transform-card {
        flex: 1;
        max-width: 550px;
        min-height: 600px;
        border-radius: 60px;
        padding: 50px 60px;
        display: flex;
        flex-direction: column;
        position: relative;
        box-shadow: 0 30px 70px rgba(0,0,0,0.05);
        z-index: 2;
        background-color: #fff;
    }

    .before-card {
        background-color: #F8F9FA;
        color: #1A1A1A;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .after-card {
        background-color: var(--royal-blue);
        color: #FFFFFF;
        box-shadow: 0 50px 100px rgba(0, 82, 255, 0.2);
        z-index: 3;
    }

    .card-tag {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .card-title {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 900;
        font-size: 3rem;
        line-height: 1.1;
        margin-bottom: 40px;
        letter-spacing: -1.5px;
    }

    .benefit-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex-grow: 1;
    }

    .benefit-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid rgba(0,0,0,0.08);
        font-family: 'Outfit', sans-serif !important;
        font-weight: 600;
        font-size: 1rem;
        gap: 20px;
    }

    .after-card .benefit-list li {
        border-bottom-color: rgba(255,255,255,0.15);
    }

    .card-footer {
        margin-top: 35px;
    }

    .btn-transform-dark, .btn-transform-light {
        display: block;
        width: 100%;
        text-align: center;
        padding: 20px;
        border-radius: 100px;
        text-decoration: none !important;
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: 1px;
    }

    .btn-transform-dark { background: #000; color: #fff !important; }
    .btn-transform-light { background: #fff; color: var(--royal-blue) !important; }

    .blob-accent {
        position: absolute;
        top: 20px;
        right: 40px;
        width: 150px;
        height: 150px;
        z-index: -1;
        opacity: 0.9;
        transform: rotate(-15deg);
    }

    @media (max-width: 991px) {
        .section-transform { margin-bottom: 0 !important; }
        .transform-sticky-container { height: auto; }
        .transform-cards-wrapper { position: relative; flex-direction: column; top: 0 !important; padding: 20px 15px; }
        .transform-card { max-width: 100%; padding: 40px 30px; min-height: auto; border-radius: 40px; }
    }
</style>

<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.querySelector('.transform-sticky-container');
        const beforeCard = document.querySelector('.before-card');
        const afterCard = document.querySelector('.after-card');
        
        if (!container || window.innerWidth < 992) return;

        function updateAnimation() {
            const containerRect = container.getBoundingClientRect();
            const containerHeight = container.offsetHeight;
            const windowHeight = window.innerHeight;
            
            let progress = -containerRect.top / (containerHeight - windowHeight);
            progress = Math.min(Math.max(progress, 0), 1);
            
            // Animation is done at 95% progress
            const mergeProgress = Math.min(progress / 0.95, 1);
            
            if (mergeProgress > 0) {
                const moveAmount = mergeProgress * 52; 
                const opacity = 1 - (mergeProgress * 3); 
                const scale = 1 - (mergeProgress * 0.15);
                
                // Rotation goes to 0 at the end
                const rotationAmount = 3;
                const currentRotation = mergeProgress < 0.7 
                    ? mergeProgress * (rotationAmount / 0.7) 
                    : Math.max(rotationAmount - ((mergeProgress - 0.7) * (rotationAmount / 0.3)), 0);
                
                beforeCard.style.transform = `translateX(${moveAmount}%) scale(${scale}) rotate(-${currentRotation}deg)`;
                beforeCard.style.opacity = Math.max(opacity, 0);
                
                afterCard.style.transform = `translateX(-${moveAmount}%) rotate(${currentRotation}deg)`;
                
                const extraWidth = mergeProgress * 150;
                afterCard.style.maxWidth = `${550 + extraWidth}px`;
            } else {
                beforeCard.style.transform = '';
                beforeCard.style.opacity = '1';
                afterCard.style.transform = '';
                afterCard.style.maxWidth = '550px';
            }
        }

        window.addEventListener('scroll', updateAnimation);
        updateAnimation();
    });
</script>
