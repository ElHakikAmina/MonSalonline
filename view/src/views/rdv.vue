<script setup>
import day from '../components/day.vue'
</script>

<template>
  <div class="bg-slate-200 py-7 m-auto w-5/6 ">
    <div class="lato  text-center mb-5 text-2xl font-bold">Checkez la disponibilité des horaires et prenez votre rendevez
      maintenant!</div>
    <div>
      <day v-for="d in currentMonth" :d="d" />
    </div>
  </div>
</template>

<script>
export default {
  name: "AjoutReservation",
  data() {
    return {
      dateToday: "",
      stokes: {},
      currentMonth: [],
      time_on: "",
      time_out: "",
      jour: "",
      id: undefined,
      id_reservation: undefined,
      toDashboard: false,
      DayName: "",
      rp: "",
    };
  },
  mounted() {
    if (!sessionStorage.getItem("reference"))
      window.location = "/";
    let testdate = new Date()
    for (let i = 0; i < 30; i++) {
      let dateToday = new Date();
      var day = dateToday.setDate(dateToday.getDate() + i);
      var Daydate = dateToday.getFullYear() + "-" + (dateToday.getMonth() + 1) + "-" + dateToday.getDate();
      this.jour = Daydate;
      var DayInfo = {
        "dayName": this.getDayName(Daydate, "en-GB"),
        "Daydate": Daydate
      }
      this.currentMonth.push(DayInfo);
    }
  },
  methods: {

    //-------------DayName--------------------------
    getDayName(dateStr, locale) {
      var date = new Date(dateStr);
      return date.toLocaleDateString(locale, { weekday: 'long' });
    },
    checkAuth() {
      if (sessionStorage.getItem("reference")) alert("reference");
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
        DayName: this.DayName,
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
        reference: sessionStorage.getItem("reference"),
      };

      // Check if the client has already made a reservation for this day
      const reservations = JSON.parse(sessionStorage.getItem(`${data.reference}-${data.jour}`) || "[]");
      if (reservations.length > 0) {
        alert("Vous avez déjà effectué une réservation pour ce jour.");
        return;
      }

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
        // Add the reservation to the browser's session storage
        reservations.push(data);
        console.log(reservations.push(data));
        console.log(1);
        sessionStorage.setItem(`${data.reference}-${data.jour}`, JSON.stringify(reservations));

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
      this.id_reservation = sessionStorage.getItem("id_reservation");
    }
  },
};
</script>
