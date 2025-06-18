<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'password' => bcrypt(uniqid()) // كلمة مرور عشوائية
                ]
            );

            Auth::login($user);

            return redirect('/dashboard'); // عدّل حسب مسار لوحة التحكم عندك

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['login' => 'فشل تسجيل الدخول باستخدام ' . $provider]);
        }
    }
}
