<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'services'     => Service::active()->orderBy('sira')->get(),
            'testimonials' => Testimonial::active()->latest()->take(3)->get(),
        ]);
    }

    public function services()
    {
        return view('pages.services', ['services' => Service::active()->orderBy('sira')->get()]);
    }

    /**
     * Markalar sayfası — sitedeki tüm markaları tek listede gösterir.
     * Her marka mağazadaki filtreli listesine (?marka=X) gider.
     */
    public function brands()
    {
        return view('pages.brands', [
            'brands' => \App\Models\Product::markaListesi(),
        ]);
    }

    public function serviceShow(Service $service)
    {
        abort_unless($service->durum, 404);
        return view('pages.service-show', [
            'service' => $service,
            'others'  => Service::active()->where('id', '<>', $service->id)->orderBy('sira')->take(6)->get(),
        ]);
    }

    public function blog()
    {
        return view('pages.blog', ['posts' => Post::active()->latest('tarih')->paginate(9)]);
    }

    public function blogShow(Post $post)
    {
        abort_unless($post->durum, 404);
        return view('pages.blog-show', [
            'post'   => $post,
            'others' => Post::active()->where('id', '<>', $post->id)->latest('tarih')->take(4)->get(),
        ]);
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:120',
            'email'   => 'nullable|email|max:120',
            'phone'   => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:160',
            'message' => 'required|string|max:2000',
        ]);

        $message = ContactMessage::create($data);

        try {
            if ($adminMail = setting('eposta')) {
                Mail::to($adminMail)->send(new ContactMessageMail($message));
            }
        } catch (\Throwable $e) {
            Log::error('İletişim maili gönderilemedi', ['err' => $e->getMessage()]);
        }

        return back()->with('success', 'Mesajınız alındı. En kısa sürede size dönüş yapacağız.');
    }

    public function appointment(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:120',
            'date'  => 'nullable|date',
            'time'  => 'nullable|string|max:20',
            'note'  => 'nullable|string|max:1000',
        ]);

        Appointment::create($data);

        return back()->with('success', 'Randevu talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.');
    }
}
