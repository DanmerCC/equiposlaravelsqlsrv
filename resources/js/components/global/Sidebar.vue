<template>
    <div>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Control de Equipos</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                <a href="#" class="d-block">{{ user.name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                    <li class="nav-item">

                        <Alink url="/home">

                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                            </a>
                        </Alink>
                    </li>
                    <li class="nav-item">

                        <Alink url="/equipos">

                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Equipos</p>
                        </Alink>
                    </li>
                    <li class="nav-item">
                    <Alink url="/moviles">
                        <i class="fa fa-mobile" aria-hidden="true"></i>
                        <p>Moviles</p>
                    </Alink>
                    </li>
                    <li class="nav-item">

                        <Alink url="/asesores">

                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Asesores</p>
                        </Alink>
                    </li>
                    <li class="nav-item">

                        <Alink url="/usuarios">

                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Usuarios</p>
                        </Alink>
                    </li>
                    <li class="nav-item">
                        <Alink url="/graficos">

                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Graficos</p>
                        </Alink>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
    </div>
</template>

<script>
import Alink from './ALink'
import ALink from './ALink.vue'
export default {
    name: "Sidebar",
    props: ['user', 'route'],
    components: {
        Alink
    }
}
</script>
