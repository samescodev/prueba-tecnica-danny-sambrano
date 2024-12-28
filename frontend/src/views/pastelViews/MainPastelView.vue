<script>
import TablaPastel from '@/components/TablaPastel.vue';

export default {
  components: {
    TablaPastel,
  },
}
</script>

<template>
  <div>
    <div class="bg-white">
      <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-12">
          <h1 class="text-4xl font-bold tracking-tight text-gray-900">Lista de pasteles</h1>

          <div class="flex items-center">
            <div as="div" class="relative inline-block text-left">
              
					    <router-link :to="`/pastel/crear`" class="p-2  hover:bg-blue-700 text-blue-700 hover:text-white font-base py-1 px-2 border border-blue-500 rounded">Crear pastel</router-link>
            </div>
            </div>
        </div>
          </main>
      </div>
    <div class="bg-white p-10">
        <TablaPastel />
    </div>      
  </div>
 
</template>
