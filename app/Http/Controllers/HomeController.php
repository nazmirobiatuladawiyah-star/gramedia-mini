<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPackage;
use App\Models\Book;
use App\Models\BookCategory;

class HomeController extends Controller
{
    public function index()
    {
        $freeBooks = Book::where('price', 0)->latest()->take(10)->get();

        $subscriptionPackages = SubscriptionPackage::latest()->take(3)->get();

        $latestBooks = Book::latest()->take(10)->get();

        $categories = BookCategory::all();

        return view('home', compact('subscriptionPackages', 'latestBooks', 'freeBooks', 'categories'));
    }
}
