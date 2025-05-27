<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Liste des Clients</h1>
        <router-link
            to="/clients/create"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block"
            >Ajouter Client</router-link
        >
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nom</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Téléphone</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients" :key="client.id">
                    <td class="border p-2">{{ client.name }}</td>
                    <td class="border p-2">{{ client.email }}</td>
                    <td class="border p-2">{{ client.phone }}</td>
                    <td class="border p-2">
                        <router-link
                            :to="'/clients/edit/' + client.id"
                            class="text-blue-500 mr-2"
                            >Modifier</router-link
                        >
                        <button
                            @click="deleteClient(client.id)"
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
    name: "ClientList",
    data() {
        return {
            clients: [],
        };
    },
    mounted() {
        this.fetchClients();
    },
    methods: {
        async fetchClients() {
            const response = await axios.get("/api/clients");
            this.clients = response.data;
        },
        async deleteClient(id) {
            if (confirm("Voulez-vous vraiment supprimer ce client ?")) {
                await axios.delete(`/api/clients/${id}`);
                this.fetchClients();
            }
        },
    },
};
</script>
