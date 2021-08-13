<template>
    <section class="structured-search">

        <form :action="url" method="get" class="structured-search-form">
            <h1 class="font-light">{{ trans('__shop__.What is your dream bike') }}</h1>
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
                    :multiple="true"
                    :limit="4"
                    :show-no-results="true"
                    :hide-selected="true"
                    key="id"
                    @input="fetchData"
                >
                </multiselect>
                <input type="hidden" name="brand_ids" :value="JSON.stringify(brand_ids) ">
            </div>
            <div class="form-group">
                <multiselect
                    v-model="model"
                    :value="model"
                    label="name"
                    track-by="name"
                    :searchable="true"
                    :allow-empty="true"
                    :options="models"
                    placeholder="Models"
                    :multiple="true"
                    :limit="4"
                    :show-no-results="true"
                    :hide-selected="true"
                    @input="changeModels"
                >
                </multiselect>
                <input type="hidden" name="model_ids" :value="JSON.stringify(model_ids)">
            </div>
            <div class="form-group">
                <multiselect
                    v-model="year"
                    :searchable="false"
                    :allow-empty="true"
                    :options="years"
                    placeholder="Years"
                    :multiple="true"
                    :max="1"
                    :show-no-results="true"
                    :hide-selected="true"
                    @input="changeYear"
                >
                </multiselect>
                <input type="hidden" name="year" :value="JSON.stringify(year)">

            </div>
            <small style="color: red" class="text-danger" v-if="error">{{ trans('__shop__.All fields are required.') }}</small>
            <button type="submit" class="btn btn_green">{{ trans('__shop__.Lets go') }}</button>
        </form>

        <picture class="structured-bg">
            <source srcset="/img/structured-bg-2.webp" type="image/webp">
            <source srcset="/img/structured-bg-2.jpg" type="image/jpg">
            <img src="/img/structured-bg-2.jpg" alt="" width="1920" height="455">
        </picture>

    </section>
</template>

<script>
    import Multiselect from "vue-multiselect";

    export default {
        components: {
            Multiselect
        },
        data() {
            return {
                brand_ids: [],
                brand: [],
                model: [],
                model_ids: [],
                models: [],
                error: null,
                years: [],
                year: []
            }
        },
        name: "FilterSearchComponent",
        props: [
            'brands',
            'url',
        ],
        methods: {
            changeModels(models){
                models.forEach((model) => {
                    this.model_ids.push(model.id);
                });

            },
            changeYear(value){
                this.year = value;
            },

            changeSelect(value, type) {
                this[type] = value
            },

            fetchData(bikes) {
                this.brand_ids = [];
                bikes.forEach((bike) => {
                    this.brand_ids.push(bike.id);
                });

                if (!this.brand_ids.length) {
                    this.brand_ids = 0
                }
                axios.get('/get-buy/' + this.brand_ids).then(response => {
                    // this.models = response.data.models;
                    this.years = response.data.years;

                    if(!this.years.length){
                        this.year = null;
                    }
                    console.log(this.years)
                    this.checkModels(response.data.models);
                    // this.yearSelectValue(response.data.years);
                });
            },
            yearSelectValue(years){
                this.years = years;
                this.year = []

                // this..year_ids = [];
                years.forEach((year) => {
                    this.year.push(year);
                });

                console.log(this.years);
            },
            checkModels(models) {
                this.models = models;
                let selectedModels = this.model;
                this.model = [];
                this.model_ids = [];
                selectedModels.map((item, index) => {
                    this.models.map(model => {
                        if (model.id === item.id) {
                            this.model_ids.push(model.id);
                            this.model.push(model);
                        }
                    });
                });
            },

            submit(e) {
                e.preventDefault();
            },
        },
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

</style>
