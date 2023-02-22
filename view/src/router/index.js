import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import creercompte from '../views/creercompte.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/connexion',
      name: 'connexion',
      component: () => import('../views/connexion.vue')
    },
    {
      path: '/creercompte',
      name: 'creercompte',
      component: creercompte
    },
    {
      path: '/',
      name: '',
      component: HomeView
    },
    {
      path: '/home',
      name: 'home',
      component: HomeView
    },
    {
      path: '/rdv',
      name: 'rdv',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/rdv.vue')
    },
    {
      path: '/dashboard',
      name: 'drashboard',
      
      component: () => import('../views/Dashboard.vue')
    }
  ]
})

export default router
