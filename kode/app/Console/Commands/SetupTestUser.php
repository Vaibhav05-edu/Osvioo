<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Package;
use App\Http\Services\UserService;

class SetupTestUser extends Command
{
    protected $signature = 'setup:test-user {email=vaibhav@gmail.com}';
    protected $description = 'Seeds all pricing plans and subscribes the given user to Enterprise+ plan';

    public function handle(): void
    {
        $this->info('🚀 Starting setup...');

        // ── STEP 1: Seed Plans ──────────────────────────────────────────────
        $this->info("\n📦 Step 1: Seeding plans...");

        $instagramPlatform = DB::table('media_platforms')->where('slug', 'instagram')->first();
        $platformAccess = $instagramPlatform ? [$instagramPlatform->id] : [];
        $adminId = DB::table('admins')->first()?->id ?? 1;

        $plans = [
            // Monthly
            ['name' => 'Core',               'duration' => 1, 'price' => 32,   'recommended' => 0, 'profile' => 1,   'post' => 300,   'channels' => 10, 'words' => 13000,  'images' => 50,  'videos' => 0,   'dm_limit' => 1000, 'desc' => 'Core plan - 1,000 AI credits/mo, 1 brand, 10 channels.'],
            ['name' => 'Rise',               'duration' => 1, 'price' => 79,   'recommended' => 1, 'profile' => 4,   'post' => 960,   'channels' => 20, 'words' => 44800,  'images' => 200, 'videos' => 100, 'dm_limit' => -1,   'desc' => 'Rise plan - 3,200 AI credits/mo + 1,280 bonus, 4 brands, 20 channels.'],
            ['name' => 'Enterprise +',       'duration' => 1, 'price' => 249,  'recommended' => 0, 'profile' => 999, 'post' => 3000,  'channels' => 60, 'words' => 140000, 'images' => 500, 'videos' => 300, 'dm_limit' => -1,   'desc' => 'Enterprise+ - 10,000 AI credits/mo + 4,000 bonus, unlimited brands.'],
            // Yearly
            ['name' => 'Core Yearly',        'duration' => 2, 'price' => 230,  'recommended' => 0, 'profile' => 1,   'post' => 3600,  'channels' => 10, 'words' => 13000,  'images' => 50,  'videos' => 0,   'dm_limit' => 1000, 'desc' => 'Core plan billed yearly. Save 40%! $19/mo.'],
            ['name' => 'Rise Yearly',        'duration' => 2, 'price' => 474,  'recommended' => 0, 'profile' => 4,   'post' => 11520, 'channels' => 20, 'words' => 44800,  'images' => 200, 'videos' => 100, 'dm_limit' => -1,   'desc' => 'Rise plan billed yearly. Save 50%! $40/mo.'],
            ['name' => 'Enterprise + Yearly','duration' => 2, 'price' => 2540, 'recommended' => 0, 'profile' => 999, 'post' => 36000, 'channels' => 60, 'words' => 140000, 'images' => 500, 'videos' => 300, 'dm_limit' => -1,   'desc' => 'Enterprise+ billed yearly. Save 15%! $212/mo.'],
        ];

        foreach ($plans as $p) {
            if (DB::table('packages')->where('title', $p['name'])->exists()) {
                $this->line("  ⏭  '{$p['name']}' already exists, skipping.");
                continue;
            }

            DB::table('packages')->insert([
                'uid'                       => (string) Str::uuid(),
                'title'                     => $p['name'],
                'slug'                      => Str::slug($p['name']),
                'description'               => $p['desc'],
                'icon'                      => 'fas fa-star',
                'price'                     => $p['price'],
                'discount_price'            => 0,
                'duration'                  => $p['duration'],
                'status'                    => '1',
                'is_free'                   => '0',
                'is_feature'                => '1',
                'is_recommended'            => (string)$p['recommended'],
                'social_access'             => json_encode([
                    'webhook_access'  => '1',
                    'post'            => $p['post'],
                    'profile'         => $p['profile'],
                    'platform_access' => $platformAccess,
                    'auto_dm_limit'   => $p['dm_limit'],
                ]),
                'ai_configuration'          => json_encode([
                    'word_limit'  => $p['words'],
                    'image_limit' => $p['images'],
                    'video_limit' => $p['videos'],
                ]),
                'template_access'           => json_encode([]),
                'image_template_access'     => json_encode([]),
                'video_template_access'     => json_encode([]),
                'affiliate_commission'      => 0,
                'total_subscription_income' => 0,
                'created_by'                => $adminId,
                'created_at'                => now(),
                'updated_at'                => now(),
            ]);

            $this->info("  ✅ '{$p['name']}' created.");
        }

        // ── STEP 2: Subscribe User ──────────────────────────────────────────
        $email = $this->argument('email');
        $this->info("\n👤 Step 2: Subscribing {$email} to Enterprise+ ...");

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("  ❌ User '{$email}' not found in database!");
            return;
        }

        $package = Package::active()->where('title', 'Enterprise +')->first();
        if (!$package) {
            $this->error("  ❌ 'Enterprise +' package not found after seeding!");
            return;
        }

        // Top up balance if needed
        $price = round($package->discount_price) > 0 ? $package->discount_price : $package->price;
        if ($user->balance < $price) {
            $user->balance = $price + 5000;
            $user->save();
            $this->info("  💰 Balance topped up to \${$user->balance}");
        }

        $service = new UserService();
        $result  = $service->createSubscription($user, $package, 'Manual test subscription');

        if ($result['status'] ?? false) {
            $this->info("  ✅ {$email} successfully subscribed to 'Enterprise +'!");
        } else {
            $this->error("  ❌ Subscription failed: " . ($result['message'] ?? 'Unknown error'));
        }

        $this->info("\n🎉 Setup complete! You can now test all features.");
    }
}
