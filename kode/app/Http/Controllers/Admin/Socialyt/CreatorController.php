<?php

namespace App\Http\Controllers\Admin\Socialyt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Creator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CreatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creators = Creator::orderBy('order', 'asc')->paginate(20);
        return view('dashboard.creator.index', compact('creators'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.creator.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'username'     => 'required|string|max:255',
                'followers'    => 'required|string|max:255',
                'profile_pic'  => 'required|image|max:1024',
                'order'        => 'nullable|integer',
            ]);

            if ($request->hasFile('profile_pic')) {
                $validated['profile_pic'] = $request->file('profile_pic')->store('creators', 'public');
            }

            $validated['status'] = $request->has('status') ? 1 : 0;

            Creator::create($validated);

            return redirect()
                ->route('socialyt-admin.creator.index')
                ->with('success', 'Creator added successfully!');

        } catch (\Exception $e) {

            Log::error('Creator Store Error: ' . $e->getMessage());

            return back()
                ->with('error', 'Something went wrong while adding creator.')
                ->withInput();
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
    public function edit(Creator $creator)
    {
        try {
            return view('dashboard.creator.edit', compact('creator'));
        } catch (\Exception $e) {

            Log::error('Creator Edit Error: ' . $e->getMessage());

            return redirect()
                ->route('socialyt-admin.creator.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request,String $id)
    {
        try {
       

            $validated = $request->validate([
                'username'     => 'required|string|max:255',
                'followers'    => 'required|string|max:255',
                'profile_pic'  => 'nullable|image|max:1024',
                'order'        => 'nullable|integer',
            ]);

       

            $creator = Creator::findOrFail($id);

            if ($request->hasFile('profile_pic')) {

                if ($creator->profile_pic) {
                    Storage::disk('public')->delete($creator->profile_pic);
                }

                $validated['profile_pic'] = $request->file('profile_pic')->store('creators', 'public');
            }

            $validated['status'] = $request->has('status') ? 1 : 0;

            $creator->update($validated);

            return redirect()
                ->route('socialyt-admin.creator.index')
                ->with('success', 'Creator updated successfully!');

        } catch (\Exception $e) {

            Log::error('Creator Update Error: ' . $e->getMessage());

            return back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Creator $creator)
    {
        try {

            if ($creator->profile_pic) {
                Storage::disk('public')->delete($creator->profile_pic);
            }

            $creator->delete();

            return back()->with('success', 'Creator deleted successfully!');

        } catch (\Exception $e) {

            Log::error('Creator Delete Error: ' . $e->getMessage());

            return back()->with('error', 'Something went wrong while deleting creator.');
        }
    }
}
