<template>
    <div class="container">
        <div style="max-height: 90vh; overflow: auto;">
            <table class="table table-striped table-bordered table-inverse">
                <thead class="thead-dark thead-inverse thead-sticky">
                    <tr>
                        <th colspan="6">
                            <input type="text" name="search" id="search" v-model="search" class="form-control" placeholder="Search for Label/Value" autofocus>
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center">#</th>
                        <th @click="$root.sortBy(lookups, 'label')">
                            <div class="w-100 d-flex justify-content-between">
                                <span>Label</span>
                                <span>
                                    <i v-if="$root.sort_i > 0 && $root.sort_key == 'label'" :class="($root.sort_i == 1) ? 'fa fa-sort-down':'fa fa-sort-up'"></i>
                                    <i v-else class="fa fa-sort text-gray-500"></i>
                                </span>
                            </div>
                        </th>
                        <th>Key</th>
                        <th @click="$root.sortBy(lookups, 'value')">
                            <div class="w-100 d-flex justify-content-between">
                                <span>Value</span>
                                <span>
                                    <i v-if="$root.sort_i > 0 && $root.sort_key == 'value'" :class="($root.sort_i == 1) ? 'fa fa-sort-down':'fa fa-sort-up'"></i>
                                    <i v-else class="fa fa-sort text-gray-500"></i>
                                </span>
                            </div>
                        </th>
                        <th @click="$root.sortBy(lookups, 'index')">
                            <div class="w-100 d-flex justify-content-between">
                                <span>Index</span>
                                <span>
                                    <i v-if="$root.sort_i > 0 && $root.sort_key == 'index'" :class="($root.sort_i == 1) ? 'fa fa-sort-down':'fa fa-sort-up'"></i>
                                    <i v-else class="fa fa-sort text-gray-500"></i>
                                </span>
                            </div>
                        </th> 
                        <th class="text-center">
                            <i class="fa fa-cog"></i>
                        </th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>
                            <input type="text" name="label" id="label" class="form-control" v-model="lookup.label" :class="(errors.label) ? 'is-invalid':''">
                        </th>
                        <th>
                            <input type="text" name="key" id="key" class="form-control" v-model="lookup.key" :class="(errors.key) ? 'is-invalid':''" :disabled="(lookup.key != null && editable)">
                        </th>
                        <th>
                            <input type="text" name="value" id="value" class="form-control" v-model="lookup.value" :class="(errors.value) ? 'is-invalid':''">
                        </th>
                        <th>
                            <input type="number" name="index" id="index" class="form-control w-100" v-model="lookup.index" :class="(errors.index) ? 'is-invalid':''" onkeypress="return (event.key >= '0' && event.key <= '9')" min="0">
                        </th>
                        <th>
                            <button class="btn btn-primary w-100" @click="addLookup" v-if="!editable"><i class="fa fa-plus"></i>&nbsp;Add</button>
                            <button class="btn btn-primary w-100" @click="updateLookup" v-else><i class="fa fa-save"></i>&nbsp;Save</button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, key) in lookups" :key="key">
                        <td> {{key+1}} </td>
                        <td> {{item.label}} </td>
                        <td> {{item.key}} </td>
                        <td> {{item.value}} </td>
                        <td> {{item.index}} </td>
                        <td class="d-flex justify-content-around">
                            <button type="button" v-if="item.id == lookup.id" class="btn btn-danger text-xs" @click="lookup = {}; editable = false;"><i class="fa fa-times" aria-hidden="true"></i></button>
                            <button class="btn btn-warning text-xs" v-else @click="lookup = item; editable = true;"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger text-xs" @click="deleteLookup(item)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr v-if="loading">
                        <td colspan="6" class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="lookups.length == 0 && loading == false">
                        <td colspan="6" class="bg-danger text-light text-center">No Results were Found.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            search: '', loading: true, editable: false,
            lookup: {
                label: null,
                key: null,
                value: null,
                index: null
            },
            bank: [], lookups: [], errors: []
        }
    },
    watch: {
        search (val) {
            val = val.toLowerCase();
            this.lookups = (this.bank).filter((v, k) => {
                return (v.label.toLowerCase().match(val) || v.key.toLowerCase().match(val) || v.value.toLowerCase().match(val))
            })
        }
    },
    methods: {
        addLookup () {
            axios.post('/Lookup', this.lookup).then(
                response => {
                    location.href = '/Lookup';
                    // this.lookups.push(response.data);
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        updateLookup () {
            axios.put(`/Lookup/${this.lookup.id}`, this.lookup).then(
                response => {
                    this.editable = true;
                    this.lookup = {
                        label: null,
                        key: null,
                        value: null,
                        index: null
                    };
                    this.bank = response.data;
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        deleteLookup (item) {
            axios.delete(`/Lookup/${item.id}`).then(
                response => {
                    this.search = "";
                    this.bank = response.data;
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        }
    },
    mounted () {
        axios.get('/Lookup/lookups').then(
            response => {
                this.loading = false;
                this.bank = this.lookups = response.data;
            }
        )
    }
}
</script>