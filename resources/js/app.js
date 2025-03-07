import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './components/App.vue';
import TaskList from './views/TaskList.vue';
import TaskForm from './views/TaskForm.vue';

const routes = [
    { path: '/', component: TaskList, name: 'tasks.index' },
    { path: '/create', component: TaskForm, name: 'tasks.create' },
    { path: '/edit/:id', component: TaskForm, name: 'tasks.edit', props: true }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp(App);
app.use(router);
app.mount('#app');
