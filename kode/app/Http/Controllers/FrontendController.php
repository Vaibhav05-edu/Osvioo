<?php

namespace App\Http\Controllers;

use App\Models\Admin\Frontend;
use App\Models\Admin\Menu;
use App\Models\Admin\Page;
use App\Models\Blog;
use App\Models\Package;
use App\Models\Faq;
use App\Models\Story;
use App\Models\PlateformStat;
use App\Models\Creator;
use App\Models\Video;
use App\Models\LandingPageSetting;
use Illuminate\View\View;

class FrontendController extends Controller
{


    public $lastSegment;

    public function __construct()
    {
        $this->lastSegment = collect(request()->segments())->last();

    }
    /**
     * frontend view
     *
     * @return View
     */
    public function home($slug = null): View
    {
        $settings = LandingPageSetting::first();
        
        $faqs = Faq::where('is_active', true)
                    ->orderBy('order', 'asc')
                    ->get();
                    
        $stories = Story::where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();
        
        $stats = PlateformStat::where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();
        
        $creators = Creator::where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();
        
        $videos = Video::where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();

        return view('frontend.home', compact('settings', 'faqs', 'stories', 'stats', 'videos' , 'creators'));
    }



    /**
     * get all blogs
     *
     * @return View
     */
    public function blog(): View
    {

        $blogContent = get_content("content_blog")->first();

        $menu = Menu::where('url', $this->lastSegment)->active()->firstOrfail();


        return view('frontend.blogs', [
            'meta_data' => $this->metaData([
                "title" => $menu->meta_title,
                "meta_description" => $menu->meta_description,
                "meta_keywords" => (array) $menu->meta_keywords,
            ]),

            'blogs' => Blog::search(['title'])
                ->filter(['category:slug'])
                ->paginate(paginateNumber())
                ->appends(request()->all()),

            'menu' => $menu,

            'breadcrumbs' => ['Home' => 'home', "Blogs" => null],
            'banner' => (object) ['title' => @$blogContent->value->sub_title, 'description' => @$blogContent->value->description]
        ]);
    }




