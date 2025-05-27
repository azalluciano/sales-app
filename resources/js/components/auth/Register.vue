<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Inscription</h1>
        <form @submit.prevent="register" enctype="multipart/form-data">
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
                <label class="block text-gray-700">Nom d'utilisateur</label>
                <input
                    v-model="form.username"
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
                <label class="block text-gray-700">Mot de passe</label>
                <input
                    v-model="form.password"
                    type="password"
                    class="w-full border p-2"
                    required
                    minlength="8"
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Avatar (optionnel)</label>
                <input
                    ref="avatarInput"
                    @change="handleAvatarChange"
                    type="file"
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    class="w-full border p-2"
                />
                <div v-if="avatarPreview" class="mt-2">
                    <img
                        :src="avatarPreview"
                        alt="Preview"
                        class="w-20 h-20 object-cover rounded"
                    />
                </div>
            </div>

            <button
                type="submit"
                :disabled="isLoading"
                class="bg-green-500 text-white px-4 py-2 rounded disabled:opacity-50"
            >
                {{ isLoading ? "Inscription..." : "S'inscrire" }}
            </button>

            <router-link to="/login" class="ml-4 text-blue-500">
                Se connecter
            </router-link>
        </form>
    </div>
</template>

<script>
import axios from "axios";
import { setAuth } from "../../auth";

export default {
    name: "Register",
    data() {
        return {
            form: {
                name: "",
                username: "",
                email: "",
                password: "",
            },
            avatarFile: null,
            avatarPreview: null,
            isLoading: false,
        };
    },
    methods: {
        handleAvatarChange(event) {
            const file = event.target.files[0];
            if (file) {
                // Vérifier la taille (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert(
                        "Le fichier est trop volumineux. Taille maximum : 2MB"
                    );
                    this.$refs.avatarInput.value = "";
                    return;
                }

                // Vérifier le type
                const allowedTypes = [
                    "image/jpeg",
                    "image/png",
                    "image/jpg",
                    "image/gif",
                ];
                if (!allowedTypes.includes(file.type)) {
                    alert(
                        "Type de fichier non autorisé. Utilisez JPEG, PNG, JPG ou GIF"
                    );
                    this.$refs.avatarInput.value = "";
                    return;
                }

                this.avatarFile = file;

                // Créer un aperçu
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.avatarPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.avatarFile = null;
                this.avatarPreview = null;
            }
        },

        async register() {
            this.isLoading = true;

            try {
                // Créer FormData pour envoyer les fichiers
                const formData = new FormData();

                // Ajouter les champs texte
                formData.append("name", this.form.name);
                formData.append("username", this.form.username);
                formData.append("email", this.form.email);
                formData.append("password", this.form.password);

                // Ajouter l'avatar s'il existe
                if (this.avatarFile) {
                    formData.append("avatar", this.avatarFile);
                }

                // Debug - voir ce qui est envoyé
                console.log("FormData contents:");
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                const response = await axios.post("/api/register", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                        Accept: "application/json",
                    },
                });

                // Sauvegarder le token et l'utilisateur
                localStorage.setItem("token", response.data.token);
                localStorage.setItem(
                    "user",
                    JSON.stringify(response.data.user)
                );
                setAuth(response.data.token, response.data.user);
                // Configurer axios pour les requêtes futures
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${response.data.token}`;

                alert("Inscription réussie !");
                this.$router.push("/");
            } catch (error) {
                console.error("Registration error:", error);

                let errorMessage = "Erreur lors de l'inscription";

                if (error.response?.data?.messages) {
                    // Erreurs de validation
                    const messages = error.response.data.messages;
                    errorMessage = Object.values(messages).flat().join(", ");
                } else if (error.response?.data?.error) {
                    errorMessage = error.response.data.error;
                } else if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                }

                alert(errorMessage);
            } finally {
                this.isLoading = false;
            }
        },
    },
};
</script>
