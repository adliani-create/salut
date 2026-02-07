<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingItemController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->query('section', 'advantage');
        $items = LandingItem::where('section', $section)
                            ->orderBy('order_index')
                            ->orderBy('id')
                            ->paginate(10)
                            ->appends(['section' => $section]);
        
        $sectionLabels = [
            'advantage' => 'Kelebihan Eksklusif',
            'service' => 'Layanan',
            'skill' => 'Skill & Keahlian',
            'study' => 'Pilihan Studi',
        ];

        return view('admin.cms.landing_items.index', compact('items', 'section', 'sectionLabels'));
    }

    public function create(Request $request)
    {
        $section = $request->query('section', 'advantage');
        return view('admin.cms.landing_items.create', compact('section'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('landing_items', 'public');
        }

        LandingItem::create($data);

        return redirect()->route('admin.landing-items.index', ['section' => $request->section])
                         ->with('success', 'Item berhasil ditambahkan.');
    }

    public function edit(LandingItem $landingItem)
    {
        return view('admin.cms.landing_items.edit', compact('landingItem'));
    }

    public function update(Request $request, LandingItem $landingItem)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($landingItem->image && Storage::disk('public')->exists($landingItem->image)) {
                Storage::disk('public')->delete($landingItem->image);
            }
            $data['image'] = $request->file('image')->store('landing_items', 'public');
        }

        $landingItem->update($data);

        return redirect()->route('admin.landing-items.index', ['section' => $landingItem->section])
                         ->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy(LandingItem $landingItem)
    {
        $section = $landingItem->section;
        if ($landingItem->image && Storage::disk('public')->exists($landingItem->image)) {
            Storage::disk('public')->delete($landingItem->image);
        }
        $landingItem->delete();

        return redirect()->route('admin.landing-items.index', ['section' => $section])
                         ->with('success', 'Item berhasil dihapus.');
    }
}
