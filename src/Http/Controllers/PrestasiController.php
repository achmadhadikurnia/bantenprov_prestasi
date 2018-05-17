<?php

namespace Bantenprov\Prestasi\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Bantenprov\Prestasi\Facades\PrestasiFacade;

/* Models */
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\Prestasi;
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\MasterPrestasi;
use Bantenprov\Siswa\Models\Bantenprov\Siswa\Siswa;
use App\User;
use Bantenprov\Nilai\Models\Bantenprov\Nilai\Nilai;
use Bantenprov\Sekolah\Models\Bantenprov\Sekolah\AdminSekolah;

/* Etc */
use Validator;
use Auth;

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
    protected $siswa;
    protected $master_prestasi;
    protected $user;
    protected $nilai;
    protected $admin_sekolah;

    public function __construct()
    {
        $this->prestasi         = new Prestasi;
        $this->siswa            = new Siswa;
        $this->master_prestasi  = new MasterPrestasi;
        $this->user             = new User;
        $this->nilai            = new Nilai;
        $this->admin_sekolah            = new AdminSekolah;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin_sekolah = $this->admin_sekolah->where('admin_sekolah_id', Auth::user()->id)->first();

        if(is_null($admin_sekolah) && $this->checkRole(['superadministrator']) === false){
            $response = [];
            return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
        }

        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            if($this->checkRole(['superadministrator'])){
                $query = $this->prestasi->orderBy($sortCol, $sortDir);
            }else{
                $query = $this->prestasi->where('user_id', $admin_sekolah->admin_sekolah_id)->orderBy($sortCol, $sortDir);
            }
        } else {
            if($this->checkRole(['superadministrator'])){
                $query = $this->prestasi->orderBy('id', 'asc');
            }else{
                $query = $this->prestasi->where('user_id', $admin_sekolah->admin_sekolah_id)->orderBy('id', 'asc');            
            }
        }

        if ($request->exists('filter')) {
            if($this->checkRole(['superadministrator'])){
                $query->where(function($q) use($request) {
                    $value = "%{$request->filter}%";

                    $q->where('sekolah_id', 'like', $value)
                        ->orWhere('admin_sekolah_id', 'like', $value);
                });
            }else{
                $query->where(function($q) use($request, $admin_sekolah) {
                    $value = "%{$request->filter}%";

                    $q->where('sekolah_id', $admin_sekolah->sekolah_id)->where('sekolah_id', 'like', $value);
                });
            }

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
        $response = [];

        $master_prestasis = $this->master_prestasi->all();
        $users_special = $this->user->all();
        $users_standar = $this->user->find(\Auth::User()->id);
        $current_user = \Auth::User();
       
        $admin_sekolah = $this->admin_sekolah->where('admin_sekolah_id', Auth::user()->id)->first();
        
        if($this->checkRole(['superadministrator'])){
            $siswas = $this->siswa->all();
        }else{
            $sekolah_id = $admin_sekolah->sekolah_id;
            $siswas     = $this->siswa->where('sekolah_id', $sekolah_id)->get();
        }

        array_set($current_user, 'label', $current_user->name);

        $response['current_user'] = $current_user;

        foreach($master_prestasis as $master_prestasi){
            if($master_prestasi->juara == 1){
                $juara = "Juara 1";
            }elseif($master_prestasi->juara == 2){
                $juara = "Juara 2";
            }elseif($master_prestasi->juara == 3){
                $juara = "Juara 3";
            }else{
                $juara = "Juara Harapan 1";
            }

            if($master_prestasi->tingkat == 1){
                $tingkat = "Tingkat Internasional";
            }elseif($master_prestasi->tingkat == 2){
                $tingkat = "Tingkat Nasional";
            }elseif($master_prestasi->tingkat == 3){
                $tingkat = "Tingkat Provinsi";
            }else{
                $tingkat = "Tingkat Kabupaten/Kota";
            }

            array_set($master_prestasi, 'label', "( ".$juara." ".$tingkat." ) - ".$master_prestasi->jenis_prestasi->nama);
        }

        foreach($siswas as $siswa){
            array_set($siswa, 'label', $siswa->nama_siswa);
        }

        $response['master_prestasi'] = $master_prestasis;
        $response['siswa'] = $siswas;
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
            'nomor_un'              => "required|exists:{$this->siswa->getTable()},nomor_un|unique:{$this->prestasi->getTable()},nomor_un,NULL,id,deleted_at,NULL",
            'master_prestasi_id'    => "required|exists:{$this->master_prestasi->getTable()},id",
            'nama_lomba'            => 'required|max:255',
            // 'nilai'             => 'required|numeric|min:0|max:100',
            'user_id'               => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error                  = true;
            $response['message']    = $validator->errors()->first();
        } else {
            $prestasi_master_prestasi_id    = $request->input('master_prestasi_id');
            $master_prestasi                = $this->master_prestasi->findOrFail($prestasi_master_prestasi_id);

            $prestasi->nomor_un             = $request->input('nomor_un');
            $prestasi->master_prestasi_id   = $prestasi_master_prestasi_id;
            $prestasi->nama_lomba           = $request->input('nama_lomba');
            $prestasi->nilai                = $master_prestasi->nilai;
            $prestasi->user_id              = $request->input('user_id');

            $nilai = $this->nilai->updateOrCreate(
                [
                    'nomor_un'  => $prestasi->nomor_un,
                ],
                [
                    'prestasi'  => $prestasi->nilai,
                    'total'     => null,
                    'user_id'   => $prestasi->user_id,
                ]
            );

            DB::beginTransaction();

            if ($prestasi->save() && $nilai->save())
            {
                DB::commit();

                $error      = false;
                $response['message'] = 'success';
            } else {
                DB::rollBack();

                $error                  = true;
                $response['message']    = 'Failed';
            }
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
        $prestasi = $this->prestasi;

        $validator = Validator::make($request->all(), [
            'nomor_un'              => "required|exists:{$this->siswa->getTable()},nomor_un|unique:{$this->prestasi->getTable()},nomor_un,{$id},id,deleted_at,NULL",
            'master_prestasi_id'    => "required|exists:{$this->master_prestasi->getTable()},id",
            'nama_lomba'            => 'required|max:255',
            // 'nilai'             => 'required|numeric|min:0|max:100',
            'user_id'               => "required|exists:{$this->user->getTable()},id",
        ]);

        if ($validator->fails()) {
            $error                  = true;
            $response['message']    = $validator->errors()->first();
        } else {
            $prestasi_master_prestasi_id    = $request->input('master_prestasi_id');
            $master_prestasi                = $this->master_prestasi->findOrFail($prestasi_master_prestasi_id);

            $prestasi->nomor_un             = $request->input('nomor_un');
            $prestasi->master_prestasi_id   = $prestasi_master_prestasi_id;
            $prestasi->nama_lomba           = $request->input('nama_lomba');
            $prestasi->nilai                = $master_prestasi->nilai;
            $prestasi->user_id              = $request->input('user_id');

            $nilai = $this->nilai->updateOrCreate(
                [
                    'nomor_un'  => $prestasi->nomor_un,
                ],
                [
                    'prestasi'  => $prestasi->nilai,
                    'total'     => null,
                    'user_id'   => $prestasi->user_id,
                ]
            );

            DB::beginTransaction();

            if ($prestasi->save() && $nilai->save())
            {
                DB::commit();

                $error      = false;
                $response['message'] = 'success';
            } else {
                DB::rollBack();

                $error                  = true;
                $response['message']    = 'Failed';
            }
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

    protected function checkRole($role = array())
    {
        return Auth::user()->hasRole($role);
    }
}
