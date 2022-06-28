<?php
namespace App\Services;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Models\Social;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class SocialAccountService
{
    public static function createOrGetUser(ProviderUser $providerUser, $social)
    {
        $account = Social::whereProvider($social)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $email = $providerUser->getEmail() ?? $providerUser->getNickname();
            $account = new Social([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $social
            ]);
       
            $user = User::whereEmail($email)->first();

            if (!$user) {

                $user = User::create([
                    'email' => $email,
                    'username' => $providerUser->getName(),
                    'wallet'=>'0',
                    'status'=>'1',
                    'token'=>strtoupper(Str::random(12)),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}