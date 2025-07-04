<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hinh_anh' => 'required|image|max:2048',
            'hien_thi' => 'boolean',
        ]);

        $image = $request->file('hinh_anh');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('uploads/banners'), $imageName);

        Banner::create([
            'hinh_anh' => 'uploads/banners/'.$imageName,
            'hien_thi' => $request->input('hien_thi', 0),
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'hinh_anh' => 'sometimes|image|max:2048',
            'hien_thi' => 'boolean',
        ]);

        $data = [
            'hien_thi' => $request->input('hien_thi', 0),
        ];

        if ($request->hasFile('hinh_anh')) {
            // Delete old image
            if ($banner->hinh_anh && file_exists(public_path($banner->hinh_anh))) {
                unlink(public_path($banner->hinh_anh));
            }
            
            // Store new image
            $image = $request->file('hinh_anh');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/banners'), $imageName);
            $data['hinh_anh'] = 'uploads/banners/'.$imageName;
        }

        $banner->update($data);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->hinh_anh && file_exists(public_path($banner->hinh_anh))) {
            unlink(public_path($banner->hinh_anh));
        }
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
}
