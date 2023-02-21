<template>
    
    <div class="w-full md:w-2/3  my-40 lg:w-1/2 mx-auto">
        <span class="lato text-center mb-5 text-2xl font-bold">Connectez vous et prenez vos rendez vous!</span>
        <form action="" @submit.prevent="checkReference()">
            <input type="text" v-model="reference" class="h-10 my-5 rounded w-full border" placeholder="Entrer votre reference"> <br>
            <input type="submit" @click="redirection()" value="Connexion" class="my-5 bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"/>
        </form>
      
    </div>
</template>


<script>
export default {
  name: "Login",
  data() {
    return {
      reference: "",
      isAuth: false,
    };
  },
  methods: {
    async checkReference() {
      const reference = {
        reference: this.reference,
      };

      var res = await fetch("http://localhost/MonSalonline/apiUser/checkReference", {
        method: "POST",
        header: "Content-type: application/json",

        body: JSON.stringify(reference),
      });

      if (res.status === 200) {
        const result = await res.json();

        if (result.reference_existe == "true") {
          sessionStorage.setItem("reference", this.reference);

          this.isAuth = true;
          this.redirection();
        } else {
          this.isAuth = false;
        }
      }
    },
    redirection() {
      if (this.isAuth == true) {
        this.$router.push({ path: "/rdv" });
      } else {
        this.$router.push({ path: "/connexion" });
      }
    },
  },
};
</script>