<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.cms.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.cms.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);

        $path = $request->file('thumbnail')->store('news-thumbnails', 'public');

        News::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'thumbnail' => $path,
            'content' => $request->content,
            'status' => $request->status,
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.cms.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);

        $news->title = $request->title;
        $news->content = $request->content;
        $news->status = $request->status;

        if ($request->status === 'published' && !$news->published_at) {
            $news->published_at = now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail && Storage::disk('public')->exists($news->thumbnail)) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $news->thumbnail = $request->file('thumbnail')->store('news-thumbnails', 'public');
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->thumbnail && Storage::disk('public')->exists($news->thumbnail)) {
            Storage::disk('public')->delete($news->thumbnail);
        }
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }
}
