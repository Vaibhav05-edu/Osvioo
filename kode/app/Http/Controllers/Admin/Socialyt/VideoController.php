<?php

namespace App\Http\Controllers\Admin\Socialyt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::orderBy('order', 'asc')->paginate(12);
        return view('dashboard.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dashboard.video.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {

            $validated = $request->validate([
                'title'       => 'nullable|string|max:100',
                'video_url'   => 'required|url',
                'thumbnail'   => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
                'order'       => 'nullable|integer',
            ]);

            if ($request->hasFile('thumbnail')) {
                $validated['thumbnail'] = $request->file('thumbnail')->store('videos/thumbs', 'public');
            }

            $validated['status'] = $request->has('status') ? 1 : 0;
            $validated['order'] = $validated['order'] ?? 0;

            Video::create($validated);

            return redirect()
                ->route('socialyt-admin.video.index')
                ->with('success', 'Video added successfully!');

        } catch (Exception $e) {

            Log::error('Video Store Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', $e->getMessage() ?: 'Failed to add video. Try again.');
        }
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        try {

            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }

            $video->delete();

            return back()->with('success', 'Video removed successfully!');

        } catch (Exception $e) {

            Log::error('Video Delete Error: ' . $e->getMessage());

            return back()->with('error', 'Delete failed. Try again.');
        }
    }
}
