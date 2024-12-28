import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import MainPastelView from '@/views/pastelViews/MainPastelView.vue'
import CrearPastelView from '@/views/pastelViews/CrearPastel.view.vue'
import AgregarIngredientes from '@/components/AgregarIngredientes.vue'
import MostrarPastelView from '@/views/pastelViews/MostrarPastelView.vue'
import MainIngredienteView from '@/views/ingredientesViews/MainIngredienteView.vue'
import MostrarIngredienteView from '@/views/ingredientesViews/MostrarIngredienteView.vue'
import NotFoundView from '@/views/NotFoundView.vue'
import CrearIngredienteView from '@/views/ingredientesViews/CrearIngredienteView.vue'
import ReporteView from '@/views/ReporteView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/pasteles',
      name: 'main-pasteles',
      component: MainPastelView,
    },
    {
      path: '/pastel/crear',
      name: 'crear-pastel',
      component: CrearPastelView,
    },
    {
      path: '/pastel/:id',
      name: 'mostar-pastel',
      component: MostrarPastelView,
    },
    {
      path: '/pastel/:id/agregar-ingredientes',
      name: 'agregar-ingredientes',
      component: AgregarIngredientes,
    },
    {
      path: '/ingredientes',
      name: 'Ingredientes',
      component: MainIngredienteView,
    },
    {
      path: '/ingrediente/crear',
      name: 'crear-ingrediente',
      component: CrearIngredienteView,
    },
    {
      path: '/ingrediente/:id',
      name: 'mostrar-ingrediente',
      component: MostrarIngredienteView,
    },

    {
      path: '/reportes',
      name: 'mostrar-reportes',
      component: ReporteView,
    },
    { path: "/:pathMatch(.*)*", name: "NotFound", component: NotFoundView },
  ],
})

export default router
