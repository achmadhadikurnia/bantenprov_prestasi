<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Add Master Prestasi

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">

    <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="user_id">Username</label>
            <v-select name="user_id" v-model="model.user" :options="user" class="mb-4"></v-select>

            <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="jenis_prestasi">Jenis Prestasi</label>
            <v-select name="jenis_prestasi" v-model="model.jenis_prestasi" :options="jenis_prestasi" class="mb-4"></v-select>

            <field-messages name="jenis_prestasi" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Jenis Prestasi is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="juara">Juara</label>
            <v-select v-model="model.juara" :options="optionsJuara" class="mb-4"></v-select>

            <field-messages name="juara" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Juara is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="tingkat">Tingkat</label>
            <v-select v-model="model.tingkat" :options="optionsTingkat" class="mb-4"></v-select>

            <field-messages name="tingkat" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Tingkat is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

         <validate tag="div">
          <div class="form-group">
            <label for="model-nilai">Nilai</label>
            <input type="text" class="form-control" id="model-nilai" v-model="model.nilai" name="nilai" placeholder="Nilai" required autofocus>
            <field-messages name="nilai" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nilai is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-kode_prestasi">Kode Prestasi</label>
            <input type="text" class="form-control" id="model-kode_prestasi" v-model="model.kode_prestasi" name="kode_prestasi" placeholder="Kode Prestasi" required autofocus>
            <field-messages name="kode_prestasi" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Kode Prestasi is a required field</small>
            </field-messages>
          </div>
        </validate>

         <div class="form-row mt-4">
          <div class="col-md">
            <button type="submit" class="btn btn-primary">Submit</button>

            <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>
          </div>
        </div>

      </vue-form>
    </div>
  </div>
</template>

<script>
export default {
  mounted(){
    axios.get('api/master-prestasi/create')
    .then(response => {
        response.data.user.forEach(user_element => {
            this.user.push(user_element);
        });
        response.data.jenis_prestasi.forEach(element => {
          this.jenis_prestasi.push(element);
        });
    })
    .catch(function(response) {
      alert('Break');
    });
  },
  data() {
    return {
      optionsJuara: [
        {id: 1, label: 'Juara 1'},
        {id: 2, label: 'Juara 2'},
        {id: 3, label: 'Juara 3'},
        {id: 4, label: 'Juara Harapan 1'},
      ],
      selectedJuara: {id: "-", label: 'Pilih Salah Satu'},

      optionsTingkat: [
        {id: 1, label: 'Tingkat Internasional'},
        {id: 2, label: 'Tingkat Nasional'},
        {id: 3, label: 'Tingkat Provinsi'},
        {id: 4, label: 'Tingkat Kabupaten/Kota'},
      ],
      selectedTingkat: {id: "-", label: 'Pilih Salah Satu'},

      state: {},
      model: {
        jenis_prestasi: "",
        juara: "",
        tingkat: "",
        nilai: "",
        kode_prestasi: "",
        user: ""
      },
      user: [],
      jenis_prestasi: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.post('api/master-prestasi', {
            user_id: this.model.user.id,
            jenis_prestasi_id: this.model.jenis_prestasi.id,
            nilai: this.model.nilai,
            juara: this.model.juara.id,
            tingkat: this.model.tingkat.id,
            kode_prestasi: this.model.kode_prestasi             
          })
          .then(response => {
            if (response.data.status == true) {
              if(response.data.message == 'success'){
                alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert(response.data.message);
            }
          })
          .catch(function(response) {
            alert('Break ' + response.data.message);
          });
      }
    },
    reset() {
      this.model = {
          juara: "",
          tingkat: "",
          nilai: ""
      };
    },
    back() {
      window.location = '#/admin/master-prestasi/';
    },
  }
}
</script>
