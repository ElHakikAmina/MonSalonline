<script>

export default {
  props: ['hour', 'day', 'rdv'],
  name: 'Hour',
  methods: {
    async inserer() {
      //console.log(sessionStorage.getItem("pageAjouter"));
      const data = {
        time_on: this.hour.time_on,
        time_out: this.hour.time_out,
        jour: this.day,
        reference: sessionStorage.getItem("reference"),
      };
      
      var res = await fetch(
        "http://localhost/monsalonline/ApiUser/inserteReservation",
        {
          method: "POST",
          header: "Content-type: application/json",
          body: JSON.stringify(data),
        }
      );

        
      
        //alert(result.message);
        
      if (res.status === 200) {
        //alert("reservation a été bien créer")
        const result = res.json();
        // this.message=result.message;
        // alert(this.message);
        location.reload();
      }
    },
  },

  mounted() {


    this.opening = parseInt(this.hour.time_on.split(":")[0]);
    this.closing = parseInt(this.hour.time_out.split(":")[0]);

    this.rdv.forEach(rdv => {

      if (this.opening == parseInt(rdv[0].split(":")[0])) {
        this.reserved = true
      }
    });

    /* console.log(this.rdv.includes(this.hour))
    this.rdv.forEach(rdv => {
        console.log(rdv)
    }); */
    //console.log(this.hour)
  },


  


  data() {
    return {
      opening: '',
      closing: '',
      reserved: '',
      // message: 'kkk',
    }
  }
}
</script>

<template>
  <button v-if="!this.reserved" @click="inserer" type="button"
    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">{{
      this.opening + ' - ' + this.closing }}</button>
  <button v-else type="button"
    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">{{
      this.opening + ' - ' + this.closing }}</button>
</template>
