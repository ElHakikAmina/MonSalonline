<template>
    <div class=" w-full bg-black inset-x-0 top-0 text-white p-4 mb-4 flex flex-col md:flex-row place-content-between">
        <div class="md:w-3/5 w-full"><RouterLink to="/home"><img src="../assets/logoSalon.png" class="mx-auto md:mx-0" style="width:150px"/></RouterLink></div>
        <div class=" md:w-3/5 lg:w-2/5 flex flex-row  place-content-between">
            <div class="my-auto delicia text-2xl"><RouterLink to="/connexion">Connexion</RouterLink></div>
            <div class="my-auto delicia text-2xl"><RouterLink to="/creercompte">Créer un compte</RouterLink></div>
            <div class="my-auto delicia text-2xl"><RouterLink to="/rdv">Prendre un rendez vous</RouterLink></div>
        </div>
    </div>
</template>
