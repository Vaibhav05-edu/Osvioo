<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPageSetting;
use App\Models\Faq;
use App\Models\Story;
use App\Models\PlateformStat;
use App\Models\Creator;
use App\Models\Video;

class LandingPageSeeder extends Seeder
{
    public function run()
    {
        // 1. Landing Page Settings
        LandingPageSetting::updateOrCreate(['id' => 1], [
            'headline_1' => 'AI that helps you grow',
            'headline_2' => 'That Grows You Faster',
            'typing_texts' => ['AI helps you grow', 'AI creates media kit', 'AI auto DM system'],
            'description' => 'Engage your followers automatically. Reply to comments with personalized DMs, save time, and explode your conversion rates.',
            'hero_image' => 'https://static.wixstatic.com/media/cdc6f6_0e9ea9a6ef58481b82bdc6a0442517c2~mv2.webp/v1/fill/w_1000,h_738,al_c,q_85/Group%201680482139.webp',
            'cta_text' => 'Start Automating Now',
            'cta_url' => '#',
        ]);

        // 2. Stats (Cards)
        $stats = [
            [
                'title' => 'Instagram Automation', 
                'description' => 'Automatically reply to comments on your posts and reels.', 
                'image' => 'stats/fashion_influencer_ecommerce_red_1777912440009.png',
                'order' => 1, 
                'status' => true
            ],
            [
                'title' => 'Inbox Starters', 
                'description' => 'Set up automated welcome messages for your new followers.', 
                'image' => 'stats/fashion_influencer_partnership_gold_1777912536159.png',
                'order' => 2, 
                'status' => true
            ],
            [
                'title' => 'Smart Keywords', 
                'description' => 'Trigger specific DMs based on keywords in comments.', 
                'image' => 'stats/fashion_influencer_reels_black_1777912474216.png',
                'order' => 3, 
                'status' => true
            ],
        ];
        PlateformStat::truncate();
        foreach ($stats as $s) {
            PlateformStat::create($s);
        }

        // 3. Stories
        $stories = [
            ['title' => 'E-Commerce Success', 'description' => 'How Sarah grew her shop by 300%.', 'image' => 'stats/fashion_influencer_story_chic_1777912506296.png', 'order' => 1, 'status' => true],
            ['title' => 'Partnership Growth', 'description' => 'Automating collab inquiries.', 'image' => 'stats/fashion_influencer_reels_black_1777912474216.png', 'order' => 2, 'status' => true],
        ];
        Story::truncate();
        foreach ($stories as $s) {
            Story::create($s);
        }

        // 4. Creators
        $creators = [
            ['username' => 'alex_r', 'followers' => '1.2M', 'profile_pic' => 'https://i.pravatar.cc/150?u=1', 'order' => 1, 'status' => true],
            ['username' => 'sarah_j', 'followers' => '500K', 'profile_pic' => 'https://i.pravatar.cc/150?u=2', 'order' => 2, 'status' => true],
            ['username' => 'mike_t', 'followers' => '2M', 'profile_pic' => 'https://i.pravatar.cc/150?u=3', 'order' => 3, 'status' => true],
            ['username' => 'elena_v', 'followers' => '800K', 'profile_pic' => 'https://i.pravatar.cc/150?u=4', 'order' => 4, 'status' => true],
        ];
        Creator::truncate();
        foreach ($creators as $c) {
            Creator::create($c);
        }

        // 5. Videos
        $videos = [
            ['title' => 'Automation Demo', 'video_url' => 'https://www.youtube.com/shorts/p6Z9k8S_Y5M', 'order' => 1, 'status' => true],
            ['title' => 'Creator Success', 'video_url' => 'https://www.youtube.com/shorts/p6Z9k8S_Y5M', 'order' => 2, 'status' => true],
            ['title' => 'How it Works', 'video_url' => 'https://www.youtube.com/shorts/p6Z9k8S_Y5M', 'order' => 3, 'status' => true],
        ];
        Video::truncate();
        foreach ($videos as $v) {
            Video::create($v);
        }

        // 5. FAQs
        $faqs = [
            ['question' => 'Is it safe for my account?', 'answer' => 'Yes, we use official Meta APIs to ensure your account safety.', 'order' => 1, 'is_active' => true],
            ['question' => 'How much does it cost?', 'answer' => 'We have plans starting from free to agency levels.', 'order' => 2, 'is_active' => true],
        ];
        Faq::truncate();
        foreach ($faqs as $f) {
            Faq::create($f);
        }
    }
}
