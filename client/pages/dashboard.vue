<template>
    <div class="h-auto p-4">
        <div class="my-5 mx-auto px-4 py-8 bg-gray-500 rounded border border-gold-500">
            <ContactFormMessages />
        </div>
    </div>
</template>

<script>
import ContactFormMessages from '../components/ContactFormMessages'
 
export default {
    name: "dashboard",

    components: {
        ContactFormMessages
    }
}
</script>

<style>

</style>