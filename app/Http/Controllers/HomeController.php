<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'featured'     => Product::active()->where('featured', true)->latest()->take(8)->get(),
            'newProducts'  => Product::active()->latest()->take(8)->get(),
            'categories'   => Category::active()->whereNull('parent_id')->orderBy('sira')->get(),
            'services'     => Service::active()->orderBy('sira')->get(),
            'posts'        => Post::active()->latest('tarih')->take(3)->get(),
            'testimonials' => Testimonial::active()->latest()->take(3)->get(),
        ]);
    }
}
