<script setup>
import day from '../components/day.vue'
//
    // import {ref} from 'vue';
    // import flatPickr from 'vue-flatpickr-component';
    // import 'flatpickr/dist/flatpickr.css';

    // const date = ref(null);
    //
   
   
</script>


<template>
  
  <div class="bg-slate-200 py-7 m-auto w-5/6 ">
    
    <div class="lato  text-center mb-5 text-2xl font-bold">Checkez la disponibilité des horaires et prenez votre rendevez maintenant!</div>
    <div >
      <day v-for="d in currentMonth" :d="d" />

      <!-- <div class=" border py-1 m-2" v-for="d in currentMonth">
        {{ d.dayName + "   "+d.Daydate }}
        
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          v-for="(stoke, index) in stokes" :value="stoke" :key="index" @click="inserer()">
                      {{ stoke.time_on }} To {{ stoke.time_out }}
          </button>
      </div> -->
    </div>
  </div>
  <!-- <div class="bg-slate-200 py-7 m-auto w-5/6 ">
    <div class="lato  text-center mb-5 text-2xl font-bold">Checkez la disponibilité des horaires et prenez votre rendevez maintenant!</div>
    <div class="">
      <form @submit.prevent="inserer()">
        
              <div class="text-center">
                <label for="nom" class="lato font-bold">Choisissez une Date*</label> <br>
                <input
                  v-model="jour"
                  @change="chekCreneau()"
                  type="date"
                  class="h-10 my-5 rounded  border w-52"
                  required
                />
              </div>
              <br/>
              <div class="text-center">
                <div>
                     <button @click="inserer()"> 
                      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                      
                      v-for="(stoke, index) in stokes"
                    :value="stoke"
                    :key="index"
                    @click="inserer()"
                      >
                      {{ stoke.time_on }} To 
                    {{ stoke.time_out }}
                    </button> <br>
                    
                  </div> 
                 <label for="prenom" class="lato font-bold">Horaire*</label> <br>

                <select class="h-10 my-5 rounded  border w-52"
                 required v-model="id">
                  <option
                    v-for="(stoke, index) in stokes"
                    :value="stoke"
                    :key="index"
                    >{{ stoke.time_on }} To {{ index }}
                    {{ stoke.time_out }}</option
                  >
                </select> -->
              <!-- </div>
              <div class="text-center">
                <button class=" my-5 bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Reserver
              </button>
              </div>
              
            </form>
    </div> -->
    
  <!-- </div> -->
    
    
</template>
<script>
 export default {
 
 
  name: "AjoutReservation",
  data() {
    return {
      dateToday:"",
      stokes: {},
      currentMonth:[],
      time_on: "",
      time_out: "",
      jour: "",
      id: undefined,
      id_reservation: undefined,
      toDashboard: false,
      DayName:"",
      rp: "",
    };
  },
  mounted() {
      if(!sessionStorage.getItem("reference"))
      window.location = "/";
      let testdate = new Date()
      //console.log(testdate)
      for (let i=0;i<30;i++)
      {
        let dateToday=new Date();
        
        var day = dateToday.setDate(dateToday.getDate() + i);
        var Daydate= dateToday.getFullYear() +"-"+ (dateToday.getMonth() + 1 )+"-"+dateToday.getDate();
        //console.log(Daydate)
        this.jour=Daydate;
        //console.log("this.jour");
        //console.log(this.jour);
        var DayInfo ={
          "dayName" : this.getDayName(Daydate, "en-GB"),
          "Daydate" :  Daydate
        }
        //console.log(DayInfo.dayName)
        this.currentMonth.push(DayInfo);
        
      }
      
      
    
  },
  methods: {
    
     //-------------DayName--------------------------
     getDayName(dateStr, locale)
    {
    var date = new Date(dateStr);
    return date.toLocaleDateString(locale, { weekday: 'long' });        
    },
checkAuth()
{
  if(sessionStorage.getItem("reference")) alert("reference");
  console.log("fffffffff");
},
  //---------------------------------------------
    async chekCreneau() {
    //   console.log(sessionStorage.getItem("pageAjouter"));
    //   console.log(sessionStorage.getItem("pageUpdate"));
       //-------------DayName--------------------------
    
     this.DayName = this.getDayName(this.jour, "en-GB");
    //---------------------------------------------
    
      const data = {
        jour: this.jour,
        DayName:this.DayName,
      };
      console.log(data.jour);
      console.log(this.DayName);
      var res = await fetch(
        "http://localhost/monsalonline/ApiCrudsReservation/recupererCreneau",
        {
          method: "POST",
          header: "Content-type: application/json",

          body: JSON.stringify(data),
        }
      );

      if (res.status === 200) {
        this.stokes = await res.json();
        console.log(this.stokes);
      }
    },

    async inserer() {
        console.log(sessionStorage.getItem("pageAjouter"));
        const data = {
          time_on: this.id.time_on,
          time_out: this.id.time_out,
          jour: this.jour,
          //note: this.note,
          reference: sessionStorage.getItem("reference"),
        };
        console.log(data);
        var res = await fetch(
          "http://localhost/monsalonline/ApiUser/inserteReservation",
          {
            method: "POST",
            header: "Content-type: application/json",
            body: JSON.stringify(data),
          }
        );


        if (res.status === 200) {
            this.redirection();
        console.log(res)
        }

    },

    redirection() {
    //    rediger vers un autre url ou bien un autre componenet
        this.$router.push({ path: "/dashboard" });
      
    },
  },
  async created() {
    if (sessionStorage.getItem("pageUpdate") == "true") {
      console.log(sessionStorage.getItem("pageUpdate"));
      this.jour = sessionStorage.getItem("jour");
      //this.note = sessionStorage.getItem("note");
      this.id_reservation = sessionStorage.getItem("id_reservation");
    }
  },
};
</script>
