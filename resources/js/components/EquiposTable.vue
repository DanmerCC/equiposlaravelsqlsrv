<template>
    <span>
        <input ref="hiddenref" type="text" hidden/>
        <data-table
            ref="datatable"
            :select="true"
            :columns="columns"
            :items="items"
            :inload="onloading"
        >
            <template #top-options>

                <div class="container">
                    <div class="row">
                        <div class="col-4">
                            <button class="btn btn-primary" @click="openNewModal()">
                                Agregar
                            </button>
                        </div>
                        <div class="col-4">

                            <AsesorSelector placeholder="Equipos"></AsesorSelector>
                        </div>
                    </div>
                </div>
                <Chip v-if="asignadosFilter" @close="asignadosFilter = false"
                    >Asignados
                </Chip>
                <Chip
                    v-for="(grupo, index) in Object.keys(grupoFilters)"
                    :key="index"
                    @close="
                        delete grupoFilters[grupo];
                        $refs.datatable.$forceUpdate();
                    "
                    >{{ grupo }}
                </Chip>
                <Chip
                    v-if="vacacionesFilter != null"
                    @close="
                        vacacionesFilter = null;
                        $refs.datatable.$forceUpdate();
                    "
                >
                    {{ !vacacionesFilter ? "Laborando" : "Vacaciones" }}
                </Chip>
                <Chip v-if="libresFilter" @close="libresFilter= false;$refs.datatable.$forceUpdate();">
                    Libres
                </Chip>
                <Chip v-if="malogradosFilter" @close="malogradosFilter= false;$refs.datatable.$forceUpdate();">
                    Malogrados
                </Chip>
                <Chip v-if="disponibleFilter" @close="disponibleFilter= false;$refs.datatable.$forceUpdate();">
                    Disponibles
                </Chip>
                <div class="float-right border border-primary">
                    <div
                        title="Buscar equipo"
                        class="input-group input-group-sm"
                        style="width: 300px;"
                    >
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Buscar "
                            class="form-control"
                        />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <template #dni="{item,row}">
                <span v-if="row.asesor != null">
                    {{ row.asesor.dni }}
                </span>
                <span v-else>
                    -
                </span>
            </template>
            <template #equipo="{item,row}">
                <span v-if="row.asesor != null">
                    {{ row.asesor.equipo.nombres }}
                    {{ row.asesor.equipo.apellido_paterno }}
                    {{ row.asesor.equipo.apellido_materno }}
                </span>
                <span v-else>
                    -
                </span>
            </template>
            <template #asesor="{item,row}">
                <button v-if="item != null" @click="editAsesor(row)" class="btn btn-sm btn-info">

                    {{ item.nombres }}
                </button>
                <button v-else class="btn btn-sm" @click="editAsesor(row)">
                    <span >
                        Sin Asignar
                    </span>
                </button>
            </template>
            <template #supervisor="{item,row}">
                <button  v-if="item != null" @click="editSupervisor(row)" class="btn btn-sm btn-info">

                    {{ item.nombres }}
                </button>
                <button v-else class="btn btn-sm" @click="editSupervisor(row)">
                    <span >
                        Sin Asignar
                    </span>
                </button>
            </template>
            <template #opciones="{item,row}">
                <button class="btn btn-info" @click="equipoEdit(row)">editar</button>
                <button class="btn btn-danger" @click="eliminarEquipo(row)">eliminar</button>
            </template>
            <template #estado="{item,row}">
                <button v-if="item=='OPERATIVO'" class="btn btn-sm" @click="cambioEstado(row,'MALOGRADO')">{{item}}</button>
                <button v-else class="btn btn-sm btn-danger" @click="cambioEstado(row,'OPERATIVO')">{{ item }}</button>
            </template>
        </data-table>
        <select v-model="perPage">
            <option :value="10">10</option>
            <option :value="15">15</option>
            <option :value="50">50</option>
            <option :value="150">150</option>
        </select>
        <paginate v-model="page" @change="changePage($event)"></paginate>
        <div class="row">
            <div class="col-12">
                Mostrando {{ items.length }} de  {{ total}}
            </div>
        </div>
        <modal-component
            v-if="newEquipoOBject != null"
            @close="newEquipoOBject = null"
        >
            <template #body>
                <equipos-form
                    @changes="newEquipoOBject = $event"
                ></equipos-form>
            </template>
            <template #footer>
                <button class="btn btn-primary" @click="crearEquipo()">
                    Guardar
                </button>
            </template>
        </modal-component>
        <modal-component
            v-if="asesorEditInfo != null"
            @close="asesorEditInfo = null"
        >
            <template #body>
                <div class="row">
                    <asesor-selector
                        class="col-12"
                        v-model="asesorEditInfo.changed"
                    ></asesor-selector>
                </div>
            </template>
            <template #footer>
                <button
                    class="btn btn-primary"
                    :disabled="asesorEditInfoDiferent"
                    @click="updateAsesor()"
                >
                    Guardar
                </button>
            </template>
        </modal-component>
        <modal-component
            v-if="supervisorEditInfo != null"
            @close="supervisorEditInfo = null"
        >
            <template #body>
                <div class="row">
                    <asesor-selector
                        class="col-12"
                        v-model="supervisorEditInfo.changed"
                    ></asesor-selector>
                </div>
            </template>
            <template #footer>
                <button
                    class="btn btn-primary"
                    :disabled="false"
                    @click="updateSupervisor()"
                >
                    Guardar
                </button>
            </template>
        </modal-component>
        <modal-component v-if="equipoDataEdit!=null" @close="equipoDataEdit = null">
            <template #body>
                <equipos-form :source="equipoDataEdit.original" @changes="equipoDataEdit.changes = $event"></equipos-form>
            </template>
            <template #footer>
                <button class="btn btn-secondary" @click="updateEquipo()">Guardar</button>
            </template>
        </modal-component>
    </span>
