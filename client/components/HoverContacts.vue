<template>
    <div class=" text-gold-500 justify-center rounded-sm px-4 py-2">
        <h1 class="text-xl">{{ name }}</h1>
        <div class="whitespace-nowrap text-right text-white hover:text-gold-300 p-1 flex">
            <div>
                <font-awesome-icon :icon="['fas', 'phone-alt']"  class="text-gold-500 mr-2 align-middle" /> 
            </div>
            <a :href="'tel:' + phone"> {{ phone }}</a>
        </div>
        <div class="whitespace-nowrap text-right text-white hover:text-gold-300 p-1 flex">
            <div>
                <font-awesome-icon :icon="['fas', 'envelope']"  class="text-gold-500 mr-2 align-middle" /> 
            </div>
            <a :href="'mailto:' + email">{{ email }}</a>
        </div>
        <div class="whitespace-nowrap text-right text-white hover:text-gold-300 p-1 flex">
            <div>
                <font-awesome-icon :icon="['fas', 'star']"  class="text-gold-500 mr-2 align-middle" /> 
            </div>
            <p>IČO: {{ ico }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['name', 'phone', 'email', 'ico' ],
    }
</script>

<style>

</style>