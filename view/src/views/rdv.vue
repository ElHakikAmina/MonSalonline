<script setup>
//
    import {ref} from 'vue';
    import flatPickr from 'vue-flatpickr-component';
    import 'flatpickr/dist/flatpickr.css';

    const date = ref(null);
    //

   
</script>

<template>
    <!-- Selectioner une date : 
    <flat-pickr class="border rounded" v-model="date"/>
    {{ date }} -->
    <br><br><br><br><br><br><br><br>
    <form @submit.prevent="inserer()">
              <div class="form-group">
                <label for="nom">Date*</label>
                <input
                  v-model="jour"
                  @change="chekCreneau()"
                  type="date"
                  class="form-control"
                  required
                />
              </div>

              

              <div class="form-group">
                <label for="prenom">Horaire*</label>
                <select class="form-control" required v-model="id">
                  <option
                    v-for="(stoke, index) in stokes"
                    :value="stoke"
                    :key="index"
                    >{{ stoke.time_on }} To {{ index }}
                    {{ stoke.time_out }}</option
                  >
                </select>
              </div>
              <button class=" submit btn btn-primary">
                Reserver
              </button>
            </form>
</template>
<script>
 export default {
  name: "AjoutReservation",
  data() {
    return {
      stokes: {},
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
  methods: {
     //-------------DayName--------------------------
     getDayName(dateStr, locale)
{
    var date = new Date(dateStr);
    return date.toLocaleDateString(locale, { weekday: 'long' });        
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
