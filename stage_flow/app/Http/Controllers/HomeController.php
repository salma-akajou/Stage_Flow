<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = auth()->user()->getRoleNames()->first();
        
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'etudiant' => redirect('/student/dashboard'),
            'entreprise' => redirect()->route('entreprise.dashboard'),
            default => view('home'),
        };
    }
}
