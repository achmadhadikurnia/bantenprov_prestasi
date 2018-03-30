<?php

namespace Bantenprov\Prestasi\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Prestasi\Facades\PrestasiFacade;

/* Models */
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\MasterPrestasi;
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\JenisPrestasi;
use App\User;

/* Etc */
use Validator;

/**
 * The PrestasiController class.
 *
 * @package Bantenprov\Prestasi
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class MasterPrestasiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $master_prestasi;
    protected $jenis_prestasi;
    protected $user;

    public function __construct(MasterPrestasi $master_prestasi, JenisPrestasi $jenis_prestasi, User $user)
    {
        $this->master_prestasi = $master_prestasi;
        $this->jenis_prestasi = $jenis_prestasi;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->master_prestasi->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->master_prestasi->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('nilai', 'like', $value)
                    ->orWhere('bobot', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('user')->with('jenis_prestasi')->paginate($perPage);


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
        $users = $this->user->all();
        $jenis_prestasis = $this->jenis_prestasi->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        foreach($jenis_prestasis as $jenis_prestasi){
            array_set($jenis_prestasi, 'label', $jenis_prestasi->nama_jenis_prestasi);
        }
        
        $response['jenis_prestasi'] = $jenis_prestasis;
        $response['user'] = $users;
        $response['status'] = true;

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
        $master_prestasi = $this->master_prestasi;

        $validator = Validator::make($request->all(), [
            /*'user_id' => 'required|unique:master_prestasis,user_id',*/
            'user_id' => 'required',
            'jenis_prestasi_id' => 'required',
            'juara' => 'required',
            'tingkat' => 'required',
            'nilai' => 'required',
            'bobot' => 'required',
        ]);

        if($validator->fails()){
            $check = $jenis_prestasi->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed ! Username, already exists';
            } else {
                $master_prestasi->jenis_prestasi_id = $request->input('jenis_prestasi_id');
                $master_prestasi->user_id = $request->input('user_id');
                $master_prestasi->juara = $request->input('juara');
                $master_prestasi->tingkat = $request->input('tingkat');
                $master_prestasi->nilai = $request->input('nilai');
                $master_prestasi->bobot = $request->input('bobot');
                $master_prestasi->save();

                $response['message'] = 'success';
            }
        } else {
                $master_prestasi->jenis_prestasi_id = $request->input('jenis_prestasi_id');
                $master_prestasi->user_id = $request->input('user_id');
                $master_prestasi->juara = $request->input('juara');
                $master_prestasi->tingkat = $request->input('tingkat');
                $master_prestasi->nilai = $request->input('nilai');
                $master_prestasi->bobot = $request->input('bobot');
                $master_prestasi->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

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
        $master_prestasi = $this->master_prestasi->findOrFail($id);
        
        $response['user'] = $master_prestasi->user;
        $response['jenis_prestasi'] = $master_prestasi->jenis_prestasi;
        $response['master_prestasi'] = $master_prestasi;
        $response['status'] = true;

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
        $master_prestasi = $this->master_prestasi->findOrFail($id);

        array_set($master_prestasi->user, 'label', $master_prestasi->user->name);
        array_set($master_prestasi->jenis_prestasi, 'label', $master_prestasi->jenis_prestasi->nama_jenis_prestasi);

        $response['master_prestasi'] = $master_prestasi;
        $response['jenis_prestasi'] = $master_prestasi->jenis_prestasi;
        $response['user'] = $master_prestasi->user;
        $response['status'] = true;

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
        $response = array();
        $message  = array();
        $master_prestasi = $this->master_prestasi->findOrFail($id);

            $validator = Validator::make($request->all(), [
                /*'user_id' => 'required|unique:sktms,user_id,'.$id,*/
                'user_id' => 'required',
                'jenis_prestasi_id' => 'required',
                'juara' => 'required',
                'tingkat' => 'required',
                'nilai' => 'required',
                'bobot' => 'required',
                
            ]);

        if ($validator->fails()) {

            foreach($validator->messages()->getMessages() as $key => $error){
                        foreach($error AS $error_get) {
                            array_push($message, $error_get);
                        }                
                    } 

            $check_user = $this->master_prestasi->where('id','!=', $id)->where('label', $request->label);

             if($check_user->count() > 0){
                  $response['message'] = implode("\n",$message);

            } else {
                $master_prestasi->user_id = $request->input('user_id');
                $master_prestasi->jenis_prestasi_id = $request->input('jenis_prestasi_id');
                $master_prestasi->juara = $request->input('juara');
                $master_prestasi->tingkat = $request->input('tingkat');
                $master_prestasi->nilai = $request->input('nilai');
                $master_prestasi->bobot = $request->input('bobot');
                $master_prestasi->save();

                $response['message'] = 'success';
            }
        } else {
                $master_prestasi->user_id = $request->input('user_id');
                $master_prestasi->jenis_prestasi_id = $request->input('jenis_prestasi_id');
                $master_prestasi->juara = $request->input('juara');
                $master_prestasi->tingkat = $request->input('tingkat');
                $master_prestasi->nilai = $request->input('nilai');
                $master_prestasi->bobot = $request->input('bobot');
                $master_prestasi->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

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
        $master_prestasi = $this->master_prestasi->findOrFail($id);

        if ($master_prestasi->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
