// Views
import Navbar from "./components/global/Navbar";
import Footer from "./components/global/Footer";
import Sidebar from "./components/global/Sidebar";
import Container from "./components/Container";
import Login from "./components/auth/Login";
import Register from "./components/auth/Register";
import PasswordReset from "./components/auth/PasswordReset";
import PasswordUpdate from "./components/auth/PasswordUpdate";
import EquiposTable from "./components/EquiposTable";
import UsuariosTable from "./components/UsuariosTable";
import AsesoresTable from "./components/AsesoresTable";
import MovilesTable from "./components/MovilesTable";
import ActasForm from "./components/ActasForm";
import MovilesForm from "./components/MovilesForm";

import {
    DataTable,
    Paginate,
    ModalComponent,
    Increaser,
    PreviewFile,
    CheckableItem,
    GroupCheckBox,
    DropDown,
    DropDownItem
} from "@danmerccoscco/personal";
import Bars from "./components/Bars";
import "vue-select/dist/vue-select.css";
import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";
import am5themes_Animated from "@amcharts/amcharts5/themes/Animated";
import Chart from "./components/Chart";
import Vue from "vue";
require("./bootstrap");

window.Vue = require("vue").default;

window.am4core = am5;
Vue.prototype.$serialize = (obj)=> {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}
const app = new Vue({
    el: "#app",
    components: {
        Chart,
        Bars,
        Container,
        Navbar,
        Sidebar,
        Footer,
        Login,
        Register,
        PasswordReset,
        PasswordUpdate,
        DataTable,
        EquiposTable,
        UsuariosTable,
        Paginate,
        AsesoresTable,
        MovilesTable,
        ActasForm,
        MovilesForm
    }
});
