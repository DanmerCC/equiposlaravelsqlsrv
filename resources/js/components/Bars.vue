<template>
    <Bar :chart-options="config" :chart-data="int_data" chart-id="barras"></Bar>
</template>

<script>
import { Bar } from "vue-chartjs/legacy";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

export default {
    components: {
        Bar
    },
    props: {
        groups: {
            type: Array
        },
        data: {
            type: Array
        },
        horizontal: {
            default: false
        },
        label:{
            type: String,
            default: ""
        }
    },
    data() {
        return {
            labels: null,
            config: {
                responsive: true,
                indexAxis: "y"
            },
            int_data: {
                labels: this.groups,
                datasets: [{ data: this.data ,label:this.label}]
            }
        };
    },
    methods: {
        render() {
            this.$nextTick(() => {
                var ctx = document.getElementById("mycanvas").getContext("2d");

                var mychart = new Chart(ctx, {
                    type: "bar",

                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                console.log(mychart);
            });
        }
    },
    mounted() {
        if (this.horizontal == true) {
            this.config.indexAxis = "y";
        }
        this.render();
    },
    created() {
        //this.render();
    }
};
</script>

<style></style>
