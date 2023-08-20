<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import "datatables.net-select";

import axios from "axios";
DataTable.use(DataTablesCore);

let dt;
const table = ref();
const data = ref([]);

onMounted(function () {
  dt = table.value.dt;
});

const columns = [
  { data: "title", title: "Title" },
  { data: "url", title: "Url" },
  { data: "score", title: "Score" },
  { data: "time", title: "Time" },
];

const options = {
  pageLength: 10,
  select: true,
  dom: "pirtip",
};

// For each selected row find the data object in `data` array and remove it
function remove() {
  dt.rows({ selected: true }).every(function () {
    var rdata = this.data();

    router.visit("/deleteItem", {
      method: "post",
      data: {
        id: rdata.id,
      },
    });
  });
}
</script>

<template>
  <Head title="Items" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Items</h2>
    </template>


    <div class="py-12">
      <div class="max-w-10xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
        @click="remove">Delete selected row(s)</button> 

          <DataTable
            :columns="columns"
            :options="options"
            ref="table"
            ajax="getItems"/>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template >





