<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackagesSeeder extends Seeder
{
    public function run(): void
    {
        // Get Instagram platform ID dynamically
        $instagramPlatform = DB::table('media_platforms')->where('slug', 'instagram')->first();
        $platformAccess = $instagramPlatform ? [$instagramPlatform->id] : [];

        // Admin ID for created_by
        $adminId = DB::table('admins')->first()?->id ?? 1;

        $plans = [
            // ====== MONTHLY PLANS ======
            [
                'name'           => 'Core',
                'duration'       => 1,    // MONTHLY
                'price'          => 32,
                'discount_price' => 0,
                'is_recommended' => 0,
                'profile'        => 1,
                'post'           => 300,  // monthly posts
                'channels'       => 10,
                'word_limit'     => 13000,
                'image_limit'    => 50,
                'video_limit'    => 0,
                'auto_dm_limit'  => 1000,
                'description'    => 'Perfect for individual creators. 1,000 AI credits/mo, 1 brand, up to 10 social channels.',
            ],
            [
                'name'           => 'Rise',
                'duration'       => 1,    // MONTHLY
                'price'          => 79,
                'discount_price' => 0,
                'is_recommended' => 1,   // Most Popular
                'profile'        => 4,
                'post'           => 960, // monthly posts
                'channels'       => 20,
                'word_limit'     => 44800,
                'image_limit'    => 200,
                'video_limit'    => 100,
                'auto_dm_limit'  => -1,  // Unlimited
                'description'    => 'Best for growing creators. 3,200 AI credits/mo + 1,280 bonus, up to 4 brands, 20 channels.',
            ],
            [
                'name'           => 'Enterprise +',
                'duration'       => 1,    // MONTHLY
                'price'          => 249,
                'discount_price' => 0,
                'is_recommended' => 0,
                'profile'        => 999,  // Unlimited (large number)
                'post'           => 3000,
                'channels'       => 60,
                'word_limit'     => 140000,
                'image_limit'    => 500,
                'video_limit'    => 300,
                'auto_dm_limit'  => -1,  // Unlimited
                'description'    => 'For agencies & enterprises. 10,000 AI credits/mo + 4,000 bonus, unlimited brands, 60 channels.',
            ],

            // ====== YEARLY PLANS ======
            [
                'name'           => 'Core Yearly',
                'duration'       => 2,    // YEARLY
                'price'          => 230,  // $19/mo × 12 = $228 ~ $230 billed yearly
                'discount_price' => 0,
                'is_recommended' => 0,
                'profile'        => 1,
                'post'           => 3600,
                'channels'       => 10,
                'word_limit'     => 13000,
                'image_limit'    => 50,
                'video_limit'    => 0,
                'auto_dm_limit'  => 1000,
                'description'    => 'Core plan billed yearly. Save 40%! $19/mo × 12 = $230/yr. 1,000 AI credits/mo, 1 brand, 10 channels.',
            ],
            [
                'name'           => 'Rise Yearly',
                'duration'       => 2,    // YEARLY
                'price'          => 474,  // $40/mo × 12 = $480 ~ $474 billed yearly
                'discount_price' => 0,
                'is_recommended' => 0,
                'profile'        => 4,
                'post'           => 11520,
                'channels'       => 20,
                'word_limit'     => 44800,
                'image_limit'    => 200,
                'video_limit'    => 100,
                'auto_dm_limit'  => -1,  // Unlimited
                'description'    => 'Rise plan billed yearly. Save 50%! $40/mo × 12 = $474/yr. 3,200 AI credits/mo + 1,280 bonus, 4 brands, 20 channels.',
            ],
            [
                'name'           => 'Enterprise + Yearly',
                'duration'       => 2,    // YEARLY
                'price'          => 2540, // $212/mo × 12 = $2544 ~ $2540 billed yearly
                'discount_price' => 0,
                'is_recommended' => 0,
                'profile'        => 999,
                'post'           => 36000,
                'channels'       => 60,
                'word_limit'     => 140000,
                'image_limit'    => 500,
                'video_limit'    => 300,
                'auto_dm_limit'  => -1,  // Unlimited
                'description'    => 'Enterprise+ plan billed yearly. Save 15%! $212/mo × 12 = $2,540/yr. 10,000 AI credits/mo + 4,000 bonus, unlimited brands, 60 channels.',
            ],
        ];

        foreach ($plans as $planData) {
            // Skip if plan with this title already exists
            $exists = DB::table('packages')->where('title', $planData['name'])->exists();
            if ($exists) {
                $this->command->info("Plan '{$planData['name']}' already exists, skipping.");
                continue;
            }

            $slug = Str::slug($planData['name']);

            $socialAccess = json_encode([
                'webhook_access'     => '1',  // Auto DM access enabled
                'post'               => $planData['post'],
                'profile'            => $planData['profile'],
                'platform_access'    => $platformAccess,
                'auto_dm_limit'      => $planData['auto_dm_limit'],
            ]);

            $aiConfig = json_encode([
                'word_limit'   => $planData['word_limit'],
                'image_limit'  => $planData['image_limit'],
                'video_limit'  => $planData['video_limit'],
            ]);

            DB::table('packages')->insert([
                'uid'                   => (string) Str::uuid(),
                'title'                 => $planData['name'],
                'slug'                  => $slug,
                'description'           => $planData['description'],
                'icon'                  => 'fas fa-star',
                'price'                 => $planData['price'],
                'discount_price'        => $planData['discount_price'],
                'duration'              => $planData['duration'],
                'status'                => 1,
                'is_free'               => 0,
                'is_feature'            => 1,
                'is_recommended'        => $planData['is_recommended'],
                'social_access'         => $socialAccess,
                'ai_configuration'      => $aiConfig,
                'template_access'       => json_encode([]),
                'image_template_access' => json_encode([]),
                'video_template_access' => json_encode([]),
                'affiliate_commission'  => 0,
                'total_subscription_income' => 0,
                'created_by'            => $adminId,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);

            $this->command->info("✅ Plan '{$planData['name']}' created successfully.");
        }

        $this->command->info("\n🎉 All plans seeded! Run subscription for vaibhav@gmail.com next.");
    }
}
