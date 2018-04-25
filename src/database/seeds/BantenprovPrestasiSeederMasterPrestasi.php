<?php
use Illuminate\Database\Seeder;
/**
 * Usage :
 * [1] $ composer dump-autoload -o
 * [2] $ php artisan db:seed --class=BantenprovPrestasiSeederMasterPrestasi
 */
class BantenprovPrestasiSeederMasterPrestasi extends Seeder
{
    /* text color */
    protected $RED     ="\033[0;31m";
    protected $CYAN    ="\033[0;36m";
    protected $YELLOW  ="\033[1;33m";
    protected $ORANGE  ="\033[0;33m";
    protected $PUR     ="\033[0;35m";
    protected $GRN     ="\e[32m";
    protected $WHI     ="\e[37m";
    protected $NC      ="\033[0m";
    /* File name */
    /* location : /databse/seeds/file_name.csv */
    protected $fileName = "BantenprovPrestasiSeederMasterPrestasi.csv";
    /* text info : default (true) */
    protected $textInfo = true;
    /* model class */
    protected $model;
    /* __construct */
    public function __construct(){
        $this->model = new Bantenprov\Prestasi\Models\Bantenprov\Prestasi\MasterPrestasi;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertData();
    }
    /* function insert data */
    protected function insertData()
    {
        /* silahkan di rubah sesuai kebutuhan */
        foreach($this->readCSV() as $data){


        	$this->model->create([
            	'jenis_prestasi_id' => $data['jenis_prestasi_id'],
				'juara' => $data['juara'],
				'tingkat' => $data['tingkat'],
				'nilai' => $data['nilai'],
				'kode' => $data['kode'],
				'user_id' => $data['user_id'],

        	]);


        }

        if($this->textInfo){
            echo "============[DATA]============\n";
            $this->orangeText('jenis_prestasi_id : ').$this->greenText($data['jenis_prestasi_id']);
			echo"\n";
			$this->orangeText('juara : ').$this->greenText($data['juara']);
			echo"\n";
			$this->orangeText('tingkat : ').$this->greenText($data['tingkat']);
			echo"\n";
			$this->orangeText('nilai : ').$this->greenText($data['nilai']);
			echo"\n";
			$this->orangeText('kode : ').$this->greenText($data['kode']);
			echo"\n";
			$this->orangeText('user_id : ').$this->greenText($data['user_id']);
			echo"\n";

            echo "============[DATA]============\n\n";
        }

        $this->greenText('[ SEEDER DONE ]');
        echo"\n\n";
    }
    /* text color: orange */
    protected function orangeText($text)
    {
        printf($this->ORANGE.$text.$this->NC);
    }
    /* text color: green */
    protected function greenText($text)
    {
        printf($this->GRN.$text.$this->NC);
    }
    /* function read CSV file */
    protected function readCSV()
    {
        $file = fopen(database_path("seeds/".$this->fileName), "r");
        $all_data = array();
        $row = 1;
        while(($data = fgetcsv($file, 1000, ",")) !== FALSE){
            $all_data[] = [
                'jenis_prestasi_id' => $data[0],
                'juara' => $data[1],
                'tingkat' => $data[2],
                'nilai' => $data[3],
                'kode' => $data[4],
                'user_id' => $data[5],
            ];
        }
        fclose($file);
        return  $all_data;
    }
}
