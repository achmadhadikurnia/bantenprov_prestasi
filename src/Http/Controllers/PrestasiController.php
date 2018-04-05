<?php

namespace Bantenprov\Prestasi\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\Prestasi\Facades\PrestasiFacade;

/* Models */
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\Prestasi;
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\MasterPrestasi;
use Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa;
use App\User;

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
    protected $prestasi;
    protected $master_prestasi;
    protected $siswa;
    protected $user;

    public function __construct(Prestasi $prestasi, MasterPrestasi $master_prestasi, User $user, Siswa $siswa)
    {
        $this->prestasi = $prestasi;
        $this->master_prestasi = $master_prestasi;
        $this->siswa = $siswa;
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

            $query = $this->prestasi->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->prestasi->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('siswa_id', 'like', $value)
                    ->orWhere('nama_lomba', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('user')->with('master_prestasi')->with('siswa')->paginate($perPage);

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
        $master_prestasis = $this->master_prestasi->all();
        $siswas = $this->siswa->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        foreach($master_prestasis as $master_prestasi){
            array_set($master_prestasi, 'label', $master_prestasi->juara);
        }

        foreach($siswas as $siswa){
            array_set($siswa, 'label', $siswa->nama_siswa);
        }
        
        $response['master_prestasi'] = $master_prestasis;
        $response['siswa'] = $siswas;
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
        $prestasi = $this->prestasi;

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:prestasis,user_id',
            'master_prestasi_id' => 'required',
            'siswa_id' => 'required|unique:prestasis,siswa_id',
            'nama_lomba' => 'required',
        ]);

        if($validator->fails()){
            $check = $prestasi->where('user_id',$request->user_id)->orWhere('siswa_id',$request->siswa_id)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed ! Username, Nama Siswa, already exists';
            } else {
                $prestasi->user_id = $request->input('user_id');
                $prestasi->master_prestasi_id = $request->input('master_prestasi_id');
                $prestasi->siswa_id = $request->input('siswa_id');
                $prestasi->nama_lomba = $request->input('nama_lomba');
                $prestasi->save();

                $response['message'] = 'success';
            }
        } else {
                $prestasi->user_id = $request->input('user_id');
                $prestasi->master_prestasi_id = $request->input('master_prestasi_id');
                $prestasi->siswa_id = $request->input('siswa_id');
                $prestasi->nama_lomba = $request->input('nama_lomba');
                $prestasi->save();

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
        $prestasi = $this->prestasi->findOrFail($id);
        
        $response['user'] = $prestasi->user;
        $response['master_prestasi'] = $prestasi->master_prestasi;
        $response['siswa'] = $prestasi->siswa;
        $response['prestasi'] = $prestasi;
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
        $prestasi = $this->prestasi->findOrFail($id);

        array_set($prestasi->user, 'label', $prestasi->user->name);
        array_set($prestasi->master_prestasi, 'label', $prestasi->master_prestasi->juara);
        array_set($prestasi->siswa, 'label', $prestasi->siswa->nama_siswa);
        
        $response['master_prestasi'] = $prestasi->master_prestasi;
        $response['siswa'] = $prestasi->siswa;
        $response['prestasi'] = $prestasi;
        $response['user'] = $prestasi->user;
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

        $prestasi = $this->prestasi->findOrFail($id);

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:prestasis,user_id,'.$id,
                'master_prestasi_id' => 'required',
                'siswa_id' => 'required|unique:prestasis,siswa_id,'.$id,
                'nama_lomba' => 'required',
                
            ]);

        if ($validator->fails()) {

            foreach($validator->messages()->getMessages() as $key => $error){
                        foreach($error AS $error_get) {
                            array_push($message, $error_get);
                        }                
                    } 

             $check_user = $this->prestasi->where('id','!=', $id)->where('user_id', $request->user_id);
             $check_siswa = $this->prestasi->where('id','!=', $id)->where('siswa_id', $request->siswa_id);

             if($check_user->count() > 0 || $check_siswa->count() > 0){
                  $response['message'] = implode("\n",$message);
            } else {
                $prestasi->user_id = $request->input('user_id');
                $prestasi->master_prestasi_id = $request->input('master_prestasi_id');
                $prestasi->siswa_id = $request->input('siswa_id');
                $prestasi->nama_lomba = $request->input('nama_lomba');
                $prestasi->save();

                $response['message'] = 'success';
            }
        } else {
                $prestasi->user_id = $request->input('user_id');
                $prestasi->master_prestasi_id = $request->input('master_prestasi_id');
                $prestasi->siswa_id = $request->input('siswa_id');
                $prestasi->nama_lomba = $request->input('nama_lomba');
                $prestasi->save();

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
        $prestasi = $this->prestasi->findOrFail($id);

        if ($prestasi->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
