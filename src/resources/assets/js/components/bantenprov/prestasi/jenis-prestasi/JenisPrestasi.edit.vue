<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Edit Jenis Prestasi

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
              <label for="model-nama_jenis_prestasi">Nama Jenis Prestasi</label>
              <input class="form-control" v-model="model.nama_jenis_prestasi" required autofocus name="nama_jenis_prestasi" type="text" placeholder="Nama Jenis Prestasi">

              <field-messages name="nama_jenis_prestasi" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Juara is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

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
  mounted() {
    axios.get('api/jenis-prestasi/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {
          this.model.user = response.data.user,
          this.model.nama_jenis_prestasi = response.data.jenis_prestasi.nama_jenis_prestasi;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/jenis-prestasi/';
      }),

      axios.get('api/jenis-prestasi/create')
      .then(response => {
          response.data.user.forEach(user_element => {
            this.user.push(user_element);
          });
      })
      .catch(function(response) {
        alert('Break');
      })
  },
  data() {
    return {
      state: {},
      model: {
        user: "",
        nama_jenis_prestasi: ""
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
        axios.put('api/jenis-prestasi/' + this.$route.params.id, {
            user_id: this.model.user.id,
            nama_jenis_prestasi: this.model.nama_jenis_prestasi
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
      axios.get('api/jenis-prestasi/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.nama_jenis_prestasi = response.data.jenis_prestasi.nama_jenis_prestasi;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/jenis-prestasi/';
    }
  }
}
</script>
