<template>
    <div>
        <section class="structured-search">
            <form :action="url" method="get" class="structured-search-form">
                <h1 class="font-light">What is your dream bike?</h1>
                <div class="form-group">
                    <multiselect
                        id="brand_id"
                        v-model="brand"
                        :value="brand"
                        label="name"
                        track-by="name"
                        :searchable="true"
                        :allow-empty="true"
                        :options="brands"
                        placeholder="Brands"
                        :multiple="false"
                        :limit="4"
                        :show-no-results="true"
                        :hide-selected="true"
                        key="id"
                        @input="fetchData"
                    >
                    </multiselect>
                    <input type="hidden" name="brand" :value="JSON.stringify(brand) ">
                </div>

                <div class="form-group">
                    <multiselect
                        name="model"
                        v-model="model"
                        :value="model"
                        label="name"
                        track-by="name"
                        :searchable="true"
                        :allow-empty="true"
                        :options="models"
                        placeholder="Models"
                        :multiple="false"
                        :limit="4"
                        :show-no-results="true"
                        :hide-selected="true"
                        @input="changeSelect"
                    >
                    </multiselect>
                    <input type="hidden" name="model" :value="JSON.stringify(model) ">
                </div>

                <button type="submit" class="btn btn_green">Lets go</button>
                <a href="#" class="btn btn_green" data-hystmodal="#add-my-bike">My bike is not listed</a>
            </form>

            <picture class="structured-bg">
                <source srcset="/img/structured-bg-2.webp" type="image/webp">
                <source srcset="/img/structured-bg-2.jpg" type="image/jpg">
                <img src="/img/structured-bg-2.jpg" alt="" width="1920" height="455">
            </picture>

        </section>

        <div class="hystmodal add-bike-modal" id="add-my-bike" aria-hidden="true">
            <div class="hystmodal__wrap">
                <div class="hystmodal__window text-center" role="dialog" aria-modal="true">
                    <button data-hystclose class="hystmodal__close">Close</button>

                    <form :action="url2" method="POST">
                        <h2 class="font-light">Add my bike</h2>
                        <input type="hidden" name="_token" :value="token">
                        <div class="form-group">
                            <input type="test" name="brand" placeholder="Brand" class="form-control" aria-label="Brand">

                        </div>
                        <div class="form-group">
                            <input type="test" name="model" placeholder="Model" class="form-control" aria-label="Model">

                        </div>
                        <div class="form-group">
                            <input type="test" name="year" placeholder="Year" class="form-control" aria-label="Year">

                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="E-mail" class="form-control"
                                   aria-label="E-mail">
                        </div>
                        <button type="submit" class="btn btn_green">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        components: {
            Multiselect
        },
        data() {
            return {
                brand: [],
                model: [],
                models: [],
                // years: null,
                model_val: null,
                brand_val: null,
                year_val: null,
                error: null,
                token: $('meta[name="csrf-token"]').attr('content'),
            }
        },
        name: "SearchComponent",
        props: [
            'brands',
            'url',
            'url2'
        ],
        methods: {
            changeSelect(value, type) {
                this[type] = value
            },

            fetchData(bikes) {
                let bike_id = '';

                axios.get('/get-sell-1/' + bikes.id).then(response => {
                    // this.models = response.data.models;
                    this.years = response.data.years;

                    this.checkModels(response.data.models);
                    console.log(response.data.models);
                });
            },

            checkModels(models) {
                this.models = models;
                let selectedModels = this.model;

                this.model = [];

                selectedModels.map((item, index) => {
                    this.models.map(model => {
                        if (model.id === item.id) {
                            this.model.push(model);
                        }
                    });
                });
            },

            submit(e) {
                e.preventDefault();
            },

        }
    }
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
</style>
