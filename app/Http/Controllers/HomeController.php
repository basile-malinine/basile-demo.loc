<?php

    namespace App\Http\Controllers;

    use App\Models\Comment;

    class HomeController extends Controller
    {
        public function index() {
            if (session()->exists('offset') && session()->exists('offset')) {
                session(['reload' => true]);
            } else {
                session(['reload' => false]);
                session(['offset' => 0]);
                session(['limit' => 3]);
            }

            $pdo = Comment::query()->count();
            return view('home');
        }
    }
