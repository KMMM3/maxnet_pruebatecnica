<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Lista de Tareas</h3>
            <router-link :to="{ name: 'tasks.create' }" class="btn btn-primary">Nueva Tarea</router-link>
        </div>
        
        <div v-if="loading" class="text-center">
            <p>Cargando tareas...</p>
        </div>
        
        <div v-else-if="tasks.length === 0" class="alert alert-info">
            No hay tareas disponibles.
        </div>
        
        <div v-else class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        <th>Email</th>
                        <th>Url</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="task in tasks" :key="task.id">
                        <td>{{ task.id }}</td>
                        <td>{{ task.titulo }}</td>
                        <td>{{ task.valor }}</td>
                        <td>{{ task.descripcion }}</td>
                        <td>{{ task.email }}</td>
                        <td>{{ task.url_referencia }}</td>
                        <td>
                            <router-link :to="{ name: 'tasks.edit', params: { id: task.id } }" class="btn btn-sm btn-info me-2">Editar</router-link>
                            <button @click="deleteTask(task.id)" class="btn btn-sm btn-danger">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TaskList',
    data() {
        return {
            tasks: [],
            loading: true
        }
    },
    created() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks() {
            this.loading = true;
            axios.get('/api/tasks')
                .then(response => {
                    this.tasks = response.data;
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        deleteTask(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                axios.delete(`/api/tasks/${id}`)
                    .then(() => {
                        this.fetchTasks();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
    }
}
</script>