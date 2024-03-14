<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\VacancyRequest;
use App\Models\Vacancy;
use App\Models\VacancyTranslate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vacancies = Vacancy::where('destroy',0)->orderBy('order')->get();
        return view('admin-panel.vacancy.index',compact('vacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-panel.vacancy.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VacancyRequest $request)
    {
        $maxOrder = Vacancy::max('order');
        $newOrder = ($maxOrder === null) ? 1 : $maxOrder + 1;
        $vacancy_id = Vacancy::create([
            "order" => $newOrder,
        ])->id;
        for($i = 0; $i < count($request->lang); $i++){
            VacancyTranslate::create([
                'vacancy_id' => $vacancy_id,
                'title' => $request['title'][$i],
                'slug' => Str::slug($request['title'][$i]),
                'text' => $request['text'][$i],
                'lang' => $request['lang'][$i],
            ]);
        };
        return redirect()->route('admin.vacancy.index')->with('store_message', 'Uğurla əlavə edildi');
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
        $vacancy = Vacancy::findOrFail($id);
        return view('admin-panel.vacancy.edit',compact('vacancy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VacancyRequest $request, string $id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->save();
        for($i = 0; $i < count($request->lang); $i++){
            VacancyTranslate::where(['vacancy_id' => $id, 'lang' => $request['lang'][$i]])->update([
                'title' => $request['title'][$i],
                'slug' => Str::slug($request['title'][$i]),
                'text' => $request['text'][$i],
                'lang' => $request['lang'][$i],
            ]);
        }
        return redirect()->route('admin.vacancy.index')->with('update_message', 'Dəyişikliklər uğurla yadda saxlanıldı');
    }

    public function sort(Request $request)
    {
        $order_data = $request['data'];
        try {
            DB::beginTransaction();

            foreach ($order_data as $data) {
                Vacancy::where('id', $data['id'])->update(['order' => $data['order']]);
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
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->destroy = 1;
        $vacancy->save();
        return redirect()->route('admin.vacancy.index')->with('delete_message','Uğurla silindi');
    }
}
