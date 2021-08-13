<template>
    <section class="shop-page">
        <div class="shop-container">

            <span class="close-icon close-filter"></span>

            <div class="shop-filter">

                <div class="shop-filter-content">

                    <input type="hidden" name="_token" :value="token">

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Price') }}</p>

                        <div class="price-group d-flex">
                            <div class="price-group-item">
                                <label for="price-from">{{ trans('__shop__.From') }}</label>
                                <input type="number"
                                       min="0"
                                       v-on:change="getBikes"
                                       name="min_price"
                                       class="form-control"
                                       placeholder="0 €"
                                       id="price-from"
                                       v-model="min_price"
                                >
                            </div>
                            <div class="price-group-item">
                                <label for="price-to">{{ trans('__shop__.To') }}</label>
                                <input type="number"
                                       min="0"
                                       v-on:change="getBikes"
                                       name="max_price"
                                       class="form-control"
                                       placeholder="15.000 €"
                                       id="price-to"
                                       v-model="max_price"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Brand') }}</p>
                        <multiselect
                            v-model="multiSelect.brands"
                            :value="brand"
                            label="name"
                            track-by="name"
                            :searchable="true"
                            :allow-empty="true"
                            :options="brands"
                            :placeholder="trans('__shop__.Brands')"
                            :multiple="true"
                            :limit="4"
                            :show-no-results="true"
                            :hide-selected="true"
                            key="id"
                            @input="fetchData"
                        >
                        </multiselect>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Model') }}</p>
                        <multiselect
                            name="model[]"
                            v-model="multiSelect.models"
                            :value="model"
                            label="name"
                            track-by="name"
                            :searchable="true"
                            :allow-empty="true"
                            :options="models"
                            :placeholder="trans('__shop__.Model')"
                            :multiple="true"
                            :limit="4"
                            :show-no-results="true"
                            :hide-selected="true"
                            @input="fetchDataM"
                        >
                        </multiselect>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Year') }}</p>
                        <multiselect
                            name="year[]"
                            v-model="multiSelect.years"
                            :searchable="true"
                            :allow-empty="true"
                            :options="years"
                            :placeholder="trans('__shop__.Years')"
                            :multiple="true"
                            :limit="4"
                            :show-no-results="true"
                            :hide-selected="true"
                            @input="fetchDataYear"
                        >
                        </multiselect>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Size') }}</p>


                        <multiselect
                            name="size[]"
                            v-model="multiSelect.sizes"
                            :searchable="true"
                            :allow-empty="true"
                            :options="sizes"
                            :placeholder="trans('__shop__.Size')"
                            :multiple="true"
                            :limit="4"
                            :show-no-results="true"
                            :hide-selected="true"
                            @input="fetchDataSizes"
                        >
                        </multiselect>

                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Components') }}</p>
                        <multiselect
                            name="component[]"
                            v-model="multiSelect.components"
                            label="name"
                            track-by="name"
                            :searchable="true"
                            :allow-empty="true"
                            :options="components"
                            :placeholder="trans('__shop__.Components')"
                            :multiple="true"
                            :limit="4"
                            :show-no-results="true"
                            :hide-selected="true"
                            @input="fetchDataCom"
                        >
                        </multiselect>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Colors') }}</p>
                        <div
                            class="form-group custom-checkbox-bg"
                        >
                            <span v-for="(color, key) in colors">
                                <input
                                    v-on:change="getBikes"
                                    type="checkbox"
                                    class="form-check-input"
                                    :id="'color' + color"
                                    :value="key"
                                    v-model="search_color"
                                    name="colors[]"
                                >
                                <label class="form-check-label" :for="'color' + color"><span class="black-in"
                                                                                             :style="{backgroundColor: color}"></span></label>
                            </span>

                        </div>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Condition') }}</p>
                        <div class="form-group custom-checkbox">
                            <input
                                v-on:change="getBikes"
                                type="checkbox"
                                class="form-check-input"
                                id="very_good"
                                value="Very Good"
                                v-model="search_condition"
                                name="condition[]"
                            >
                            <label class="form-check-label" for="very_good">{{ trans('__shop__.Very Good')}}</label>
                        </div>
                        <div class="form-group custom-checkbox">
                            <input
                                v-on:change="getBikes"
                                type="checkbox"
                                class="form-check-input"
                                id="good"
                                value="Good"
                                v-model="search_condition"
                            >
                            <label class="form-check-label" for="good">{{ trans('__shop__.Good')}}</label>
                        </div>
                        <div class="form-group custom-checkbox">
                            <input
                                v-on:change="getBikes"
                                type="checkbox"
                                class="form-check-input"
                                id="OK"
                                value="OK"
                                v-model="search_condition"
                            >
                            <label class="form-check-label" for="OK">{{ trans('__shop__.OK')}}</label>
                        </div>
                        <div class="form-group custom-checkbox">
                            <input
                                v-on:change="getBikes"
                                type="checkbox"
                                class="form-check-input"
                                id="poor"
                                value="Poor"
                                v-model="search_condition"
                            >
                            <label class="form-check-label" for="poor">{{ trans('__shop__.Poor')}}</label>
                        </div>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Categories') }}</p>
                        <div v-for="(category, index) in categories"
                             class="form-group custom-checkbox"
                             :class="{'d-none': index > more.categories}"
                        >
                            <input
                                v-on:change="getBikes"
                                type="checkbox"
                                class="form-check-input"
                                :id="'category' + category"
                                :value="category"
                                v-model="search_category"
                                name="categoryes[]"
                            >
                            <label class="form-check-label" :for="'category' + category">{{
                                    category ? category : ''
                                }}</label>
                        </div>

                        <span class="see-all" @click="moreFunction(categories, 'categories')">{{
                                more.categories != categories.length ? trans('__shop__.See all') : trans('__shop__.Hide')
                            }}</span>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Shifters') }}</p>
                        <div v-for="(shifter, index) in shifters"
                             class="form-group custom-checkbox"
                             :class="{'d-none': index > more.shifters}"
                        >
                            <input
                                v-on:change="getBikes"
                                type="checkbox"
                                class="form-check-input"
                                :id="'shifter' + shifter"
                                :value="shifter"
                                v-model="search_shifter"
                                name="shifter[]"
                            >
                            <label class="form-check-label" :for="'shifter' + shifter">{{
                                shifter ? shifter : ''
                                }}</label>
                        </div>
                        <span class="see-all" @click="moreFunction(shifters, 'shifters')">{{
                                more.shifters != shifters.length ? trans('__shop__.See all') : trans('__shop__.Hide')
                            }}</span>


                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Frame Material') }}</p>
                        <div v-for="(frame_material, index) in frame_materials"
                             class="form-group custom-checkbox"
                             :class="{'d-none': index > more.frame_materials}"
                        >
                            <input
                                v-on:change="getBikes"
                                type="checkbox"
                                class="form-check-input"
                                :id="'frame_material' + frame_material"
                                :value="frame_material"
                                v-model="search_frame_material"
                                name="frame_material[]"
                            >
                            <label class="form-check-label" :for="'frame_material' + frame_material">{{
                                frame_material ? frame_material : ''
                                }}</label>
                        </div>
                        <span class="see-all" @click="moreFunction(frame_materials, 'frame_materials')">{{
                                more.frame_materials != frame_materials.length ? trans('__shop__.See all') : trans('__shop__.Hide')
                            }}</span>
                    </div>

                    <div class="shop-filter-group">
                        <p>{{ trans('__shop__.Brake Types') }}</p>
                        <div v-for="(brake_type, index) in brake_types"
                             class="form-group custom-checkbox"
                             :class="{'d-none': index > more.brake_types}"
                        >
                            <input
                                v-on:change="getBikes"
                                type="checkbox"
                                class="form-check-input"
                                :id="'brake_type' + brake_type"
                                :value="brake_type"
                                v-model="search_brake_type"
                                name="brake_type[]"
                            >
                            <label class="form-check-label" :for="'brake_type' + brake_type">{{
                                brake_type ? brake_type : ''
                                }}</label>
                        </div>


                        <span class="see-all" @click="moreFunction(brake_types, 'brake_types')">{{
                                more.brake_types != brake_types.length ? trans('__shop__.See all') : trans('__shop__.Hide')
                            }}</span>
                    </div>

                    <div class="text-right">
                        <button @click="closeFilter" type="button" class="btn-cancel">
                            {{ trans('__shop__.Cancel filter') }}
                        </button>
                        <span v-if="auth" :class="{ 'd-none': !this.email_verified }">
                        <button :class="{ 'd-none': this.filter_save }" @click="saveFilter" type="button"
                                id="saveFilter" class="btn-cancel">
                            {{ trans('__shop__.Save filter') }}
                        </button>
                        <button :class="{ 'd-none': !this.filter_save }" @click="deleteFilter" type="button"
                                id="deleteFilter" class="btn-cancel">
                            {{ trans('__shop__.Delete filter') }}
                        </button>
                        </span>
                        <span v-else></span>
                    </div>
                    <!--                    </form>-->
                </div>
            </div>

            <div class="shop-content">

                <div class="shop-content-search">
                    <div class="shop-search">
                        <input type="search" name="search" class="form-control" :placeholder="trans('__shop__.Search')"
                               v-model="search"
                               v-on:change="getBikes">
                        <img src="/img/loupe.svg" alt="search" width="19" height="19">
                    </div>

                    <!--                    mobile open filter-->
                    <span class="open-filter"><img src="/img/filter.svg" width="16" height="16"
                                                   alt="Filter">{{ trans('__shop__.Filter') }}</span>
                    <div class="shop-sort">
                        <multiselect
                            v-model="sortsOptions"
                            label="name"
                            track-by="value"
                            :searchable="false"
                            :allow-empty="true"
                            :options="selectSorts"
                            :placeholder="trans('__shop__.Sort by')"
                            :multiple="false"
                            :limit="4"
                            :show-no-results="true"
                            :hide-selected="true"
                            key="id"
                            @input="sortByPrice"
                        >
                        </multiselect>
                    </div>
                </div>

                <div v-if="!bikes">
                    <h2>{{ trans('__shop__.No bike') }}</h2>
                </div>

                <div class="shop-item-container">
                    <div class="shop-item" v-if="bikes.length" v-for="bike in bikes">

                        <!--                        ete vacharvac e avelacnel  class="shop-item-sold"-->
                        <div class="">

                            <span class="sold_out">{{ trans('__shop__.Sold out') }}</span>
                            <div class="shop-item-img-block position-relative">

                                <a :href="`${shop_singl_url}${bike.slug}`">
                                    <span class="bike-new" v-if="typeof bike.check_time === 'string' && !bike.is_sold">
                                        {{ trans('__shop__.Bikes_availability_key') + ' ' + bike.check_time }}
                                    </span>
                                    <span class="bike-new" v-if="bike.is_new && !bike.check_time">
                                        {{ trans('__shop__.New') }}
                                   </span>
                                    <span class="bike-new" v-if="bike.is_sold">
                                        {{ trans('__shop__.Sold') }}
                                   </span>
                                    <img :src="bike.side_image || bike.image_path || `/img/heco-2.jpg`"
                                         alt="Diverge E5 Base" width="352" height="222" loading="lazy">

                                </a>
                                <div v-if="!bike.is_sold">
                                <span v-if="auth" @click="favorite(bike)" :class="{'active': bike.is_favorite}"
                                      class="heart-icon" title="Favorites"></span>
                                <span v-else data-hystmodal="#login-modal" class="heart-icon" title="Favoritessssssss"></span>
                                </div>
                            </div>

                            <div class="shop-item-info-block">
                                <div class="shop-item-title">
                                    <h2 title="">
                                        <a :href="`${shop_singl_url}${bike.slug}`"
                                           style="text-decoration: none; color: black">{{ bike.brand ? bike.brand.name :
                                            '' }}, {{
                                            bike.name
                                            }}</a>
                                    </h2>
                                    <div class="form-group checkbox-choose ml-auto" title="compare">
                                        <input type="checkbox" :id="`choose${bike.id}`"
                                               :checked="checkCompare(bike.id)"
                                               @change="compareBike(bike.id)" class="form-check-input">
                                        <label :for="`choose${bike.id}`" class="form-check-label">
                                        <span><img src="/img/scale.svg" alt="compare" width="21" height="20"
                                                   loading="lazy"></span>
                                        </label>
                                    </div>
                                </div>
                                <a :href="`${shop_singl_url}${bike.slug}`" style="text-decoration: none; color: black">
                                    <table>
                                        <tr>
                                            <td>{{ trans('__shop__.Year') }}</td>
                                            <td>{{ bike.year }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('__shop__.Size') }}</td>
                                            <td>{{ bike.frame_size }}</td>
                                        </tr>
                                    </table>
                                </a>

                                <div class="shop-item-price-block">
                                    <div class="shop-item-price">
                                        <!--                                    <del><span>1400</span> €</del>-->
                                        <p><span>{{ bike.price }}</span> {{ bike.msrp_currency }}</p>
                                    </div>
                                    <div class="text-right ml-auto">
                                        <a :href="`${shop_singl_url}${bike.slug}`"
                                           v-if="!bike.check_time && !bike.is_sold"
                                           class="btn btn_green">{{ trans('__shop__.Buy Now') }}</a>
                                        <a :href="`${shop_singl_url}${bike.slug}`"
                                           class="btn btn_green" v-if="bike.check_time || bike.is_sold">{{
                                            trans('__shop__.See details') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                filterShow: true,
                see_all_year: false,
                brand: [],
                models: [],
                model: [],
                bikes: [],
                sort: '',
                search_size: [],
                search_condition: [],
                search_category: [],
                search_frame_material: [],
                search_brake_type: [],
                search_shifter: [],
                search_color: [],
                min_price: [],
                max_price: [],
                page: 1,
                no_result: false,
                last_page: 1,
                modal: false,
                models_ids: [],
                token: $('meta[name="csrf-token"]').attr('content'),
                sortsOptions: null,
                selectSorts : [
                    {
                        name: trans.__shop__.MinPrice || 'Min price',
                        value: 'min_price'
                    },
                    {
                        name: trans.__shop__.MaxPrice || 'Max price',
                        value: 'max_price'
                    },
                    {
                        name: trans.__shop__.New || 'New',
                        value: 'new'
                    }
                ],

                multiSelect: {
                    brands: [],
                    sizes: [],
                    selected_sizes: [],
                    models: [],
                    components: [],
                    years: [],
                    brand_ids: [],
                    model_ids: [],
                    component_ids: [],
                    components_id: [],
                    year_ids: [],
                },

                more: {
                    components: 4,
                    categories: 4,
                    frame_materials: 4,
                    brake_types: 4,
                    shifters: 4,
                    years: 4,
                    sizes: 4,
                },

                shop_singl_url: `/${this.locale}/bike/`,

                search: null

            }
        },
        name: "ShopComponent",
        props: [
            'locale',
            'login',
            'register',
            'auth',
            'brands',
            'selected_brands',
            'selected_models',
            'brand_ids',
            'model_ids',
            'years',
            'components',
            'categories',
            'frame_materials',
            'brake_types',
            'shifters',
            'year',
            'sizes',
            'compare_ids',
            'compare_url',
            'filter_url',
            'json_data',
            'colors',
            'filter_save',
            'email_verified'
        ],
        methods: {

            saveFilter() {
                let params = {
                    search: this.search,
                    page: this.page,
                    sort: this.sort,
                    brand_ids: this.multiSelect.brand_ids,
                    model_ids: this.multiSelect.model_ids,
                    year: this.multiSelect.year_ids || this.year,
                    component_ids: this.multiSelect.components_id || this.component,
                    size: this.multiSelect.selected_sizes || this.size,
                    condition: this.search_condition,
                    category: this.search_category,
                    frame_material: this.search_frame_material,
                    brake_type: this.search_brake_type,
                    shifter: this.search_shifter,
                    color: this.search_color,
                    min_price: this.min_price,
                    max_price: this.max_price,
                };
                axios.post('/filtersave', {
                    params
                })
                    .then(resp => {
                        $('#saveFilter').hide();
                        $('#deleteFilter').show();

                        this.filter_save == !this.filter_save;
                    })
            },
            deleteFilter() {
                this.filter_save == !this.filter_save;
                axios.post('/filter/delete', {})
                    .then(resp => {
                        $('#saveFilter').show();
                        $('#deleteFilter').hide();
                        this.filter_save == !this.filter_save;
                    })
            },

            closeFilter() {
                window.location = '/shop';
            },

            getAllUrlParams(url = null) {
                if (!url) {
                    url = window.location.href;
                }

                var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

                var obj = {};

                if (queryString) {

                    queryString = queryString.split('#')[0];

                    var arr = queryString.split('&');

                    for (var i = 0; i < arr.length; i++) {

                        var a = arr[i].split('=');

                        var paramNum = undefined;
                        var paramName = a[0].replace(/\[\d*\]/, function (v) {
                            paramNum = v.slice(1, -1);
                            return '';
                        });

                        var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];

                        paramName = paramName.toLowerCase();

                        paramValue = paramValue.toLowerCase();

                        if (obj[paramName]) {

                            if (typeof obj[paramName] === 'string') {
                                obj[paramName] = [obj[paramName]];
                            }

                            if (typeof paramNum === 'undefined') {
                                obj[paramName].push(paramValue);
                            } else {
                                obj[paramName][paramNum] = paramValue;
                            }
                        } else {
                            obj[paramName] = paramValue;
                        }
                    }
                }

                return obj;
            },

            historyPushState(params = null, is_clear = null, page = null) {
                if (is_clear) {
                    history.pushState(null, null, page);
                } else {
                    let url = '', symbol = '?';

                    for (let key in params) {
                        let value = params[key];
                        if (typeof value != 'string') {
                            value = JSON.stringify(value);
                        }

                        url += `${symbol}${key}=${value}`;
                        symbol = '&'
                    }

                    history.pushState(params, '', url);
                }
            },

            moreFunction(arr, type) {
                if (this.more[type] === arr.length) {
                    this.more[type] = 4;
                } else {
                    this.more[type] = arr.length;
                }
            },
            checkCompare(bike_id) {
                for (let i in this.compare_ids) {
                    if (this.compare_ids[i] == bike_id) {
                        return true
                    }
                }

                return false
            },
            compareBike(bike_id) {
                axios.post(this.compare_url, {
                    id: bike_id
                })
                    .then(resp => {
                        resp = resp.data;
                        if (resp.count > 0) {
                            $('.compaireShow').show();
                        } else {
                            $('.compaireShow').hide();
                        }

                        $('#compaire_count').text(resp.count);
                    })
                    .catch(error => {
                        alert(window.trans.__shop__['You cannot add more than two bikes for comparison'] ?? 'You cannot add more than two bikes for comparison')
                        window.location.reload();
                    })
            },
            favorite(bake) {
                bake.is_favorite = !bake.is_favorite;
                axios.post('/favorite', {
                    id: bake.id,
                }).then(response => {
                    $('#favorites_count').text(response.data);
                });

            },
            handleScroll(event) {
                let bottomOfWindow = 800 + Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight > document.documentElement.offsetHeight
                if (bottomOfWindow && this.last_page > this.page) {
                    this.page++;
                    this.getBikes(false)
                }
            },
            sortByPrice(sort){
                this.sort = sort.value;
                this.getBikes();
            },
            fetchData(brands) {
                this.multiSelect.brand_ids = [];
                brands.forEach((bike) => {
                    this.multiSelect.brand_ids.push(bike.id);
                });

                if (!this.multiSelect.brand_ids.length) {
                    this.multiSelect.brand_ids = [0]
                }

                this.getBrandModels();
            },
            checkModels(models) {
                this.models = models;
                let selectedModels = this.multiSelect.models;
                this.multiSelect.model_ids = [];
                this.multiSelect.models = [];

                selectedModels.map((item, index) => {
                    this.models.map(model => {
                        if (model.id === item.id) {
                            this.multiSelect.model_ids.push(model.id);
                            this.multiSelect.models.push(model);
                        }
                    });
                });
            },
            getBrandModels() {
                if (!this.multiSelect.brand_ids.length) {
                    this.multiSelect.brand_ids = 0
                }
                axios.get('/get-filters/' + this.multiSelect.brand_ids).then(async response => {
                    await this.checkModels(response.data.models);
                    this.getBikes();
                });
            },
            fetchDataM(models) {
                this.multiSelect.model_ids = [];
                models.forEach((model) => {
                    this.multiSelect.model_ids.push(model.id);
                });

                this.getBikes();
            },
            fetchDataCom(components) {
                this.multiSelect.component_ids = [];
                components.forEach((component) => {
                    this.multiSelect.component_ids.push(component.id);
                });

                this.getBikes();
            },

            fetchDataSizes(sizes) {
                this.multiSelect.selected_sizes = [];
                sizes.forEach((size) => {
                    this.multiSelect.selected_sizes.push(size);
                });

                this.getBikes();
            },
            fetchDataYear(years) {
                this.multiSelect.year_ids = [];
                years.forEach((year) => {
                    this.multiSelect.year_ids.push(year);
                });

                this.getBikes();
            },
            getBikes(recreate_pagination = true) {
                let brand_id = [];
                let model_ids = [];
                this.multiSelect.components_id = [];
                this.last_page = 1;
                if (recreate_pagination) {
                    this.page = 1;
                }
                this.multiSelect.component_ids.forEach((component) => {
                    this.multiSelect.components_id.push(component);
                });

                let params = {
                    search: this.search,
                    page: this.page,
                    sort: this.sort,
                    brand_ids: this.multiSelect.brand_ids,
                    model_ids: this.multiSelect.model_ids,
                    year: this.multiSelect.year_ids || this.year,
                    component_ids: this.multiSelect.components_id || this.component,
                    size: this.multiSelect.selected_sizes || this.size,
                    condition: this.search_condition,
                    category: this.search_category,
                    frame_material: this.search_frame_material,
                    brake_type: this.search_brake_type,
                    shifter: this.search_shifter,
                    color: this.search_color,
                    min_price: this.min_price,
                    max_price: this.max_price,
                };

                this.historyPushState(params);

                axios.get('/filter', {
                    params: {
                        search: this.search,
                        page: this.page,
                        sort: this.sort,
                        brand_ids: this.multiSelect.brand_ids,
                        model_ids: this.multiSelect.model_ids,
                        model_ids: this.multiSelect.model_ids,
                        year: this.multiSelect.year_ids || this.year,
                        component_ids: this.multiSelect.components_id || this.component,
                        size: this.multiSelect.selected_sizes || this.size,
                        condition: this.search_condition,
                        category: this.search_category,
                        frame_material: this.search_frame_material,
                        brake_type: this.search_brake_type,
                        shifter: this.search_shifter,
                        color: this.search_color,
                        min_price: this.min_price,
                        max_price: this.max_price,
                    }
                }).then(response => {
                    if (this.page === 1) {
                        this.bikes = response.data.bikes.data;

                    } else {
                        this.bikes = this.bikes.concat(response.data.bikes.data);
                    }
                    this.last_page = response.data.last_page;
                });
            },

            changeSelect(value) {
                this.sort = value;
                this.getBikes();
            },

            getAndSetUrlParams() {
                let params = this.getAllUrlParams();

                this.search = this.json_data.search;
                this.page = params.page ?? '';
                this.sort = params.sort ?? '';
                this.multiSelect.brand_ids = this.json_data.brand_ids ? this.json_data.brand_ids : params.brand_ids ? JSON.parse(params.brand_ids) : [];
                this.multiSelect.model_ids = this.json_data.model_ids ? this.json_data.model_ids : params.model_ids ? JSON.parse(params.model_ids) : [];
                this.multiSelect.year_ids = this.json_data.year ? this.json_data.year : params.year ? JSON.parse(params.year) : [];
                this.multiSelect.components_id = params.components_id ? JSON.parse(params.components_id) : [];
                this.multiSelect.selected_sizes = this.json_data.size ? this.json_data.size : params.size ? JSON.parse(params.size) : [];
                this.search_condition = this.json_data.condition;
                this.search_category = params.category ? JSON.parse(params.category) : [];
                this.search_frame_material = params.frame_material ? JSON.parse(params.frame_material) : [];
                this.search_brake_type = params.brake_type ? JSON.parse(params.brake_type) : [];
                this.search_shifter = params.shifter ? JSON.parse(params.shifter) : [];
                this.search_color = this.json_data.color ?? [];
                this.min_price = params.min_price ?? '';
                this.max_price = params.max_price ?? '';
            },

            async init() {
                console.log(this.json_data)
                this.multiSelect.brands = this.selected_brands;
                this.multiSelect.models = this.selected_models;
                this.multiSelect.brand_ids = this.brand_ids;
                this.multiSelect.model_ids = this.model_ids;
                await this.getAndSetUrlParams();

                this.getBikes();
                this.getBrandModels();
            }

        },

        async created() {
            await this.init();
            if (this.year) {
                this.search_year = [this.year];
            } else {
                this.search_year == '';
            }

            if (this.size) {
                this.search_size = [this.size];
            } else {
                this.search_size == '';
            }

            window.addEventListener('scroll', this.handleScroll);
        },

    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped lang="scss">

    .check_time {
        position: absolute;
        left: 5px;
        top: 10px;
        white-space: nowrap;
    }

    .d-none {
        display: none;
    }

    .color-item {
        cursor: pointer;
        width: 32px;
        height: 32px;
        list-style-type: none;
        float: left;
        margin: 3px;
        border: 1px solid #DDD;
        border-radius: 5px;
        transition: transform 0.2s;
    }

</style>
