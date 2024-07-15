<template>
    <section id="product_show">
        <div class="text-center">
            {{ product.name }}
        </div>
    </section>
</template>

<script>
    import productApi from '../api'

    export default {
        name: 'ProductView',
        components: {},
        data() {
            return {
                product: {},
            }
        },
        methods: {
            async fetchProduct() {
                const response = await productApi.find(this.$route.params.id)
                this.product = response.data.data
            },
        },
        mounted() {
            this.fetchProduct()
        },
    }
</script>
