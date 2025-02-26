<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PartTimerPortfolioController extends Controller
{
    public function show()
    {
        $portfolio = DB::table('part_timer_portfolios')->where('user_id', Auth::id())->first();
        return view('part-timers.portfolios.show', compact('portfolio'));
    }

    public function edit()
    {
        $portfolio = DB::table('part_timer_portfolios')->where('user_id', Auth::id())->first();
        return view('part-timers.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'work_experience' => 'nullable|string|max:2000',
            'work_photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $portfolio = DB::table('part_timer_portfolios')->where('user_id', Auth::id())->first();

        $work_photos = json_decode($portfolio->work_photos ?? '[]', true);

        if ($request->hasFile('work_photos')) {
            foreach ($request->file('work_photos') as $photo) {
                $path = $photo->store('portfolio_photos', 'public');
                $work_photos[] = $path;
            }
        }

        DB::table('part_timer_portfolios')->where('user_id', Auth::id())->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'location' => $request->location,
            'bio' => $request->bio,
            'work_experience' => $request->work_experience,
            'work_photos' => json_encode($work_photos),
        ]);

        return redirect()->route('portfolio.show', ['id' => Auth::id()])->with('success', 'Portfolio updated successfully!');
    }
}
