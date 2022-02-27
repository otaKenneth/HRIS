<template>
    <div class="row">
        <div class="form-group col-12 col-md-4 m-0">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" v-model="address" placeholder="Aa..." :class="(errors.address != '') ? 'is-invalid':''">
            <span v-if="errors.address" class="invalid-feedback" role="alert">
                <small>{{ errors.address }}</small>
            </span>
        </div>
        <div class="form-group col-12 col-md-4 m-0">
            <label for="town">Town/City</label>
            <select class="form-control" name="town" id="town" v-model="town" :class="(errors.town != '') ? 'is-invalid':''">
                <option v-for="(city, key) in temp_cities" :key="key" :value="key">{{city.name}}</option>
            </select>
            <span v-if="errors.town" class="invalid-feedback" role="alert">
                <small>{{ errors.town }}</small>
            </span>
        </div>
        <div class="form-group col-12 col-md-4 m-0">
            <label for="province">Province</label>
            <select class="form-control" name="province" id="province" v-model="prov_key" :class="(errors.province != '') ? 'is-invalid':''">
                <option v-for="(province, key) in provinces" :key="key" :value="key">{{province.name}}</option>
            </select>
            <span v-if="errors.province" class="invalid-feedback" role="alert">
                <small>{{ errors.province }}</small>
            </span>
        </div>
    </div>
</template>
<script>
export default {
    props: ['address', 'town', 'province','address_err','town_err','province_err'],
    data () {
        return {
            temp_cities: [],
            provinces: this.$root.ph_provinces,
            prov_key: this.province,
            errors: {
                address: this.address_err,
                town: this.town_err,
                province: this.province_err,
            },
        }
    },
    mounted () {
        this.temp_cities = (this.$root.ph_cities).filter(data => data.province == this.provinces[this.province].key);
    },
    watch:{
        prov_key (value) {
            if (value != null) {
                this.province = value;
                this.temp_cities = (this.$root.ph_cities).filter(data => data.province == this.provinces[value].key);
            }
        }
    }
}
</script>