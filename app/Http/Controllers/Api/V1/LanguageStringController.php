<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\LanguageStringResource;
use DB;
use Illuminate\Support\Facades\App;
use App\Helpers\CacheClearHelper;
use App\Models\Nationality;
use App\Models\PaymentGatewaySetting;
use App\Models\Setting;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NationalityResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class LanguageStringController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->header('Accept-Language');
        if ($locale === 'en-US') {
            $locale = 'en';
            App::setLocale('en');
        } else {
            $locale = 'ar';
            App::setLocale('ar');
        }
        $isDebug = DB::table('settings')->where('meta_key', 'is_debug_mode')->first()->meta_value;
        if ((int)$isDebug === 0) {
            $languageStrings = CacheClearHelper::getLanguageStringCatch('api_string', $locale);
        } else {
            $languageStrings = CacheClearHelper::getDebugLanguageStringCatch('debug_api_string', $locale);
        }

        if (count($languageStrings) > 0) {
            return response()->json([
                'data' => $languageStrings,
            ]);
        }

        return response()->json(['message' => 'No Language Sting Found'], 422);
    }

    public function getActiveNationalities(Request $request)
    {
        $locale = $request->header('Accept-Language');
        if ($locale === 'en-US') {
            App::setLocale('en');
        } else {
            App::setLocale('ar');
        }
        $nationalities = Nationality::where('status', 'Active')->get();
        return response()->json([
            'data' => NationalityResource::collection($nationalities),
        ]);
    }
}
