<template>
  <div  class="bg-slate-200 py-7 m-auto w-5/6 ">
    <!-- begin : popup for update reservation -->
    <div  v-if="popupUpdate">
      <div class="text-center">
        <label for="nom">Date*</label> <br>
        <input
        class="h-10 mb-5 rounded  border w-52"
          v-model="jourUpdate"
          @change="newfunction()"
          type="date"
          required
        />
      </div>
     
      <div class="text-center">
        <label for="prenom">Horaire*</label> <br>
        <select class="h-10 mb-5 rounded  border w-52"
         required v-model="timeUpdate">
         
          <option v-for="(stoke, index) in stokes" :value="stoke" :key="index">
            {{ stoke.time_on }} To {{ index }} {{ stoke.time_out }}
          </option>
        </select>
      </div>
      <div class="text-center">
        <button type="button" @click="update()" class="mb-10 mt-5 bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Sauvegarder
      </button>
      </div>
      
    </div>

    <!-- end : popup for update reservation -->
    <div class="lato  text-center mb-5 text-2xl font-bold">Vos Rendez vous</div>
    <div class="">
      <div class="">
        <div class="">
          <!-- to show alert -->
          <div class="card">
            <div class="card-body bg-light">
              <!-- the username and logout after click on it -->
              <!-- <a
                href="<?php echo BASE_URL;?>logout"
                title="DÃ©connexion"
                class="text-slate-900"
              >
                <i class="fas fa-user mr-20"> </i>
              </a> -->

              <table class="m-auto">
                <thead>
                  <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Time-on</th>
                    <th scope="col">Time-out</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="table in tables" :key="table.id_reservation">
                    <th scope="row">{{ table.jour }}</th>
                    <td>{{ table.time_on }}</td>
                    <td>{{ table.time_out }}</td>

                    <td class="d-flex flex-row">
                      <!-- update and deletete button -->

                      <button
                        @click="edit(table)"
                        class="my-5 mx-5 bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                      >
                        Modifier
                        <i class="fa fa-edit"></i>
                      </button>

                      <button
                        @click="deleteReservation(table.id_reservation)"
                        class="my-5 bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                      >
                        Suppression
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script >
import { Modal } from 'flowbite-vue'
export default {
  mounted() {
      if(!sessionStorage.getItem("reference"))
      window.location = "/";
      
    
  },
  name: "Dashboard",

  data() {
    return {
      time_on: "",
      time_out: "",
      jour: "",
      id_reservation: "",
      tables: {},
      pageUpdate: false,
      pageAjouter: false,
      jourUpdate: "",
      timeUpdate: {},
      popupUpdate: false,
      stokes: {},
    };
  },
  methods: {
    getDayName(dateStr, locale)
    {
      console.log(dateStr)
    var date = new Date(dateStr);
    return date.toLocaleDateString(locale, { weekday: 'long' });        
    },
    deleteReservation(id) {
      console.log(id);
      const data = {
        id_reservation: id,
      };

      var res = fetch(
        "http://localhost/monsalonline/ApiCrudsReservation/suppReservation",
        {
          method: "POST",
          header: "Content-type: application/json",

          body: JSON.stringify(data),
        }
      );
      if (res.status === 200) {
        const result = res.json();
        console.log(result.message);
      }
      this.getReservationsByReference();
    },
    update() {
      console.log(this.timeUpdate);
      const data = {
        jour: this.jourUpdate,
        time_out: this.timeUpdate.time_out,
        time_on: this.timeUpdate.time_on,
        id_reservation: this.id_reservation,
      };

      var res = fetch(
        "http://localhost/monsalonline/ApiCrudsReservation/updateReservation",
        {
          method: "POST",
          header: "Content-type: application/json",

          body: JSON.stringify(data),
        }
      );

      if (res.status === 200) {
        const result = res.json();
        console.log(result.message);
      } else {
        console.log("404");
      }

      this.popupUpdate = false;
      this.getReservationsByReference();
    },
    AjoutReseravtion() {
      this.pageAjouter = true;
      this.pageUpdate = false;
      this.redirection();
    },
   newfunction(){
    this.chekCreneau()
   },
    edit(table) {
      this.jourUpdate =table.jour
      this.newfunction()
      
      this.timeUpdate = {
        time_on: table.time_on,
        time_out: table.time_out,
      };
      this.stokes=[{
        time_on: table.time_on,
        time_out: table.time_out,
      }]

      this.jourUpdate = table.jour;
      this.popupUpdate = true;
      this.id_reservation = table.id_reservation;
 
      //console.log(this.timeUpdate);
    },
    redirection() {
      if (this.pageUpdate == true) {
        sessionStorage.setItem("pageAjouter", "");
        this.$router.push({ path: "/AjoutReservation" });
        sessionStorage.setItem("pageUpdate", "true");
      }

      if (this.pageAjouter == true) {
        sessionStorage.setItem("pageUpdate", "");
        this.$router.push({ path: "/AjoutReservation" });
        sessionStorage.setItem("pageAjouter", "true");
      }
    },

    async chekCreneau() {
      const data = {
        jour: this.jourUpdate,
        DayName: this.getDayName(this.jourUpdate, "en-GB"),
      };
      console.log(data)
     
      var res = await fetch(
        "http://localhost/monsalonline/ApiCrudsReservation/recupererAvailableCreneau",
        {
          method: "POST",
          header: "Content-type: application/json",

          body: JSON.stringify(data),
        }
      );

      if (res.status === 200) {
        this.stokes = await res.json();
       // console.log(this.stokes);
      }
    },

    async getReservationsByReference() {
      const reference = {
        reference: sessionStorage.getItem("reference"),
      };

      var res = await fetch(
        "http://localhost/monsalonline/ApiCrudsReservation/afficherReservation",
        {
          method: "POST",
          header: "Content-type: application/json",

          body: JSON.stringify(reference),
        }
      );
      if (res.status === 200) {
        this.tables = await res.json();
      }
    },
  },

  async created() {
    this.getReservationsByReference();
  },
};
</script>
