<?php

namespace App\Providers;

use App\Models\Category;
use App\Support\Cart;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('navCategories', Category::active()->whereNull('parent_id')->orderBy('sira')->get());
            $view->with('cartCount', Cart::count());
            // Hizmet bölümü/linkleri yalnızca AKTİF hizmet varsa gösterilir.
            // Müşteri isteğiyle tüm hizmetler kaldırıldı; menüde ölü link ve
            // anasayfada başlıklı ama boş bir bölüm kalmasın diye koşullu.
            // Admin'den bir hizmet aktif edilirse her yer kendiliğinden geri gelir.
            $view->with('navHasServices', \App\Models\Service::active()->exists());
        });

        // Şifre sıfırlama e-postasını Türkçeleştir
        ResetPassword::toMailUsing(function ($notifiable, string $token) {
            $url = route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()]);

            return (new MailMessage)
                ->subject('Şifre Sıfırlama — ' . setting('site_adi'))
                ->greeting('Merhaba,')
                ->line('Hesabınız için şifre sıfırlama talebi aldık. Yeni şifre belirlemek için aşağıdaki butona tıklayın.')
                ->action('Şifremi Sıfırla', $url)
                ->line('Bu bağlantı ' . config('auth.passwords.users.expire', 60) . ' dakika içinde geçerliliğini yitirecektir.')
                ->line('Eğer bu talebi siz yapmadıysanız, herhangi bir işlem yapmanıza gerek yoktur.')
                ->salutation('Saygılarımızla, ' . setting('site_adi'));
        });
    }
}
