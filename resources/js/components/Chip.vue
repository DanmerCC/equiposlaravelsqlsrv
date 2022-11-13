<template>
    <span @click.stop="$emit('click')">
        <slot></slot>
        <div class="btn" @click.stop="$emit('close')">
            x
        </div>
    </span>
</template>

<script>
export default {};
</script>

<style scoped>
span {
    background-color: aquamarine;
    border-radius: 15px;
    border: solid 1px steelblue;
}
.btn:hover {
    transform: scale(1.3);
}
</style>
