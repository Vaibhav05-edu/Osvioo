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


        $nonce = csp_nonce();
        $this->addDirective(Directive::STYLE, [
            "'self'",
            "'nonce-{$nonce}'",
            "'unsafe-inline'",
            'https://www.gstatic.com/',
            'https://www.gstatic.com/charts/49/css/util/util.css',
            'https://cdnjs.cloudflare.com/',
            'https://www.youtube.com',
        ]);

        $this->addDirective(Directive::SCRIPT, [
            "'self'",
            "'nonce-{$nonce}'",
            'https://www.google.com',
            'https://www.gstatic.com/' ,
            'https://www.gstatic.com/charts/geochart/10/info/mapList.js',
            'https://www.youtube.com',
            'https://s.ytimg.com',
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
        ]);


        $this->addDirective(Directive::MEDIA, '*');


        $this->addDirective(Directive::FRAME, [
            "'self'",
            'https://checkout.paystack.com',
            'https://*.paypal.com',
            'https://www.youtube.com',
            'https://*.youtube-nocookie.com',
        ]);

        $this->addDirective(Directive::CONNECT, [
            "'self'",
            'https://www.gstatic.com/',
            'https://*.paypal.com',
        ]);

        $this->addDirective(Directive::OBJECT, "'none'");





    }
}
