<template>
  <div class="container">
    <div class="row mb-3">
      <div class="col-md-5">
        <div class="row">
          <div class="col-md-8">
            <label>Filter By Pharmacy</label>
            <v-select
                taggable
                label="label"
                :options="options"
                v-model="selected"
                :reduce="option => option.id"
                autoscroll  filterable :loading="loading"
            />
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <date-range-picker
            ref="picker"
            :locale-data="{ firstDay: 1, format: 'dd-mm-yyyy HH:mm:ss' }"
            :minDate="minDate" :maxDate="maxDate"
            v-model="dateRange"
            @update="updateValues()"

        >
          <template v-slot:input="picker" style="min-width: 350px;">
            {{ startDate }} - {{ endDate }}
          </template>
        </date-range-picker>
      </div>
      <div class="col-md-2">
        <a href="javascript:void(0)" type="btn" class="btn btn-danger" @click="resetFilters"> Reset Filters</a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 mb-5" v-if="timetables.length > 0" v-for="timetable in this.timetables" :key="timetable.id">
        <!--begin::Card-->
        <div class="card card-custom card-stretch">
          <div class="card-header">
            <div class="card-title">
              <h3 class="card-label">{{ timetable.date }} <br> <small>{{ timetable.date_name }}</small></h3>
            </div>
          </div>
          <div class="card-body">
              <ul>
                  <li v-for="pharmacy in timetable.pharmacies" :key="pharmacy.pharmacy_id" class="list pb-3"  >
                    <div><label class="text-info mb-1">Pharmacy Name: </label> {{pharmacy.pharmacy}}</div>
                    <div><label class="text-info mb-1">Time Range: </label>{{pharmacy.time_slot}}</div>
                  </li>
              </ul>
          </div>
        </div>
        <!--end::Card-->
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

export default {
  name:"dashboard",
  components: { DateRangePicker, vSelect },
  data(){
    return {
      user:this.$store.state.auth.user,
      timetables: [],
      minDate:null,
      maxDate:null,
      startDate:'',
      endDate:'',
      dateRange:{},
      options:[],
      selected:'',
      loading:true

    }
  },
  watch:{
    selected(val){
      this.search(val)
    }
  },
  methods:{
    getUserTimeTable(url){
      axios.get(url)
           .then((response)=>{
               this.timetables = response.data.data
            })
            .catch(error=>console.log(error))
    },
    updateValues(){
      let url ='/user-timetable/'+this.user.id+`?start_date=${this.convert(this.dateRange.startDate)}&end_date=${this.convert(this.dateRange.endDate)}`
      this.getUserTimeTable(url)
    },
     convert(str) {
        var date = new Date(str),
        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
        day = ("0" + date.getDate()).slice(-2);
        return [date.getFullYear(), mnth, day].join("-");
     },
    getAllPharmacies(){
      axios.get('/pharmacies')
          .then((response)=>{
            response.data.data.map((element, index)=>{
               this.options.push({ id: element.id, label: element.name })
            })
            this.loading=false
          })
          .catch(error=>console.log(error))
    },
    resetFilters(){
      this.getUserTimeTable('/user-timetable/'+this.user.id)
      this.selected = ''
    },
    search(val){
      this.getUserTimeTable('/user-timetable/'+this.user.id+`?pharmacy_id=${val}`)
    }
},
  mounted() {
    this.getUserTimeTable('/user-timetable/'+this.user.id)
    this.getAllPharmacies()
  }
}
</script>
<style>
    .list{
      list-style-type: none;
    }
    ul{
      padding: 0;
    }
    li label{
      font-weight: 500;padding-right: 3px;
    }
    .calendars-container{
      position: absolute;
      left: 20%;
    }
</style>