    /**
     * @param string $slug
     * @return View
     */
    public function blogDetails(string $slug): View
    {

        $blog = Blog::active()->where('slug', $slug)
            ->firstOrfail();

        $relatedBlogs = Blog::active()
            ->where("category_id", $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->take(6)
            ->get();

        $metaData = [
            "title" => $blog->meta_title,
            "og_image" => imageURL(@$blog->file, "blog", true),
            "img_size" => config("settings")['file_path']['blog']['size'],
            "meta_description" => $blog->meta_description,
            "meta_keywords" => (array) $blog->meta_keywords,
        ];

        return view('frontend.blog_details', [
            'meta_data' => $this->metaData($metaData),
            'blog' => $blog,
            'related_blogs' => $relatedBlogs,
            'breadcrumbs' => ['Home' => 'home', "Blogs" => 'blog', $blog->title => null],
            'banner' => (object) ['title' => $blog->title, 'description' => limit_words(strip_tags($blog->description), 100)]
        ]);

    }


    /**
     * @return View
     */
    public function plan(): View
    {

        $planContent = get_content("content_plan")->first();

        $menu = Menu::where('url', $this->lastSegment)->active()->firstOrfail();

        return view('frontend.plans', [
            'meta_data' => $this->metaData([
                "title" => $menu->meta_title,
                "meta_description" => $menu->meta_description,
                "meta_keywords" => (array) $menu->meta_keywords,
            ]),
            'menu' => $menu,
            "plans" => Package::active()->get(),
            'breadcrumbs' => ['Home' => 'home', "Plans" => null],
            'banner' => (object) ['title' => @$planContent->value->sub_title, 'description' => @$planContent->value->description]
        ]);
    }

    public function about(): View
    {


        $menu = Menu::where('url', $this->lastSegment)->active()->firstOrfail();


        return view('frontend.home', [
            'meta_data' => $this->metaData([
                "title" => $menu->meta_title,
                "meta_description" => $menu->meta_description,
                "meta_keywords" => (array) $menu->meta_keywords,
            ]),
            'menu' => $menu,
            'breadcrumbs' => ['Home' => 'home', "About" => null],
        ]);
    }

    public function affiliate(): View
    {
        $menu = Menu::where('url', 'affiliate')->active()->first() ?? (object)[
            'meta_title' => 'Affiliate Program',
            'meta_description' => 'Join our affiliate program and earn commission.',
            'meta_keywords' => []
        ];

        return view('frontend.affiliate', [
            'meta_data' => $this->metaData([
                "title" => $menu->meta_title,
                "meta_description" => $menu->meta_description,
                "meta_keywords" => (array) $menu->meta_keywords,
            ]),
            'menu' => $menu,
            'breadcrumbs' => ['Home' => 'home', "Affiliate" => null],
        ]);
    }


    /**
     * @param string $slug
     * @return View
     */
    public function page(string $slug): View
    {
        if ($slug === 'terms-and-conditions') {
            return view('frontend.terms_and_conditions', [
                'meta_data' => $this->metaData([
                    "title" => translate("Terms & Conditions"),
                    "meta_description" => translate("Osivoo Terms & Conditions - Read our service terms, account responsibilities, and Meta integration rules."),
                    "meta_keywords" => ["terms", "conditions", "terms of service", "osivoo terms"],
                ]),
                'breadcrumbs' => ['Home' => 'home', 'Terms & Conditions' => null],
                'banner' => (object) [
                    'title' => translate('Terms & Conditions'), 
                    'description' => translate('Please read our terms of service and acceptable platform use rules before using Osivoo.')
                ]
            ]);
        }

        if ($slug === 'privacy-policy') {
            return view('frontend.privacy_policy', [
                'meta_data' => $this->metaData([
                    "title" => translate("Privacy Policy"),
                    "meta_description" => translate("Osivoo Privacy Policy - Learn how we collect, use, and protect your personal information and social platform integrations under Meta guidelines."),
                    "meta_keywords" => ["privacy policy", "data security", "osivoo privacy"],
                ]),
                'breadcrumbs' => ['Home' => 'home', 'Privacy Policy' => null],
                'banner' => (object) [
                    'title' => translate('Privacy Policy'), 
                    'description' => translate('Your privacy is extremely important to us. Learn about our strict data handling, privacy compliance, and user safety standards.')
                ]
            ]);
        }

        if ($slug === 'data-deletion' || $slug === 'account-deletion') {
            return view('frontend.data_deletion', [
                'meta_data' => $this->metaData([
                    "title" => translate("Data Deletion Instructions"),
                    "meta_description" => translate("Instructions for requesting user data and account deletion under GDPR & Meta Platform rules."),
                    "meta_keywords" => ["data deletion", "delete account", "gdpr", "osivoo delete data"],
                ]),
                'breadcrumbs' => ['Home' => 'home', 'Data Deletion' => null],
                'banner' => (object) [
                    'title' => translate('Data Deletion Instructions'), 
                    'description' => translate('Clear, simple instructions on how to request deletion of your account and personal data from our platform.')
                ]
            ]);
        }

        $page = Page::active()->where('slug', $slug)
            ->firstOrfail();

        $metaData = [
            "title" => $page->meta_title,
            "meta_description" => $page->meta_description,
            "meta_keywords" => (array) $page->meta_keywords,
        ];

        return view('frontend.page', [
            'meta_data' => $this->metaData($metaData),
            'page' => $page,
            'breadcrumbs' => ['Home' => 'home', $page->title => null],
            'banner' => (object) ['title' => $page->title, 'description' => limit_words(strip_tags($page->description), 100)]
        ]);
    }


    /**
     * @param string $slug
     * @param string $uid
     * @return View
     */
    public function integration(string $slug, string $uid): View
    {

        $section = Frontend::active()->where('uid', $uid)
            ->firstOrfail();
        return view('frontend.integration', [
            'meta_data' => $this->metaData(["title" => $section->value->title]),
            'section' => $section,
            'breadcrumbs' => ['Home' => 'home', $section->value->title => null],
            'banner' => (object) ['title' => @$section->value->title, 'description' => limit_words(strip_tags(@$section->value->short_description), 100)]
        ]);
    }

    /**
     * @param string $slug
     * @param string $uid
     * @return View
     */
    public function service(string $slug, string $uid): View
    {
        $service = Frontend::active()->where('uid', $uid)->firstOrfail();
        return view('frontend.service', [
            'meta_data' => $this->metaData(["title" => $service->value->title]),
            'service' => $service,
            'breadcrumbs' => ['Home' => 'home', $service->value->title => null],
            'banner' => (object) ['title' => @$service->value->title, 'description' => limit_words(strip_tags(@$service->value->description), 100)]
        ]);
    }

}
