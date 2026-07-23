<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;

class CustomCspPolicy extends Basic
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        // Custom initialization if needed
    }

    /**
     * Configure the CSP for the application.
     */
    public function configure()
    {



        parent::configure();


        $this->addDirective(Directive::DEFAULT, "'self'");


        $this->addDirective(Directive::STYLE, [
            "'self'",
            "'unsafe-inline'",
            'https://www.gstatic.com/',
            'https://www.gstatic.com/charts/49/css/util/util.css',
            'https://cdnjs.cloudflare.com/',
            'https://checkout.razorpay.com',

            'https://cdn.jsdelivr.net/',
            'https://www.youtube.com',
            'https://fonts.cdnfonts.com',
            'https://fonts.googleapis.com',
        ]);

        $nonce = csp_nonce();
        $this->addDirective(Directive::SCRIPT, [
            "'self'",
            "'nonce-{$nonce}'",
            "'unsafe-inline'",
            "'unsafe-eval'",
            'https://www.google.com',
            'https://www.gstatic.com/' ,
            'https://www.gstatic.com/charts/geochart/10/info/mapList.js',
            'https://www.youtube.com',
            'https://s.ytimg.com',
            'https://cdn.jsdelivr.net/',
            'https://cdnjs.cloudflare.com/',
            'https://checkout.razorpay.com',

        ]);


        $this->addDirective(Directive::IMG, [
            "'self'",
            '*',
            'data:',
            'blob:'
        ]);


        $this->addDirective(Directive::FONT, [
            "'self'",
            'https://fonts.gstatic.com',
            'https://fonts.googleapis.com',
            'https://cdnjs.cloudflare.com/',
            'https://checkout.razorpay.com',

            'https://fonts.cdnfonts.com',
        ]);


        $this->addDirective(Directive::MEDIA, '*');


        $this->addDirective(Directive::FRAME, [
            "'self'",
            'https://checkout.paystack.com',
            'https://*.paypal.com',
            'https://www.youtube.com',
            'https://*.youtube-nocookie.com',
            'https://api.razorpay.com',
            'https://checkout.razorpay.com',
            'https://rzp.io',
        ]);

        $this->addDirective(Directive::CONNECT, [
            "'self'",
            '*',
            'https://www.gstatic.com/',
            'https://*.paypal.com',
            'https://cdn.jsdelivr.net/',
            'https://cdnjs.cloudflare.com/',
            'https://api.razorpay.com',
            'https://checkout.razorpay.com',
            'https://lumberjack.razorpay.com',
        ]);

        $this->addDirective(Directive::OBJECT, "'none'");





    }
}
