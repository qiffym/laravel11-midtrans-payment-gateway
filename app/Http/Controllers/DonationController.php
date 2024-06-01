<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(): View
    {
        $donations = Donation::query()->latest()->paginate(8);
        return view('welcome', [
            'donations' => $donations,
        ]);
    }
    public function create(): View
    {
        return view('donation');
    }
}
