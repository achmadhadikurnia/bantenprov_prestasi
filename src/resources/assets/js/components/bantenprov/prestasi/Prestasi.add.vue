<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Add Prestasi

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
            <label for="siswa_id">Nama Siswa</label>
            <v-select name="siswa_id" v-model="model.siswa" :options="siswa" class="mb-4"></v-select>

            <field-messages name="siswa_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Nama Siswa is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="master_prestasi_id">Master Prestasi</label>
            <v-select name="master_prestasi_id" v-model="model.master_prestasi" :options="master_prestasi" class="mb-4"></v-select>

            <field-messages name="master_prestasi_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Master Prestasi is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

         <validate tag="div">
          <div class="form-group">
            <label for="model-nama_lomba">Nama Lomba</label>
            <input type="text" class="form-control" id="model-nama_lomba" v-model="model.nama_lomba" name="nama_lomba" placeholder="Nama Lomba" required autofocus>
            <field-messages name="nama_lomba" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="user_id">Username</label>
            <v-select name="user_id" v-model="model.user" :options="user" class="mb-4"></v-select>

            <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

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
    axios.get('api/prestasi/create')
    .then(response => {
      if (response.data.status == true) {
        this.model.user = response.data.current_user;

        response.data.master_prestasi.forEach(element => {
          this.master_prestasi.push(element);
        });
        response.data.siswa.forEach(element => {
          this.siswa.push(element);
        });
        if(response.data.user_special == true){
          response.data.user.forEach(user_element => {
            this.user.push(user_element);
          });
        }else{
          this.user.push(response.data.user);
        }
      } else {
        alert('Failed');
      }
    })
    .catch(function(response) {
      alert('Break');
      window.location = '#/admin/prestasi';
    });
  },
  data() {
    return {
      state: {},
      model: {
        master_prestasi: "",
        siswa: "",
        user: "",
        nama_lomba: ""
      },
      user: [],
      master_prestasi: [],
      siswa: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.post('api/prestasi', {
            user_id: this.model.user.id,
            master_prestasi_id: this.model.master_prestasi.id,
            siswa_id: this.model.siswa.id,
            nama_lomba: this.model.nama_lomba
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
          nama_lomba: ""
      };
    },
    back() {
      window.location = '#/admin/prestasi';
    }
  }
}
</script>
