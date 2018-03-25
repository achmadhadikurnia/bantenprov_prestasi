<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Master Prestasi 

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
            <b>Jenis Prestasi :</b> {{ model.jenis_prestasi.nama_jenis_prestasi }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Juara :</b> {{ model.juara }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Tingkat :</b> {{ model.tingkat }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Nilai :</b> {{ model.nilai }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Bobot :</b> {{ model.bobot }}
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <b>Username :</b> {{ model.user.name }}
          </div>
        </div>        
        
      </vue-form>
    </div>
<div class="card-footer text-muted">
        <div class="row">
          <div class="col-md-6">Dibuat : {{ model.created_at }}</div>
          <div class="col-md-6 text-right">Diperbaiki : {{ model.updated_at }}</div>
        </div></div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('api/master-prestasi/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.user = response.data.user;
          this.model.jenis_prestasi = response.data.jenis_prestasi;
          this.model.juara = response.data.master_prestasi.juara;
          this.model.tingkat = response.data.master_prestasi.tingkat;
          this.model.nilai = response.data.master_prestasi.nilai;
          this.model.bobot = response.data.master_prestasi.bobot;
          this.model.created_at = response.data.master_prestasi.created_at;
          this.model.updated_at = response.data.master_prestasi.updated_at;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/master-prestasi/';
      })

  },
  data() {
    return {
      state: {},
      model: {
        user: "",
        jenis_prestasi: "",
        juara: "",
        tingkat: "",
        nilai: "",
        bobot: "",
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
        axios.put('api/master-prestasi/' + this.$route.params.id, {
            juara: this.model.juara,
            jenis_prestasi_id: this.model.jenis_prestasi.id,
            tingkat: this.model.tingkat,
            nilai: this.model.nilai,
            bobot: this.model.bobot,
            user_id: this.model.master_prestasi.id
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
      axios.get('api/master-prestasi/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.label = response.data.prestasi.label;
            this.model.description = response.data.prestasi.description;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/master-prestasi/';
    }
  }
}
</script>
