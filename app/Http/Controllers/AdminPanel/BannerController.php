<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::where('destroy', 0)->orderBy('order')->get();
        return view('admin-panel.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-panel.banner.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        $banner_img = null;
        if ($request->hasFile('image')) {
            $file = $request->image;
            $banner_img = time() . $file->getClientOriginalName();
            $file->storeAs('public/uploads/banner', $banner_img);
        }

        $maxOrder = Banner::max('order');
        $newOrder = ($maxOrder === null) ? 1 : $maxOrder + 1;
        Banner::create([
            'image' => $banner_img,
            "order" => $newOrder,
        ]);
        return redirect()->route('admin.banner.index')->with('store_message', 'Uğurla əlavə edildi');
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
        $banner = Banner::findOrFail($id);
        return view('admin-panel.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, string $id)
    {
        $banner = Banner::findOrFail($id);
        if ($request->hasFile('image')) {
            $file = $request->image;
            $banner_img = time() . $file->getClientOriginalName();
            $file->storeAs('public/uploads/banner', $banner_img);

            $banner->image = $banner_img;
        }
        $banner->save();
        return redirect()->route('admin.banner.index')->with('update_message', 'Dəyişikliklər uğurla yadda saxlanıldı');
    }

    public function sort(Request $request)
    {
        $order_data = $request['data'];
        try {
            DB::beginTransaction();

            foreach ($order_data as $data) {
                Banner::where('id', $data['id'])->update(['order' => $data['order']]);
            }

            DB::commit();

            return response()->json('sort_success', 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->destroy = 1;
        $banner->save();
        return redirect()->route('admin.banner.index')->with('delete_message', 'Uğurla silindi');
    }
}
