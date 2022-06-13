<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\Output;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Query RAW
        $listCategory = DB::select(DB::raw('SELECT * FROM categories'));

        //Query Builder
        $listCategory = DB::table('categories')->get();

        //Eloquent Model
        $listCategory = Category::all();


        return view('category.index', compact('listCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Category();
        $data->name = $request->get('name');
        $data->description = $request->get('description');
        $data->save();

        return redirect()->route('kategori_obat.index')->with('status', 'KATEGORI berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data = $category;
        return view('category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category)
    {
        $category = Category::find($category);
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->save();
        return redirect()->route('kategori_obat.index')->with('status', 'Supplier data is changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->route('category.index')->with('status', 'Data Kategori berhasil dihapus.');
        } catch (\PDOException $e) {
            $msg = "Data gagal dihapus. Pastikan data child sudah hilang atau tidak berhubungan.";
            return redirect()->route('category.index')->with('error', $msg);
        }
    }

    public function showlist($id_category)
    {
        //DBQuery
        /*$data = DB::table('categories')
                ->join('medicines', 'categories.id', '=', 'medicines.category_id')
                ->where('categories.id', '=', $id_category)
                ->get();
        $getTotalData = $data->count();*/

        //Eloquent Model
        $data = Category::find($id_category);
        $namecategory = $data->name;

        $result = $data->medicines;
        if ($result) {
            $getTotalData = $result->count();
        } else {
            $getTotalData = 0;
        }
        return view('report.list_medicines_by_category', compact('id_category', 'namecategory', 'result', 'getTotalData'));
    }

    public function listCategory()
    {
        //DBQuery
        // $data = DB::table('categories')->get();

        //Eloquent Model
        $data = Category::get();

        //dd($data);

        return view('', compact('data'));
    }

    public function countNumOfCatWithMed()
    {
        //DBQuery
        // $data = DB::table('categories')
        // ->join('medicines', 'categories.id', '=', 'medicines.category_id')
        // ->distinct()
        // ->count('categories.id');

        //Eloquent Model
        $data = Category::join('medicines', 'categories.id', '=', 'medicines.category_id')
            ->distinct()
            ->count('categories.id');

        //dd($data);

        return view('', compact('data'));
    }

    public function nameCatNoMed()
    {
        //DBQuery
        $data = DB::table('categories')
            ->leftjoin('medicines', 'categories.id', '=', 'medicines.category_id')
            ->where('medicines.category_id')
            ->select('categories.name')
            ->get();

        //Eloquent Model
        $data = Category::leftjoin('medicines', 'categories.id', '=', 'medicines.category_id')
            ->where('medicines.category_id')
            ->select('categories.name')
            ->get();

        //dd($data);

        return view('', compact('data'));
    }

    public function catOneMed()
    {
        //DBQuery
        $data = DB::table('categories')
            ->join('medicines', 'categories.id', '=', 'medicines.category_id')
            ->groupby('categories.id', 'categories.name', 'categories.desc')
            ->having(DB::raw('count(medicines.category_id)'), 1)
            ->get();

        //Eloquent Model
        $data = Category::join('medicines', 'categories.id', '=', 'medicines.category_id')
            ->groupby('categories.id', 'categories.name', 'categories.description')
            ->having(DB::raw('count(medicines.category_id)'), 1)
            ->get();

        dd($data);

        return view('', compact('data'));
    }

    public function createCategory()
    {
    }

    public function getEditForm(Request $request)
    {
        $id = $request->get('id');
        $data = Category::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('category.getEditForm', compact('data'))->render()
        ), 200);
    }

    public function getEditForm2(Request $request)
    {
        $id = $request->get('id');
        $data = Category::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('category.getEditForm2', compact('data'))->render()
        ), 200);
    }

    public function saveData(Request $request)
    {
        $id = $request->get('id');
        $category = Category::find($id);
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->save();
        return response()->json(array(
            'status' => 'ok',
            'msg' => "Data Kategori updated!"
        ), 200);
    }

    public function deleteData(Request $request)
    {
        try {
            $id = $request->get('id');
            $category = Category::find($id);
            $category->delete();
            return response()->json(array(
                'status' => 'ok',
                'msg' => "Data Kategori deleted!"
            ), 200);
        } catch (\PDOException $e) {
            return response()->json(array(
                'status' => 'ok',
                'msg' => "Data Kategori is Not Deleted!"
            ), 200);
        }
    }
}
