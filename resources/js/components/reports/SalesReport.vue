<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            Rapport des Ventes par Client et Produit
        </h1>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Client</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Produit</th>
                    <th class="border p-2">Quantité Vendue</th>
                    <th class="border p-2">Total Ventes</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="report in reports"
                    :key="report.client_id + '-' + report.product_id"
                >
                    <td class="border p-2">{{ report.client_name }}</td>
                    <td class="border p-2">{{ report.client_email }}</td>
                    <td class="border p-2">
                        {{ report.product_name || "Aucun produit" }}
                    </td>
                    <td class="border p-2">{{ report.total_quantity || 0 }}</td>
                    <td class="border p-2">{{ report.total_sales || 0 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "SalesReport",
    data() {
        return {
            reports: [],
        };
    },
    mounted() {
        this.fetchReports();
    },
    methods: {
        async fetchReports() {
            try {
                const response = await axios.get(
                    "/api/reports/sales-by-client-and-product"
                );
                this.reports = response.data;
            } catch (error) {
                alert(
                    "Erreur lors du chargement du rapport : " +
                        (error.response?.data?.error || "Veuillez réessayer")
                );
            }
        },
    },
};
</script>
