<?php

namespace App\Http\Controllers\Admin\Socialyt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\PlateformStat as Stat;

class PlatformStatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $stats = Stat::orderBy('order', 'asc')->paginate(10);
        return view('dashboard.stats.index', compact('stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dashboard.stats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|max:2048'
        ]);

        $data = $request->all();
        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('stats', 'public');
        }
        $data['status'] = $request->has('status') ? 1 : 0;
        
        Stat::create($data);
        return redirect()->route('socialyt-admin.stats.index')->with('success', 'Stat created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $stat = Stat::findOrFail($id);
        if (!$stat) {
            return back()->with('error', 'Stat not found!');
        }
        return view('dashboard.stats.edit', compact('stat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stat $stat)
    {
        try {

            $data = $request->all();

            // Image upload
            if ($request->hasFile('image')) {

                // old image delete
                if ($stat->image) {
                    Storage::disk('public')->delete($stat->image);
                }

                $data['image'] = $request->file('image')->store('stats', 'public');
            }

            $data['status'] = $request->has('status') ? 1 : 0;

            $stat->update($data);

            return redirect()
                ->route('socialyt-admin.stats.index')
                ->with('success', 'Stat updated successfully!');

        } catch (\Exception $e) {

            Log::error('Stat Update Error: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while updating stat.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stat $stat)
    {
        try {

            if ($stat->image) {
                Storage::disk('public')->delete($stat->image);
            }

            $stat->delete();

            return back()->with('success', 'Stat deleted successfully!');

        } catch (\Exception $e) {

            Log::error('Stat Delete Error: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting stat.');
        }
    }
}
