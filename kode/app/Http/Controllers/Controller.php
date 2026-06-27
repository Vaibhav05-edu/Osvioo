<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
     * prepare meta data
     *
     * @param array $customData
     * @return array
     */
    public function metaData( array $customData = [], ) :array {

        try {
            [$width, $height] = explode('x', Arr::get($customData, "img_size", config("settings")['file_path']['meta_image']['size'] ?? '1200x630'));

            $ogImage = Arr::get($customData, "og_image");
            if (!$ogImage) {
                try {
                    $ogImage = imageURL(@site_logo('meta_image')?->file, "meta_image", true);
                } catch (\Throwable $e) {
                    $ogImage = null;
                }
            }

            $metaDescription = Arr::get($customData, "meta_description");
            if (!$metaDescription) {
                try {
                    $metaDescription = @site_settings("site_description");
                } catch (\Throwable $e) {
                    $metaDescription = null;
                }
            }

            $metaKeywords = Arr::get($customData, "keywords");
            if (!$metaKeywords) {
                try {
                    $metaKeywords = json_decode(site_settings('site_meta_keywords'), true);
                } catch (\Throwable $e) {
                    $metaKeywords = [];
                }
            }

            return [
                'title'            => Arr::get($customData,"title") ?? trans("default.home"),
                'og_type'          => Arr::get($customData,"og_type", 'website'),
                'og_image'         => $ogImage,
                'og_image_type'    => "image/png",
                'og_image_width'   => $width ?? '1200',
                'og_image_height'  => $height ?? '630',
                'twitter_card'     => Arr::get($customData,"twitter_card", 'summary'),
                'robots'           => Arr::get($customData,"robots", 'follow'),
                'meta_description' => $metaDescription,
                "meta_keywords"    => $metaKeywords,
            ];
        } catch (\Throwable $e) {
            // Safe fallback if DB is completely unavailable
            return [
                'title'            => Arr::get($customData,"title", 'Osvioo'),
                'og_type'          => 'website',
                'og_image'         => null,
                'og_image_type'    => "image/png",
                'og_image_width'   => '1200',
                'og_image_height'  => '630',
                'twitter_card'     => 'summary',
                'robots'           => 'follow',
                'meta_description' => null,
                "meta_keywords"    => [],
            ];
        }

    }


}
