<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $books = Book::all();
        $user = Auth::user();
        return view('page.dashboard', compact('user', 'books'));
    }
}
