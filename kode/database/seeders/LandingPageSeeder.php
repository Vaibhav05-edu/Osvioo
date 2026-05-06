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
            'headline_1' => 'Automate your social media',
            'headline_2' => '10x faster',
            'typing_texts' => ['AI helps you grow', 'AI creates media kit', 'AI auto DM system'],
            'description' => 'Our all-in-one social media management platform unlocks the full potential of social to transform not just your marketing strategy—but every area of your organization.',
            'hero_image' => null,
            'cta_text' => 'Start Automating Now',
            'cta_url' => '#',
        ]);

        // 2. Stats (How It Works)
        $stats = [
            [
                'title' => 'Instagram Automation', 
                'description' => 'Automatically reply to comments on your posts and reels.', 
                'image' => 'assets/images/custom/fashion_influencer_ecommerce_red_1777912440009.png',
                'order' => 1, 
                'status' => true
            ],
            [
                'title' => 'Inbox Starters', 
                'description' => 'Set up automated welcome messages for your new followers.', 
                'image' => 'assets/images/custom/fashion_influencer_partnership_gold_1777912536159.png',
                'order' => 2, 
                'status' => true
            ],
            [
                'title' => 'Smart Keywords', 
                'description' => 'Trigger specific DMs based on keywords in comments.', 
                'image' => 'assets/images/custom/fashion_influencer_reels_black_1777912474216.png',
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
            ['title' => 'E-Commerce Success', 'description' => 'How Sarah grew her shop by 300%.', 'image' => 'assets/images/custom/fashion_influencer_story_chic_1777912506296.png', 'order' => 1, 'status' => true],
            ['title' => 'Partnership Growth', 'description' => 'Automating collab inquiries.', 'image' => 'assets/images/custom/fashion_influencer_reels_black_1777912474216.png', 'order' => 2, 'status' => true],
        ];
        Story::truncate();
        foreach ($stories as $s) {
            Story::create($s);
        }

        // 4. Creators
        $creators = [
            ['username' => 'alex_r', 'followers' => '1.2M', 'profile_pic' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=150&auto=format&fit=crop', 'order' => 1, 'status' => true],
            ['username' => 'sarah_j', 'followers' => '500K', 'profile_pic' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150&auto=format&fit=crop', 'order' => 2, 'status' => true],
            ['username' => 'mike_t', 'followers' => '2M', 'profile_pic' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&auto=format&fit=crop', 'order' => 3, 'status' => true],
            ['username' => 'elena_v', 'followers' => '800K', 'profile_pic' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150&auto=format&fit=crop', 'order' => 4, 'status' => true],
        ];
        Creator::truncate();
        foreach ($creators as $c) {
            Creator::create($c);
        }

        // 5. Videos (Engagement Cards)
        $videos = [
            ['title' => 'Automation Demo', 'video_url' => 'https://images.pexels.com/photos/5077067/pexels-photo-5077067.jpeg?auto=compress&cs=tinysrgb&w=600', 'order' => 1, 'status' => true],
            ['title' => 'Creator Success', 'video_url' => 'https://images.pexels.com/photos/5077068/pexels-photo-5077068.jpeg?auto=compress&cs=tinysrgb&w=600', 'order' => 2, 'status' => true],
            ['title' => 'How it Works', 'video_url' => 'https://images.pexels.com/photos/5077069/pexels-photo-5077069.jpeg?auto=compress&cs=tinysrgb&w=600', 'order' => 3, 'status' => true],
        ];
        Video::truncate();
        foreach ($videos as $v) {
            Video::create($v);
        }

        // 6. FAQs
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
