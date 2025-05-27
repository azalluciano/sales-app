<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Liste des Utilisateurs</h1>
        <router-link
            to="/users/create"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block"
            >Ajouter Utilisateur</router-link
        >
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">Nom</th>
                    <th class="border p-2">Email</th>
                    <th class="border p-2">Nom d'utilisateur</th>
                    <th class="border p-2">Avatar</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td class="border p-2">{{ user.name }}</td>
                    <td class="border p-2">{{ user.email }}</td>
                    <td class="border p-2">{{ user.username }}</td>
                    <td class="border p-2">
                        <img
                            v-if="user.avatar"
                            :src="'/storage/' + user.avatar"
                            alt="Avatar"
                            class="w-12 h-12 object-cover"
                        />
                    </td>
                    <td class="border p-2">
                        <router-link
                            :to="'/users/edit/' + user.id"
                            class="text-blue-500 mr-2"
                            >Modifier</router-link
                        >
                        <button
                            @click="deleteUser(user.id)"
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
    name: "UserList",
    data() {
        return {
            users: [],
        };
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers() {
            const response = await axios.get("/api/users");
            this.users = response.data;
        },
        async deleteUser(id) {
            if (confirm("Voulez-vous vraiment supprimer cet utilisateur ?")) {
                await axios.delete(`/api/users/${id}`);
                this.fetchUsers();
            }
        },
    },
};
</script>
