<?php

namespace App\Helpers;

use App\Models\Language;
use App\Models\LanguageString;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class CacheClearHelper
{
    public static function languageCacheClear()
    {
        if (Cache::has('languages')) {
            Cache::forget('languages');
        }
    }

    public static function getLanguageStringCatch($catch_name, $locale): array
    {
        if (Cache::has($locale . '_' . $catch_name)) {
            return Cache::get($locale . '_' . $catch_name);
        }

        $array = [];
        if ($catch_name == 'admin_string') {
            $languageStrings = LanguageString::get();
            foreach ($languageStrings as $languageString) {
                $array[$languageString->name_key] = $languageString->name;
            }
        } else if ($catch_name == 'api_string') {
            $languageStrings = LanguageString::whereHas('language_screen', function ($query) {
                $query->where('app_or_panel', 1);
            })->get();
            foreach ($languageStrings as $languageString) {
                $array[$languageString->name_key] = $languageString->name;
            }
        } else if ($catch_name == 'web_string') {
            $languageStrings = LanguageString::whereHas('language_screen', function ($query) {
                $query->where('app_or_panel', 2);
            })->get();
            foreach ($languageStrings as $languageString) {
                $array[$languageString->name_key] = $languageString->name;
            }
        } else if ($catch_name == 'admin_display_string') {
            $languageStrings = LanguageString::with('languageScreen')->get();

            foreach ($languageStrings as $languageString) {
                if ($languageString->languageScreen) {
                    $array[] = [
                        'id' => $languageString->id,
                        'app_or_panel' => $languageString->languageScreen->app_or_panel,
                        'screen_name' => $languageString->languageScreen->name,
                        'name_key' => $languageString->name_key,
                        'en_value' => $languageString->translateOrNew('en')->name,
                        'ar_value' => $languageString->translateOrNew('ar')->name
                    ];
                }
            }
        }
        Cache::forever($locale . '_' . $catch_name, $array);
        return $array;
    }

    public static function getDebugLanguageStringCatch($catch_name, $locale): array
    {
        if (Cache::has($locale . '_' . $catch_name)) {
            return Cache::get($locale . '_' . $catch_name);
        }

        $array = [];
        if ($catch_name == 'debug_admin_string') {
            $languageStrings = LanguageString::get();
            foreach ($languageStrings as $languageString) {
                $array[$languageString->name_key] = $languageString->name . '_' . $languageString->id;
            }
        } else if ($catch_name == 'debug_api_string') {
            $languageStrings = LanguageString::whereHas('language_screen', function ($query) {
                $query->where('app_or_panel', 1);
            })->get();

            foreach ($languageStrings as $languageString) {
                $array[$languageString->name_key] = $languageString->name . '_' . $languageString->id;
            }

        } else if ($catch_name == 'debug_web_string') {
            $languageStrings = LanguageString::whereHas('language_screen', function ($query) {
                $query->where('app_or_panel', 2);
            })->get();
            foreach ($languageStrings as $languageString) {
                $array[$languageString->name_key] = $languageString->name . '_' . $languageString->id;
            }
        } else if ($catch_name == 'admin_display_string') {
            $languageStrings = LanguageString::with('languageScreen')->get();

            foreach ($languageStrings as $languageString) {
                if ($languageString->languageScreen) {
                    $array[] = [
                        'id' => $languageString->id,
                        'app_or_panel' => $languageString->languageScreen->app_or_panel,
                        'screen_name' => $languageString->languageScreen->name,
                        'name_key' => $languageString->name_key,
                        'en_value' => $languageString->translateOrNew('en')->name,
                        'ar_value' => $languageString->translateOrNew('ar')->name
                    ];
                }
            }
        }
        Cache::forever($locale . '_' . $catch_name, $array);
        return $array;
    }

    public static function languageStringCacheClear()
    {
        $array = self::getLanguageCatch('admin_language');

        foreach ($array as $value) {
            Cache::forget($value['language_code'] . '_api_string');
            Cache::forget($value['language_code'] . '_web_string');
            Cache::forget($value['language_code'] . '_admin_string');
            Cache::forget($value['language_code'] . '_admin_display_string');

            Cache::forget($value['language_code'] . '_debug_api_string');
            Cache::forget($value['language_code'] . '_debug_web_string');
            Cache::forget($value['language_code'] . '_debug_admin_string');
        }
    }

    public static function getLanguageCatch($catch_name): array
    {
        if (Cache::has($catch_name)) {
            return Cache::get($catch_name);
        }

        $array = [];

        if ($catch_name == 'admin_language') {
            $languages = Language::get();

            foreach ($languages as $language) {
                $array[] = [
                    'id' => $language->id,
                    'name' => $language->name,
                    'is_rtl' => $language->is_rtl,
                    'language_code' => $language->language_code,
                    'status' => $language->status,
                ];
            }
        } else {
            $languages = Language::where('status', 'active')->get();
            foreach ($languages as $language) {
                $array[] = [
                    'id' => $language->id,
                    'name' => $language->name,
                    'is_rtl' => $language->is_rtl,
                    'language_code' => $language->language_code,
                    'status' => $language->status,
                ];
            }
        }
        Cache::forever($catch_name, $array);
        return $array;
    }
}
