<template>
    <a :href="url" :class="'nav-link ' + activeClass()"><slot></slot></a
></template>

<script>
export default {
    props: {
        url: {
            type: String,
            default: null
        }
    },
    methods: {
        activeClass() {
            return location.pathname == this.url ? "active" : "";
        }
    },
    mounted() {
        console.log(location.href);
    }
};
</script>

<style></style>