</template>

<script>
import { DataTable, ModalComponent, Paginate } from "@danmerccoscco/personal";
import EquiposForm from "./EquiposForm.vue";
import AsesorSelector from "./AsesorSelector.vue";
import Chip from "./Chip";
import axios from 'axios';

export default {
    components: {
        DataTable,
        ModalComponent,
        EquiposForm,
        AsesorSelector,
        Paginate,
        Chip,
    },
    computed: {
        asesorEditInfoDiferent() {
            if (this.asesorEditInfo == null) {
                return false;
            }

            if (this.asesorEditInfo.original == null) {
                return false;
            }
            if (this.asesorEditInfo.changed == null) {
                return false;
            }
            return (
                this.asesorEditInfo.original.id ==
                this.asesorEditInfo.changed.id
            );
        },
        supervisorEditInfoDiferent() {
            if (this.supervisorEditInfo == null) {
                return false;
            }
            if (this.supervisorEditInfo.original == null) {
                return false;
            }
            return (
                this.supervisorEditInfo.original.id ==
                this.supervisorEditInfo.changed.id
            );
        }
    },
    data() {
        return {
            total:null,
            disponibleFilter:false,
            malogradosFilter:false,
            libresFilter:false,
            onloading:false,
            perPage:15,
            equipoDataEdit:null,
            asignadosFilter: false,
            vacacionesFilter: null,
            grupoFilters: {},
            asesorEditInfo: null,
            supervisorEditInfo:null,
            newEquipoOBject: null,
            search: null,
            page: 1,
            columns: [
                {
                    name: "Dni",
                    value: "dni"
                },
                {
                    name: "Nombre",
                    value: "asesor"
                },
                {
                    name: "Equipo",
                    value: "supervisor"
                },
                /*{
                    name: "Equipo",
                    value: "equipo"
                },*/
                {
                    name: "Estado",
                    value: "estado"
                },
                {
                    name: "Serie",
                    value: "serie"
                },

                {
                    name: "Marca",
                    value: "marca"
                },
                {
                    name: "Modelo",
                    value: "modelo"
                },
                {
                    name: "Color",
                    value: "color"
                },
                {
                    name: "Antiguedad",
                    value: "antiguedad"
                },
                {
                    name: "Precio",
                    value: "precio"
                },
                {
                    name: "Procesador",
                    value: "procesador"
                },
                {
                    name: "Memoria",
                    value: "memoria"
                },
                {
                    name: "Disco duro",
                    value: "tipo_disco"
                },
                {
                    name: "Disco duro",
                    value: "capacidad_disco_duro"
                },
                {
                    name: "Fehca de compra",
                    value: "fecha_compra"
                },
                {
                    name: "Observacion",
                    value: "observacion"
                },
                {
                    name: "Opciones",
                    value: "opciones"
                }
            ],
            items: []
        };
    },
    methods: {
        cambioEstado(equipo,state){
            console.log(equipo)
            if(!confirm("Esta seguro de cambiar a 'Malogrado'?"))return
            axios
                .put(`/api/equipos/${equipo.id}`, {estado:state})
                .then(result => {
                    this.loadData();
                })
                .catch(err => {
                    console.error(err);
                });
        },
        disponibles(){
            this.disponibleFilter = true
            this.$refs.datatable.$forceUpdate();
        },
        updateEquipo(){
            axios
                .put(`/api/equipos/${this.equipoDataEdit.original.id}`, this.equipoDataEdit.changes)
                .then(result => {
                    this.loadData();
                    this.equipoDataEdit = null;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        equipoEdit(equipo){
            this.equipoDataEdit = {
                original:Object.assign({},equipo),
                changes:null
            }
        },
        eliminarEquipo(equipo){
            if(!confirm("Estas seguro de querer eliminar este equipo?"))return
            axios.delete('/api/equipos/'+equipo.id).then((result) => {
                this.loadData()
            }).catch((err) => {

            });
        },
        crearEquipo() {
            axios
                .post(`/api/equipos`, this.newEquipoOBject)
                .then(result => {
                    this.loadData();
                    this.newEquipoOBject = null;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        malogrados(value=true ){
            console.log("malogrados:"+value);
            this.malogradosFilter = value
            this.$refs.datatable.$forceUpdate();
        },
        asigandos(value =false){
            this.asignadosFilter = value;
            this.$refs.datatable.$forceUpdate();
        },
        libres(){
            this.libresFilter = true
            //console.log(this.libresFilter)
            this.$refs.datatable.$forceUpdate();
        },
        toggleAsignacionFilter() {
            this.asignadosFilter = !this.asignadosFilter;
            this.$refs.datatable.$forceUpdate();
        },
        toggleVacacionesFilter(value) {
            if (typeof value == "boolean") {
                this.vacacionesFilter = value;
            }

            if (value === null) {
                this.vacacionesFilter = null;
            }
            this.$refs.datatable.$forceUpdate();
        },
        toggleGruposFilter(index,value) {
            if (typeof this.grupoFilters[index] == "undefined") {
                this.grupoFilters[index] = value;
            } else {
                delete this.grupoFilters[index];
            }
            this.$refs.datatable.$forceUpdate();
            this.loadData();
        },
        changePage($event) {
            console.log($event);
            let lastPage = this.page;
            this.page = $event;
            this.loadData()
                .then(result => {
                    //this.page = $event;

                })
                .catch(() => {
                    this.page = lastPage;
                });
        },
        updateAsesor() {
            axios
                .put("/api/equipos/" + this.asesorEditInfo.row.id, {
                    asesor_id:  this.asesorEditInfo.changed == null?null: this.asesorEditInfo.changed.id
                })
                .then(({ data }) => {
                    this.asesorEditInfo = null;
                    this.loadData();
                });
        },
        updateSupervisor() {
            axios
                .put("/api/equipos/" + this.supervisorEditInfo.row.id, {
                    supervisor_id: this.supervisorEditInfo.changed.id
                })
                .then(({ data }) => {
                    this.supervisorEditInfo = null;
                    this.loadData();
                });
        },
        editAsesor(equipo) {
            if (equipo.asesor == null) {
                this.asesorEditInfo = {
                    original: null,
                    changed: null,
                    row: equipo
                };
            } else {
                this.asesorEditInfo = {
                    original: Object.assign({}, equipo.asesor),
                    changed: equipo.asesor,
                    row: equipo
                };
            }
        },
        editSupervisor(equipo) {
            if (equipo.supervisor == null) {
                this.supervisorEditInfo = {
                    original: null,
                    changed: null,
                    row: equipo
                };
            } else {
                this.supervisorEditInfo = {
                    original: Object.assign({}, equipo.supervisor),
                    changed: equipo.supervisor,
                    row: equipo
                };
            }
        },
        openNewModal() {
            this.newEquipoOBject = {};
        },
        loadData() {
            this.onloading = true
            let config = {
                params: {
                    page: this.page,
                    perPage: this.perPage
                }
            };
            if (this.libresFilter) {
                config.params["noasigned"] = 1;
            }
            if (this.malogradosFilter) {
                config.params["malogrados"] = 1;
            }
            if (this.disponibleFilter) {
                config.params["disponibles"] = 1;
            }
            if (this.vacacionesFilter != null) {
                config.params["vacaciones_filter"] = this.vacacionesFilter;
            }
            if (Object.keys(this.grupoFilters).length > 0) {
                config.params["grupo"] = Object.keys(this.grupoFilters);
            }
            if (this.search != null && this.search != "") {
                config.params["search"] = this.search;
            }

            return new Promise((resolve, reject) => {
                axios
                    .get("/api/equipos", config)
                    .then(({ data }) => {
                        this.items = data.data.data;
                        this.total = data.data.total;
                        resolve();
                        this.onloading = false
                        this.$refs.hiddenref.focus();
                    })
                    .catch(error => {
                        reject();
                        this.onloading = false
                    });
            });
        }
    },
    mounted() {
        this.loadData();
    },
    watch: {
        malogradosFilter(val){
            this.loadData();
        },
        disponibleFilter(val){
            this.loadData();
        },
        libresFilter(val){
            this.loadData();
        },
        perPage(newVal) {
            this.loadData();
        },
        search(newVal) {
            this.loadData();
        },

        asignadosFilter(newVal) {
            this.loadData();
        },
        vacacionesFilter(newVal) {
            this.loadData();
        },
        grupoFilters: {
            handler(newVal) {
                this.loadData();
            },
            deep: true
        }
    }
};
</script>

<style></style>
