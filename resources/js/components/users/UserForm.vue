<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">
            {{ isEdit ? "Modifier Utilisateur" : "Ajouter Utilisateur" }}
        </h1>
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
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
                <label class="block text-gray-700">Nom d'utilisateur</label>
                <input
                    v-model="form.username"
                    type="text"
                    class="w-full border p-2"
                    required
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Mot de passe</label>
                <input
                    v-model="form.password"
                    type="password"
                    class="w-full border p-2"
                    :required="!isEdit"
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Avatar</label>
                <input
                    type="file"
                    @change="handleFileUpload"
                    class="w-full border p-2"
                />
            </div>
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Enregistrer
            </button>
            <router-link to="/users" class="ml-4 text-gray-500"
                >Annuler</router-link
            >
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "UserForm",
    data() {
        return {
            form: {
                name: "",
                email: "",
                username: "",
                password: "",
                avatar: null,
            },
            isEdit: false,
        };
    },
    mounted() {
        if (this.$route.params.id) {
            this.isEdit = true;
            this.fetchUser();
        }
    },
    methods: {
        async fetchUser() {
            const response = await axios.get(
                `/api/users/${this.$route.params.id}`
            );
            this.form = { ...response.data, password: "" };
        },
        handleFileUpload(event) {
            this.form.avatar = event.target.files[0];
        },
        async submitForm() {
            const formData = new FormData();
            for (const key in this.form) {
                if (this.form[key] !== null && this.form[key] !== "") {
                    formData.append(key, this.form[key]);
                }
            }
            try {
                if (this.isEdit) {
                    await axios.post(
                        `/api/users/${this.$route.params.id}`,
                        formData,
                        {
                            headers: { "Content-Type": "multipart/form-data" },
                        }
                    );
                } else {
                    await axios.post("/api/users", formData, {
                        headers: { "Content-Type": "multipart/form-data" },
                    });
                }
                this.$router.push("/users");
            } catch (error) {
                alert("Erreur lors de l'enregistrement");
            }
        },
    },
};
</script>
