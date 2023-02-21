<template>
   

   <!-- begin : popup for update reservation -->
   <div v-if="popupUpdate" >
              <div class="form-group">
                <label for="nom">Date*</label>
                <input
                  v-model="jourUpdate"
                  @change="chekCreneau()"
                  type="date"
                  class="form-control"
                  required
                />
              </div>

            

              <div class="form-group">
                <label for="prenom">Horaire*</label>
                <select class="form-control" required v-model="timeUpdate">
                  <option
                    v-for="(stoke, index) in stokes"
                    :value="stoke"
                    :key="index"
                    >{{ stoke.time_on }} To {{ index }}
                    {{ stoke.time_out }}</option
                  >
                </select>
              </div>
              <button 
              type="button"
              @click="update()" class=" submit btn btn-primary">
                Modifier
              </button>
            </div>
   <!-- end : popup for update reservation -->

    <div class="container">
      <div class="row my-4">
        <div class="col-md-12 mx-auto">
          <!-- to show alert -->
          <div class="card">
            <div class="card-body bg-light">
            
              <!-- the username and logout after click on it -->
              <a
                href="<?php echo BASE_URL;?>logout"
                title="DÃ©connexion"
                class="btn btn-link mr-2 mb-2"
              >
                <i class="fas fa-user mr-20"> </i>
              </a>
  
              <table class="table table-hover">
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
                          class="btn btn-sm btn-warning"
                        >
                        Edit
                          <i class="fa fa-edit"></i>
                        </button>

                        <button
                        type="button"
                          @click="delete(table.id_reservation)"
                          class="btn btn-sm btn-danger"
                        >
                        Delete
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
  </template>
  
  <script>
  export default {
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
        jourUpdate:"",
        timeUpdate:{},
        popupUpdate:false,
        stokes: {},

    
      };
    },
    methods: {
      delete(id) {
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
      },
      update() {
        console.log(this.timeUpdate);
        const data = this.timeUpdate;
  
        var res = fetch(
          "http://localhost/monsalonline/ApiCrudsReservation/updateReservation",
          {
            method: "POST",
            header: "Content-type: application/json",
  
            body: JSON.stringify(this.timeUpdate),
          }
        );

        if (res.status === 200) {
          const result = res.json();
          console.log(result.message);
        }
        else{
            console.log("404")
        }
      },
      AjoutReseravtion() {
        this.pageAjouter = true;
        this.pageUpdate = false;
        this.redirection();
      },
  
      edit(table) {
        console.log(table)
        this.timeUpdate=table;
        this.jourUpdate=table.jour;
        this.popupUpdate=true
        this.id_reservation=table.id_reservation

        console.log(this.timeUpdate)
  
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
    //   console.log(sessionStorage.getItem("pageAjouter"));
    //   console.log(sessionStorage.getItem("pageUpdate"));
    //   console.log(12);
      const data = {
        jour: this.jour,
      };
      console.log(data.jour);
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
    },
  
    async created() {
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
  };
  </script>
  