<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            {{ isEdit ? "Modifier Client" : "Ajouter Client" }}
        </h1>
        <form @submit.prevent="submitForm">
            <div class="mb-4">
                <label class="block text-gray-700">Nom</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="w-full border p-2"
                    required
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    class="w-full border p-2"
                    required
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Téléphone</label>
                <input
                    v-model="form.phone"
                    type="text"
                    class="w-full border p-2"
                />
            </div>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Enregistrer
            </button>
            <router-link to="/clients" class="ml-4 text-gray-500"
                >Annuler</router-link
            >
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ClientForm",
    data() {
        return {
            form: {
                name: "",
                email: "",
                phone: "",
            },
            isEdit: false,
        };
    },
    mounted() {
        if (this.$route.params.id) {
            this.isEdit = true;
            this.fetchClient();
        }
    },
    methods: {
        async fetchClient() {
            const response = await axios.get(
                `/api/clients/${this.$route.params.id}`
            );
            this.form = response.data;
        },
        async submitForm() {
            try {
                if (this.isEdit) {
                    await axios.put(
                        `/api/clients/${this.$route.params.id}`,
                        this.form
                    );
                } else {
                    await axios.post("/api/clients", this.form);
                }
                this.$router.push("/clients");
            } catch (error) {
                alert("Erreur lors de l'enregistrement");
            }
        },
    },
};
</script>
