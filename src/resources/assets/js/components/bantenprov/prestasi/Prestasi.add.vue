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
            <label for="user_id">Username</label>
            <v-select name="user_id" v-model="model.user" :options="user" class="mb-4"></v-select>

            <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

    <validate tag="div">
          <div class="form-group">
            <label for="model-master_prestasi_id">Master Prestasi ID</label>
            <input type="text" class="form-control" id="model-master_prestasi_id" v-model="model.master_prestasi_id" name="master_prestasi_id" placeholder="Master Prestasi ID" required autofocus>
            <field-messages name="master_prestasi_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

         <validate tag="div">
          <div class="form-group">
            <label for="model-nomor_un">Nomor UN</label>
            <input type="text" class="form-control" id="model-nomor_un" v-model="model.nomor_un" name="nomor_un" placeholder="Nomor UN" required autofocus>
            <field-messages name="nomor_un" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

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
        response.data.user.forEach(user_element => {
            this.user.push(user_element);
        });
    })
    .catch(function(response) {
      alert('Break');
    });
  },
  data() {
    return {
      state: {},
      model: {
        master_prestasi_id: "",
        user: "",
        nomor_un: "",
        nama_lomba: "",
      },
      user: []
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
            master_prestasi_id: this.model.master_prestasi_id,
            nomor_un: this.model.nomor_un,
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
          master_prestasi_id: "",
          nomor_un: "",
          nama_lomba: ""
      };
    },
    back() {
      window.location = '#/admin/prestasi';
    }
  }
}
</script>
