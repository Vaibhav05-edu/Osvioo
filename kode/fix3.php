<?php
// Update 10% commission on all packages
App\Models\Package::query()->update(['affiliate_commission' => 10]);

// Enable global affiliate system if disabled
$affiliateSetting = App\Models\Core\Setting::where('key', 'affiliate_system')->first();
if ($affiliateSetting) {
    $affiliateSetting->value = 1;
    $affiliateSetting->save();
}

$withdraw = App\Models\Admin\Withdraw::first();
if (!$withdraw) {
    $withdraw = new \App\Models\Admin\Withdraw();
    $withdraw->name = 'Bank Transfer';
    $withdraw->duration = 3;
    $withdraw->minimum_amount = 20;
    $withdraw->maximum_amount = 10000;
    $withdraw->status = 1;
    $withdraw->fixed_charge = 0;
    $withdraw->percent_charge = 0;
    $withdraw->note = 'Please provide your bank details for withdrawal.';
    $withdraw->parameters = json_decode('{"account_name":{"field_label":"Account Name","field_name":"account_name","field_type":"text","field_level":"required"},"account_number":{"field_label":"Account Number","field_name":"account_number","field_type":"text","field_level":"required"},"bank_name":{"field_label":"Bank Name","field_name":"bank_name","field_type":"text","field_level":"required"}}', true);
    $withdraw->save();
} else {
    App\Models\Admin\Withdraw::query()->update(['minimum_amount' => 20]);
}
echo "Done\n";
