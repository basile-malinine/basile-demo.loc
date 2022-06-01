<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Database\QueryException;

class HomeController extends Controller {
    public function index() {
        if (session()->exists('offset') && session()->exists('offset')) {
            session(['reload' => true]);
        } else {
            session(['reload' => false]);
            session(['offset' => 0]);
            session(['limit' => 3]);
        }

        // Проверяем доступ к MySQL
        try {
            Comment::query()->count();
            return view('home');
        }
        catch (QueryException $e) {
            return view('err-base');
        }
    }
}
