<template>
    <div>
    <table class="min-w-full md:table">
		<caption class="text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white">
            <p class="text-sm font-normal text-gray-500 dark:text-gray-400"></p>
        </caption>
		<thead class="block lg:table-header-group text-xs uppercase">
			<tr class="border border-grey-500 lg:border-none block md:table-row absolute -top-full lg:top-auto -left-full lg:left-auto  lg:relative ">
				<th scope="col" class="py-4" >Código</th>
				<th scope="col" class="py-4">Nombre</th>
				<th scope="col" class="py-4">Descripcion</th>
				<th scope="col" class="py-4">Preparado por</th>
				<th scope="col" class="py-4">Fecha creación</th>
				<th scope="col" class="py-4">Fecha Vencimiento</th>
				<th scope="col" class="py-4"></th>
			</tr>
		</thead>
		<tbody class="block md:table-row-group">
			<tr v-for="pastel in pasteles" :key="pastel.id_pastel" class="bg-white hover:opacity-75 cursor-default hover:bg-gray-100 hover:font-blod border-b block md:table-row">
				<td class="px-4 py-4  whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden hover:font-bold">Código</span>{{ pastel.id_pastel }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Nombre</span>{{ pastel.nombre }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Descripción</span>{{ pastel.descripcion }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Preparado por</span>{{ pastel.preparado_por }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Fecha Vencimiento</span>{{ pastel.fecha_creacion }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell"><span class="inline-block w-1/3 lg:hidden font-bold">Estado</span>{{ pastel.fecha_vencimiento }}</td>
				<td class="px-2 py-4 font-base whitespace-nowrap block lg:table-cell">
					<span class="inline-block w-1/3 lg:hidden font-bold">Actions</span>
					<router-link :to="`/pastel/${pastel.id_pastel}`" class="p-2  hover:bg-blue-700 text-blue-700 hover:text-white font-base py-1 px-2 border border-blue-500 rounded">Ver detalle</router-link>
				</td>
			</tr>		
		</tbody>
	</table>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TablaPastel',
    data() {
        return {
            pasteles: []
        };
    },
    mounted() {
        axios.get('http://localhost:8000/api/pastel')
            .then(response => {
                this.pasteles = response.data.pastel;
                console.log(this.pasteles);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }
};
</script>
  