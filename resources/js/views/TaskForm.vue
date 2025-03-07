<template>
    <div>
        <h3>{{ isEditing ? 'Editar Tarea' : 'Nueva Tarea' }}</h3>
        
        <form @submit.prevent="saveTask">
            <div>
                <label for="titulo" class="form-label">Título</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="titulo" 
                    maxlength="255"
                    v-model="task.titulo" 
                    :class="{ 'is-invalid': errors.titulo }"
                    required
                >
                <div v-if="errors.titulo" class="invalid-feedback">{{ errors.titulo[0] }}</div>
            </div>
            
            <div>
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea 
                    class="form-control" 
                    id="descripcion" 
                    v-model="task.descripcion"
                    :class="{ 'is-invalid': errors.descripcion }"
                    rows="3"
                ></textarea>
                <div v-if="errors.descripcion" class="invalid-feedback">{{ errors.descripcion[0] }}</div>
            </div>

            <div>
                <label for="valor" class="form-label">Valor</label>
                <input 
                    type="number" 
                    class="form-control" 
                    id="valor" 
                    v-model="task.valor" 
                    :class="{ 'is-invalid': errors.valor }"
                    required
                >
                <div v-if="errors.valor" class="invalid-feedback">{{ errors.valor[0] }}</div>
            </div>

            <div>
                <label for="email" class="form-label">Correo</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="email"
                    v-model="task.email" 
                    :class="{ 'is-invalid': errors.email }"
                    required
                >
                <div v-if="errors.email" class="invalid-feedback">{{ errors.email[0] }}</div>
            </div>

            <div>
                <label for="url_referencia" class="form-label">Url</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="url_referencia"
                    v-model="task.url_referencia" 
                    :class="{ 'is-invalid': errors.url_referencia }"
                    required
                >
                <div v-if="errors.url_referencia" class="invalid-feedback">{{ errors.url_referencia[0] }}</div>
            </div>
            
            <div>
                <router-link :to="{ name: 'tasks.index' }">Cancelar</router-link>
                <button type="submit" :disabled="loading">
                    {{ loading ? 'Guardando...' : 'Guardar' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TaskForm',
    props: {
        id: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            task: {
                titulo: '',
                descripcion: '',
                valor: 0,
                email: '',
                url_referencia: '',
                usuario_creador: 1,
            },
            errors: {},
            loading: false,
            isEditing: false
        }
    },
    created() {
        if (this.id) {
            this.isEditing = true;
            this.fetchTask();
        }
    },
    methods: {
        fetchTask() {
            axios.get(`/api/tasks/${this.id}`)
                .then(response => {
                    this.task = response.data;
                })
                .catch(error => {
                    console.error('Error fetching task:', error);
                    this.$router.push({ name: 'tasks.index' });
                });
        },
        saveTask() {
            this.loading = true;
            this.errors = {};
            
            const method = this.isEditing ? 'put' : 'post';
            const url = this.isEditing ? `/api/tasks/${this.id}` : '/api/tasks';
            
            axios[method](url, this.task)
                .then(() => {
                    this.$router.push({ name: 'tasks.index' });
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                    console.error('Error:', error);
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
}
</script>