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

    <validate tag="div">
          <div class="form-group">
            <label for="model-juara">Juara</label>
            <input type="text" class="form-control" id="model-juara" v-model="model.juara" name="juara" placeholder="Juara" required autofocus>
            <field-messages name="juara" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

         <validate tag="div">
          <div class="form-group">
            <label for="model-tingkat">Tingkat</label>
            <input type="text" class="form-control" id="model-tingkat" v-model="model.tingkat" name="tingkat" placeholder="Tingkat" required autofocus>
            <field-messages name="tingkat" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

         <validate tag="div">
          <div class="form-group">
            <label for="model-nilai">Nilai</label>
            <input type="text" class="form-control" id="model-nilai" v-model="model.nilai" name="nilai" placeholder="Nilai" required autofocus>
            <field-messages name="nilai" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-bobot">Bobot</label>
            <input type="text" class="form-control" id="model-bobot" v-model="model.bobot" name="bobot" placeholder="Bobot" required autofocus>
            <field-messages name="bobot" show="$invalid && $submitted" class="text-danger">
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
    axios.get('api/master-prestasi/create')
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
        juara: "",
        user: "",
        tingkat: "",
        nilai: "",
        bobot: "",
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
        axios.post('api/master-prestasi', {
            user_id: this.model.user.id,
            juara: this.model.juara,
            tingkat: this.model.tingkat,
            nilai: this.model.nilai,
            bobot: this.model.bobot,             
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
          nilai: "",
          bobot: ""
      };
    },
    back() {
      window.location = '#/admin/master-prestasi';
    }
  }
}
</script>
