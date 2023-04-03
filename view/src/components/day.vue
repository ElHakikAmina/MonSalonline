<script>
import Hour from './Hour.vue'
export default {
  props: ['d'],
  components: {
    Hour
  },
  methods: {
    async chekCreneau() {
      //   console.log(sessionStorage.getItem("pageAjouter"));
      //   console.log(sessionStorage.getItem("pageUpdate"));
      //-------------DayName--------------------------

      //this.DayName = this.getDayName(this.jour, "en-GB");
      //---------------------------------------------

      const data = {
        jour: this.d.Daydate,
        DayName: this.d.dayName,
      };
      //console.log(data);

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
        //console.log(this.stokes);
        this.checkApiCallsComplete();
      }
    },
    async getAllRDV() {
      //   console.log(sessionStorage.getItem("pageAjouter"));
      //   console.log(sessionStorage.getItem("pageUpdate"));
      //-------------DayName--------------------------

      //this.DayName = this.getDayName(this.jour, "en-GB");
      //---------------------------------------------

      const data = {
        jour: this.d.Daydate,
      };
      //console.log(data);

      var res = await fetch(
        "http://localhost/monsalonline/ApiCrudsReservation/getAllRDV",
        {
          method: "POST",
          header: "Content-type: application/json",

          body: JSON.stringify(data),
        }
      );

      if (res.status === 200) {
        this.rdv = await res.json();
        //console.log(this.rdv);
        this.checkApiCallsComplete();
        
  
      }
    },
    checkApiCallsComplete() {
      // Check whether both API calls have completed
      if (this.stokes && this.rdv) {
        this.apiCallsComplete = true;
      }
    },

  },
  
  mounted() {
  
      this.chekCreneau()
      this.getAllRDV()
  },

  data() {
    return {
      stokes: null,
      rdv: null,
      apiCallsComplete: false,
    }
  }
}
</script>

<template>
  <div>
    <h1>{{ d.dayName + " " + d.Daydate }}</h1>
    <Hour v-if="apiCallsComplete" v-for="stoke in this.stokes" :hour="stoke" :rdv="this.rdv" :day="this.d.Daydate" />
  </div>
</template>
