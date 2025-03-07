<template>
    <div class="container py-4" style="background-color: #fff; color: #212529;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">Sistema de Gestión de Tareas</h2>
                    </div>
                    <div class="card-body">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'App'
}
</script>