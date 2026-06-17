<?php
// Update 10% commission on all packages
App\Models\Package::query()->update(['affiliate_commission' => 10]);

// Enable global affiliate system if disabled
$affiliateSetting = App\Models\Core\Setting::where('name', 'affiliate_system')->first();
if ($affiliateSetting) {
    $affiliateSetting->value = 1;
    $affiliateSetting->save();
}

$withdraw = App\Models\Admin\Withdraw::first();
if (!$withdraw) {
    $withdraw = new \App\Models\Admin\Withdraw();
    $withdraw->name = 'Bank Transfer';
    $withdraw->duration = '2-3 Business Days';
    $withdraw->minimum_amount = 20;
    $withdraw->maximum_amount = 10000;
    $withdraw->status = 1;
    $withdraw->fixed_charge = 0;
    $withdraw->percent_charge = 0;
    $withdraw->note = 'Please provide your bank details for withdrawal.';
    $withdraw->parameters = json_decode('{"account_name":{"field_label":"Account Name","field_name":"account_name","field_type":"text","field_level":"required"},"account_number":{"field_label":"Account Number","field_name":"account_number","field_type":"text","field_level":"required"},"bank_name":{"field_label":"Bank Name","field_name":"bank_name","field_type":"text","field_level":"required"}}', true);
    $withdraw->save();

    $withdraw2 = new \App\Models\Admin\Withdraw();
    $withdraw2->name = 'PayPal';
    $withdraw2->duration = '1 Business Day';
    $withdraw2->minimum_amount = 20;
    $withdraw2->maximum_amount = 10000;
    $withdraw2->status = 1;
    $withdraw2->fixed_charge = 0;
    $withdraw2->percent_charge = 0;
    $withdraw2->note = 'Provide your PayPal email address.';
    $withdraw2->parameters = json_decode('{"paypal_email":{"field_label":"PayPal Email","field_name":"paypal_email","field_type":"text","field_level":"required"}}', true);
    $withdraw2->save();
} else {
    App\Models\Admin\Withdraw::query()->update(['minimum_amount' => 20]);
}
echo "Done\n";
