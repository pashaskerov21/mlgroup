<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCategoryRequest;
use App\Models\Menu;
use App\Models\ProjectCategories;
use App\Models\ProjectCategoryTranslate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProjectCategories::where('destroy', 0)->orderBy('order')->get();
        return view('admin-panel.project-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menues = Menu::where('destroy', 0)->orderBy('order')->get();
        return view('admin-panel.project-categories.add', compact('menues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectCategoryRequest $request)
    {
        $headerStatus = 0;
        if($request->header_status){
            $headerStatus = 1;
        }
        $maxOrder = ProjectCategories::max('order');
        $newOrder = ($maxOrder === null) ? 1 : $maxOrder + 1;
        $category_id = ProjectCategories::create([
            'header_status' => $headerStatus,
            "order" => $newOrder,
        ])->id;
        for ($i = 0; $i < count($request->lang); $i++) {
            ProjectCategoryTranslate::create([
                'category_id' => $category_id,
                'title' => $request['title'][$i],
                'slug' => Str::slug($request['title'][$i]),
                'lang' => $request['lang'][$i],
            ]);
        };
        return redirect()->route('admin.project-categories.index')->with('store_message', 'Uğurla əlavə edildi');
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
        $category = ProjectCategories::findOrFail($id);
        $menues = Menu::where('destroy', 0)->orderBy('order')->get();
        return view('admin-panel.project-categories.edit', compact(['category', 'menues']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectCategoryRequest $request, string $id)
    {
        $category = ProjectCategories::findOrFail($id);
        $headerStatus = 0;
        if($request->header_status){
            $headerStatus = 1;
        }
        $category->header_status = $headerStatus;
        $category->save();

        for ($i = 0; $i < count($request->lang); $i++) {
            ProjectCategoryTranslate::where(['category_id' => $id, 'lang' => $request['lang'][$i]])->update([
                'title' => $request['title'][$i],
                'slug' => Str::slug($request['title'][$i]),
                'lang' => $request['lang'][$i],
            ]);
        }
        return redirect()->route('admin.project-categories.index')->with('update_message', 'Dəyişikliklər uğurla yadda saxlanıldı');
    }

    public function sort(Request $request)
    {
        $order_data = $request['data'];
        try {
            DB::beginTransaction();

            foreach ($order_data as $data) {
                ProjectCategories::where('id', $data['id'])->update(['order' => $data['order']]);
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
        $category = ProjectCategories::findOrFail($id);
        $category->destroy = 1;
        if ($category->header_status == 1) {
            $mainMenu = Menu::findOrFail($category->parent_id);
            $mainMenu->parent = $mainMenu->parent - 1;
            $mainMenu->save();
        }
        $category->save();
        return redirect()->route('admin.project-categories.index')->with('delete_message','Uğurla silindi');
    }
}
