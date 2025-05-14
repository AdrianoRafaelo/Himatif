<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\Proposal;
use App\Models\Proker;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $events = Event::with('proker')->latest()->take(5)->get();
        $approvedProposals = Proposal::with('proker')->where('status', 'approved')->latest()->take(5)->get();
        $news = News::latest()->take(5)->get();
        $prokers = Proker::latest()->get();

        return view('admin.dashboard', compact('events', 'approvedProposals', 'news', 'prokers'));
    }
}