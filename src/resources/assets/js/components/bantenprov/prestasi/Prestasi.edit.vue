<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <vue-form :state="state" @submit.prevent="onSubmit">

        <validate tag="div">
          <div class="form-group">
            <label for="model-label">Label</label>
            <input type="text" class="form-control" id="model-label" v-model="model.label" name="label" placeholder="Label" required autofocus>
            <field-messages name="label" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="model-description">Description</label>
            <input type="text" class="form-control" id="model-description" v-model="model.description" name="description" placeholder="Description" required>
            <field-messages name="description" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>
        </div>

      </vue-form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      state: {},
      title: 'Edit Prestasi',
      model: {
        label       : '',
        description : ''
      }
    }
  },
  mounted() {
    axios.get('api/prestasi/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.loaded == true) {
          this.model.label        = response.data.prestasi.label;
          this.model.description  = response.data.prestasi.description;
        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/prestasi';
      });
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/prestasi/' + this.$route.params.id, {
            label       : this.model.label,
            description : this.model.description
          })
          .then(response => {
            if (response.data.loaded == true) {
              if(response.data.error == false){
                alert(response.data.message);
                app.back();
              }else{
                alert(response.data.message);
              }
            } else {
              alert('Failed');
            }
          })
          .catch(function(response) {
            alert('Break');
          });
      }
    },
    reset() {
      axios.get('api/prestasi/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.loaded == true) {
            this.model.label        = response.data.prestasi.label;
            this.model.description  = response.data.prestasi.description;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/prestasi';
    }
  }
}
</script>
