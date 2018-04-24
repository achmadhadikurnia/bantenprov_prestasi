<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Master Prestasi

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="createRow">
            <i class="fa fa-plus" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <vuetable-filter-bar></vuetable-filter-bar>
      </div>

      <div style="margin:20px 0;">
        <div v-if="loading" class="d-flex justify-content-start align-items-center">
          <i class="fa fa-refresh fa-spin fa-fw"></i>
          <span>Loading...</span>
        </div>
      </div>

      <div class="table-responsive">
        <vuetable ref="vuetable"
          api-url="/api/master-prestasi/"
          :fields="fields"
          :sort-order="sortOrder"
          :css="css.table"
          pagination-path=""
          :per-page="5"
          :append-params="moreParams"
          @vuetable:pagination-data="onPaginationData"
          @vuetable:loading="onLoading"
          @vuetable:loaded="onLoaded">
          <template slot="actions" slot-scope="props">
            <div class="btn-group pull-right" role="group" style="display:flex;">
              <button class="btn btn-info btn-sm" role="button" @click="viewRow(props.rowData)">
                <span class="fa fa-eye"></span>
              </button>
              <button class="btn btn-warning btn-sm" role="button" @click="editRow(props.rowData)">
                <span class="fa fa-pencil"></span>
              </button>
              <button class="btn btn-danger btn-sm" role="button" @click="deleteRow(props.rowData)">
                <span class="fa fa-trash"></span>
              </button>
            </div>
          </template>
        </vuetable>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <vuetable-pagination-info ref="paginationInfo"
        ></vuetable-pagination-info>
        <vuetable-pagination ref="pagination"
          :css="css.pagination"
          @vuetable-pagination:change-page="onChangePage">
        </vuetable-pagination>
      </div>
    </div>
  </div>
</template>

<style>
.vuetable-th-sequence{
  width: 1px;
}
.vuetable-th-slot-actions {
  width: 1px;
  white-space: normal;
}
</style>

<script>
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo';

export default {
  components: {
    VuetablePaginationInfo
  },
  data() {
    return {
      loading: true,
      optionsJuara: [
        {id: 1, label: 'Juara 1'},
        {id: 2, label: 'Juara 2'},
        {id: 3, label: 'Juara 3'},
        {id: 4, label: 'Juara Harapan 1'},
      ],
      optionsTingkat: [
        {id: 1, label: 'Tingkat Internasional'},
        {id: 2, label: 'Tingkat Nasional'},
        {id: 3, label: 'Tingkat Provinsi'},
        {id: 4, label: 'Tingkat Kabupaten/Kota'},
      ],
      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'center aligned',
          dataClass: 'right aligned'
        },
        {
          name: 'jenis_prestasi.nama',
          title: 'Jenis Prestasi',
          sortField: 'jenis_prestasi_id',
          titleClass: 'center aligned'
        },
        {
          name: 'juara',
          title: 'Juara',
          sortField: 'juara',
          titleClass: 'center aligned',
          callback:'getJuaraById'
        },
        {
          name: 'nilai',
          title: 'Nilai',
          sortField: 'nilai',
          titleClass: 'center aligned'
        },
        {
          name: 'tingkat',
          title: 'Tingkat',
          sortField: 'tingkat',
          titleClass: 'center aligned',
          callback:'getTingkatById'
        },
        {
          name: 'user.name',
          title: 'Username',
          sortField: 'user_id',
          titleClass: 'center aligned'
        },
        {
          name: '__slot:actions',
          title: 'Actions',
          titleClass: 'center aligned',
          dataClass: 'center aligned'
        },
      ],
      sortOrder: [{
        field: 'id',
        direction: 'asc'
      }],
      moreParams: {},
      css: {
        table: {
          tableClass: 'table table-hover',
          ascendingIcon: 'fa fa-chevron-up',
          descendingIcon: 'fa fa-chevron-down'
        },
        pagination: {
          wrapperClass: 'vuetable-pagination btn-group',
          activeClass: 'active',
          disabledClass: 'disabled',
          pageClass: 'btn btn-light',
          linkClass: 'btn btn-light',
          icons: {
            first: 'fa fa-angle-double-left',
            prev: 'fa fa-angle-left',
            next: 'fa fa-angle-right',
            last: 'fa fa-angle-double-right'
          }
        }
      }
    }
  },
  methods: {
    getJuaraById(value){
      var found = this.optionsJuara.find((e) => {
        return e.id == value
      })

      return found.label
    },
    getTingkatById(value){
      var found = this.optionsTingkat.find((e) => {
        return e.id == value
      })

      return found.label
    },
    createRow() {
      window.location = '#/admin/master-prestasi/create';
    },
    viewRow(rowData) {
      window.location = '#/admin/master-prestasi/' + rowData.id;
    },
    editRow(rowData) {
      window.location = '#/admin/master-prestasi/' + rowData.id + '/edit';
    },
    deleteRow(rowData) {
      let app = this;

      if (confirm('Do you really want to delete it?')) {
        axios.delete('/api/master-prestasi/' + rowData.id)
          .then(function(response) {
            if (response.data.status == true) {
              app.$refs.vuetable.reload()
            } else {
              alert('Failed');
            }
          })
          .catch(function(response) {
            alert('Break');
          });
      }
    },
    onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
      this.$refs.paginationInfo.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
    onLoading: function() {
      this.loading = true;
    },
    onLoaded: function() {
      this.loading = false;
    }
  },
  events: {
    'filter-set' (filterText) {
      this.moreParams = {
        filter: filterText
      }

      Vue.nextTick(() => this.$refs.vuetable.refresh())
    },
    'filter-reset'() {
      this.moreParams = {
        //
      }

      Vue.nextTick(() => this.$refs.vuetable.refresh())
    }
  }
}
</script>
