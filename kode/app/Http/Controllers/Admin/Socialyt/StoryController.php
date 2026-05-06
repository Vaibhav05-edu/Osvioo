<?php

namespace App\Http\Controllers\Admin\Socialyt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Facades\Storage;
use Exception;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Stories ko pagination ke saath fetch karein (per page 10 items)
        // Aap paginate(10) ki jagah apni marzi ka number rakh sakte hain
        $stories = Story::orderBy('order', 'asc')->paginate(10);

        // Dashboard index view par data bhejien
        return view('dashboard.story.index', compact('stories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('dashboard.story.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB Max
            'order'       => 'nullable|integer',
        ]);

        try {
            $data = $request->except('image');

            // 2. Handle Image Upload
            if ($request->hasFile('image')) {
                // Image ko 'public/stories' folder mein save karega
                $imagePath = $request->file('image')->store('stories', 'public');
                $data['image'] = $imagePath;
            }

            // 3. Set Status (Switch checkbox handle karne ke liye)
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['order']  = $request->order ?? 0;

            // 4. Database mein Save karein
            Story::create($data);

            return redirect()->route('socialyt-admin.story.index')
                            ->with('success', 'Story created successfully!');

        } catch (Exception $e) {
            // 5. Exception Handling
            // Agar image upload ho gayi thi par DB save fail hua, toh image delete kar dena behtar hai
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Something went wrong: ' . $e->getMessage());
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
        try {

            $story = Story::findOrFail($id);
            return view('dashboard.story.edit', compact('story'));
        } catch (Exception $e) {
            return redirect()->route('socialyt-admin.story.index')
                            ->with('error', 'Story not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validation
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order'       => 'nullable|integer',
        ]);

        try {
            $story = Story::findOrFail($id);
            $data = $request->except('image');

            // 2. Handle Image Update
            if ($request->hasFile('image')) {
                // Purani image delete karein agar exist karti hai
                if ($story->image && Storage::disk('public')->exists($story->image)) {
                    Storage::disk('public')->delete($story->image);
                }

                // Nayi image upload karein
                $imagePath = $request->file('image')->store('stories', 'public');
                $data['image'] = $imagePath;
            }

            // 3. Set Status & Order
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['order']  = $request->order ?? 0;

            // 4. Update Database
            $story->update($data);

            return redirect()->route('socialyt-admin.story.index')
                            ->with('success', 'Story updated successfully!');

        } catch (Exception $e) {
            // Agar DB update fail ho aur nayi image upload ho gayi ho, toh use saaf karein
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // 1. Record find karein
            $story = Story::findOrFail($id);

            // 2. Image Delete (Agar storage mein exist karti hai)
            if ($story->image && Storage::disk('public')->exists($story->image)) {
                Storage::disk('public')->delete($story->image);
            }

            // 3. Database se record delete karein
            $story->delete();

            return redirect()->route('socialyt-admin.story.index')
                            ->with('success', 'Story and associated image deleted successfully!');

        } catch (Exception $e) {
            return redirect()->route('socialyt-admin.story.index')
                            ->with('error', 'Error: Could not delete the story. ' . $e->getMessage());
        }
    }
}
