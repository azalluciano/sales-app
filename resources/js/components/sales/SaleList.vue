<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Liste des Ventes</h1>
        <router-link
            to="/sales/create"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block"
            >Ajouter Vente</router-link
        >
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Référence</th>
                    <th class="border p-2">Client</th>
                    <th class="border p-2">Total</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="sale in sales" :key="sale.id">
                    <td class="border p-2">{{ sale.reference }}</td>
                    <td class="border p-2">{{ sale.client.name }}</td>
                    <td class="border p-2">{{ sale.total }}</td>
                    <td class="border p-2">
                        <router-link
                            :to="'/sales/edit/' + sale.id"
                            class="text-blue-500 mr-2"
                            >Modifier</router-link
                        >
                        <button
                            @click="deleteSale(sale.id)"
                            class="text-red-500"
                        >
                            Supprimer
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "SaleList",
    data() {
        return {
            sales: [],
        };
    },
    mounted() {
        this.fetchSales();
    },
    methods: {
        async fetchSales() {
            const response = await axios.get("/api/sales");
            this.sales = response.data;
        },
        async deleteSale(id) {
            if (confirm("Voulez-vous vraiment supprimer cette vente ?")) {
                await axios.delete(`/api/sales/${id}`);
                this.fetchSales();
            }
        },
    },
};
</script>
