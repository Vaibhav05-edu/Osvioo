<?php

namespace App\Providers;

use App\Models\Admin\MailGateway;
use Illuminate\Support\Facades\Config;
use App\Models\MailConfiguration;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $mail = MailGateway::where('code', '101SMTP')->first();
            if($mail){
                $config = array(
                    'driver'     => env('MAIL_MAILER', @$mail->credential->driver),
                    'host'       => env('MAIL_HOST', @$mail->credential->host),
                    'port'       => env('MAIL_PORT', @$mail->credential->port),
                    'from'       => [
                        'address'=> env('MAIL_FROM_ADDRESS', @$mail->credential->from->address),
                        'name'   => env('MAIL_FROM_NAME', @$mail->credential->from->name)
                    ],
                    'encryption' => env('MAIL_ENCRYPTION', @$mail->credential->encryption=="PWMTA"?null:$mail->credential->encryption),
                    'username'   => env('MAIL_USERNAME', @$mail->credential->username),
                    'password'   => env('MAIL_PASSWORD', @$mail->credential->password),
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);

            }
        }catch (\Exception $ex) {

        }
    }
}
