
<template>
          <span v-html="alert_msg"></span>
        <span v-html="alert_ref"></span>
    <div class="flex flex-row border p-5 rounded mx-5 mt-20">
        <div class="hidden md:block w-2/4">
            <img src="../assets/barbier2.jpg" class="w-full" alt="">
        </div>

        <div class="mx-auto w-full px-3 ml-5 md:w-2/4 lg:1/2">
            <div>
                <span class="lato text-center mb-5 text-2xl font-bold">Pour prendre un Rendez-vous enligne, Vous devez créer un compte.
                <br>
                Créez un maintenant!</span>
            </div>
            <form action="" @submit.prevent="inscriptionSubmit()">
                <input type="text" v-model="nom" placeholder="Nom" class="h-10 my-5 rounded w-full border" > <br>
                <input type="text" v-model="prenom" placeholder="Prenom" class="h-10 my-5 rounded border w-full"> <br>
                <input type="text" v-model="tel" placeholder="Numéro de téléphone" class="h-10 rounded border w-full"> <br>
                <input type="submit" value="Créer un Compte" class="my-5 bg-black hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            </form>
        </div>
    </div>
   

</template>




<script>
export default {
  name: "SignupForm",

  data() {
    return {
      nom: "",
      prenom: "",
      tel: "",
      reference: "",
      alert_msg: "",
      alert_ref: "",
    };
  },
  methods: {
    addTel() {
      console.log(this.tel);
    },
    async inscriptionSubmit() {
      const data = {
        nom: this.nom,
        prenom: this.prenom,
        tel: this.tel,
      };

      var res = await fetch("http://localhost/MonSalonline/apiUser/creatUser", {
        method: "POST",
        header: "Content-type: application/json",

        body: JSON.stringify(data),
      });

      if (res.status === 200) {
        console.log(res)
        //transformer les donness au niveau de la reponse au format object javascript
        const result = await res.json();
        if (result) {
          this.alert_msg = `<div
              class="alert alert-success d-flex align-items-center"
              role="alert"
            >
              <svg
                class="bi flex-shrink-0 me-2"
                width="24"
                height="24"
                role="img"
                aria-label="Success:"
              >
                <use xlink:href="#check-circle-fill" />
              </svg>
              <div> Félicitation Votre inscription est effectuer</div>
            </div>`;
          this.alert_ref = ` <div
              class="alert alert-primary d-flex align-items-center"
              role="alert"
            >
              <svg
                class="bi flex-shrink-0 me-2"
                width="24"
                height="24"
                role="img"
                aria-label="Info:"
              >
                <use xlink:href="#info-fill" />
              </svg>
              <div>votre code de reference est: ${result.reference}</div>
            </div>`;

        }
      }
    },
  },
};
</script>
