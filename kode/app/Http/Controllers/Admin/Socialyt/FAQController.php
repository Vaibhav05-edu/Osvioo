<?php

namespace App\Http\Controllers\Admin\Socialyt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Har page par 10 records aayenge
        $faqs = Faq::paginate(10);

        return view('dashboard.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'question' => 'required|string|max:255',
                'answer'   => 'required|string',
                'fb_link'  => 'nullable|url',
                'x_link'   => 'nullable|url',
                'linkedin_link' => 'nullable|url',
                'website_link'  => 'nullable|url',
                'order'    => 'nullable|integer',
            ]);

            DB::beginTransaction();

            Faq::create([
                'question'      => $validated['question'],
                'answer'        => $validated['answer'],
                'fb_link'       => $validated['fb_link'] ?? null,
                'x_link'        => $validated['x_link'] ?? null,
                'linkedin_link' => $validated['linkedin_link'] ?? null,
                'website_link'  => $validated['website_link'] ?? null,
                'order'         => $validated['order'] ?? 0,
                'is_active'     => $request->has('is_active') ? 1 : 0,
            ]);

            DB::commit();

            return redirect()
                ->route('socialyt-admin.faq.index')
                ->with('success', 'FAQ created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors automatically redirect, but keeping for clarity
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error for debugging
            Log::error('FAQ Store Error: ' . $e->getMessage());

            return back()
                ->with('error', 'Something went wrong. Please try again.')
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
    public function edit($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return redirect()
                ->route('socialyt-admin.faq.index')
                ->with('error', 'FAQ not found.');
        }

        return view('dashboard.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id)
    {
        try {

            $faq = Faq::findOrFail($id);

            $validated = $request->validate([
                'question' => 'required|string|max:255',
                'answer'   => 'required|string',
                'fb_link'  => 'nullable|url',
                'x_link'   => 'nullable|url',
                'linkedin_link' => 'nullable|url',
                'website_link'  => 'nullable|url',
                'order'    => 'nullable|integer',
            ]);

            DB::beginTransaction();

            $faq->update([
                'question'      => $validated['question'],
                'answer'        => $validated['answer'],
                'fb_link'       => $validated['fb_link'] ?? null,
                'x_link'        => $validated['x_link'] ?? null,
                'linkedin_link' => $validated['linkedin_link'] ?? null,
                'website_link'  => $validated['website_link'] ?? null,
                'order'         => $validated['order'] ?? 0,
                'is_active'     => $request->has('is_active') ? 1 : 0,
            ]);

            DB::commit();

            return redirect()
                ->route('socialyt-admin.faq.index')
                ->with('success', 'FAQ updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {

            return back()->withErrors($e->errors())->withInput();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return redirect()
                ->route('socialyt-admin.faq.index')
                ->with('error', 'FAQ not found.');

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('FAQ Update Error: ' . $e->getMessage());

            return back()
                ->with('error', 'Something went wrong while updating FAQ.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return redirect()
                ->route('socialyt-admin.faq.index')
                ->with('error', 'FAQ not found.');
        }

        $faq->delete();

        return redirect()
            ->route('socialyt-admin.faq.index')
            ->with('success', 'FAQ deleted successfully!');
    }
}
