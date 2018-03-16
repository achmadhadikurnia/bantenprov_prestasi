<?php

namespace Bantenprov\Prestasi\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Prestasi\Facades\PrestasiFacade;

/* Models */
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\Prestasi;

/* Etc */
use Validator;

/**
 * The PrestasiController class.
 *
 * @package Bantenprov\Prestasi
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PrestasiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Prestasi $prestasi)
    {
        $this->prestasi = $prestasi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('sort')) {
            list($sortCol, $sortDir) = explode('|', $request->sort);

            $query = $this->prestasi->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->prestasi->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('label', 'like', $value)
                    ->orWhere('description', 'like', $value);
            });
        }

        $perPage = $request->has('per_page') ? (int) $request->per_page : null;
        $response = $query->paginate($perPage);

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prestasi                 = $this->prestasi;
        $prestasi->id             = null;
        $prestasi->label          = null;
        $prestasi->description    = null;

        $response['prestasi'] = $prestasi;
        $response['loaded'] = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prestasi  $prestasi
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prestasi = $this->prestasi;

        $validator = Validator::make($request->all(), [
            'label'         => 'required|max:16|unique:prestasis,label,NULL,id,deleted_at,NULL',
            'description'   => 'required|max:255',
        ]);

        if($validator->fails()){
            $response['error'] = true;
            $response['message'] = $validator->errors()->first();
        } else {
            $prestasi->label          = $request->label;
            $prestasi->description    = $request->description;
            $prestasi->save();

            $response['error'] = false;
            $response['message'] = 'Success';
        }

        $response['loaded'] = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prestasi = $this->prestasi->findOrFail($id);

        $response['prestasi'] = $prestasi;
        $response['loaded'] = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prestasi  $prestasi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prestasi = $this->prestasi->findOrFail($id);

        $response['prestasi'] = $prestasi;
        $response['loaded'] = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prestasi  $prestasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prestasi = $this->prestasi->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'label'         => 'required|max:16|unique:prestasis,label,'.$id.',id,deleted_at,NULL',
            'description'   => 'required|max:255',
        ]);

        if($validator->fails()){
            $response['error'] = true;
            $response['message'] = $validator->errors()->first();
        } else {
            $prestasi->label          = $request->label;
            $prestasi->description    = $request->description;
            $prestasi->save();

            $response['error'] = false;
            $response['message'] = 'Success';
        }

        $response['loaded'] = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prestasi  $prestasi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prestasi = $this->prestasi->findOrFail($id);

        if ($prestasi->delete()) {
            $response['loaded'] = true;
        } else {
            $response['loaded'] = false;
        }

        return json_encode($response);
    }
}
