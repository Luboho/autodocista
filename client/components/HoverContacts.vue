<template>
    <div class=" text-gold-500 rounded-sm px-4 py-2">
        <h1 class="text-xl">{{ city }}</h1>
        <div class="whitespace-nowrap text-right text-white hover:text-gold-300 p-1 flex">
            <div>
                <font-awesome-icon :icon="['fas', 'phone-alt']"  class="text-gold-500 mr-2 align-middle" /> 
            </div>
            <a href="tel:+421903125678"> {{ phone }}</a>
        </div>
        <div class="whitespace-nowrap text-right text-white hover:text-gold-300 p-1 flex">
            <div>
                <font-awesome-icon :icon="['fas', 'envelope']"  class="text-gold-500 mr-2 align-middle" /> 
            </div>
            <a href="mailto:admin@admin.com">{{ email }}</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['city', 'phone', 'email' ],
    }
</script>

<style>

</style>