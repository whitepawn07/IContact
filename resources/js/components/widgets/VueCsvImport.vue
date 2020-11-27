<template>
    <div class="vue-csv-uploader">
        <div class="form">
            <div class="vue-csv-uploader-part-one">
                <div class="form-group csv-import-file">
                    <div class="md-layout md-gutter md-alignment-center-center">
                        <md-chip class="md-primary" v-if="csv">{{fileName}}</md-chip>
                        <div class="md-layout-item md-size-25">
                            
                            <md-button class="md-raised" :md-ripple="false">Select File</md-button>
                            <input ref="csv" type="file" @change.prevent="validFileMimeType" class="form-control-file" name="csv">
                            <slot name="error" v-if="showErrorMessage">
                                <div class="invalid-feedback d-block">
                                    File type is invalid
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
            <div class="vue-csv-uploader-part-two">
                <div class="vue-csv-mapping" v-if="sample">
                    <table class="table">
                        <slot name="thead">
                            <thead>
                            <tr>
                                <th>Field</th>
                                <th>CSV Column</th>
                            </tr>
                            </thead>
                        </slot>
                        <tbody>
                        
                        <tr v-for="(field, key) in fieldsToMap" :key="key">
                            <td v-if="field.type !== 'string'">{{ field.label }}</td>
                            <td v-else>
                                input type
                            </td>
                            <td >
                                <select class='form-control' :name="`csv_uploader_map_${key}`" v-model="map[field.key]">
                                    <option v-for="(column, key) in firstRow" :key="key" :value="key">{{ column }}</option>
                                </select>
                            </td>
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
                <md-button class="md-primary" @click.prevent="submit" :disabled="disabledNextButton">Import</md-button>
            </div>
        </div>
    </div>
</template>

<script>
    import { drop, every, forEach, get, isArray, map, set, difference, values, keys, toNumber } from 'lodash';
    import axios from 'axios';
    import Papa from 'papaparse';
    import mimeTypes from "mime-types";

    export default {
        props: {
            value: Array,
            mapFields: {
                required: true
            },
            callback: {
                type: Function,
                default: () => ({})
            },
            validation: {
                type: Boolean,
                default: true,
            },
            fileMimeTypes: {
                type: Array,
                default: () => {
                    return ["text/csv", "text/x-csv", "application/vnd.ms-excel", "text/plain"];
                }
            }
        },

        data: () => ({
            isDisabled: true,
            form: {
                csv: null,
            },
            fileName: null,
            fieldsToMap: [],
            map: {},
            hasHeaders: true,
            csv: null,
            sample: null,
            isValidFileMimeType: false,
            fileSelected: false
        }),

        created() {
            this.fieldsToMap = map(this.mapFields, (item) => {
                return {
                    key: item,
                    label: item,
                    type: 'mapped'
                };
            });
        },

        methods: {
            submit() {
                const _this = this;
                this.$emit('input', this.form.csv);
                _this.callback(this.form.csv);
                this.$emit('canImport', true);
                
            },
            mappedCsv() {
                this.form.csv = this.buildMappedCsv();
                this.submit();
            },
            buildMappedCsv(csv) {
                const _this = this; 
                let mapped = map(csv, (row) => {
                    
                    let newRow = {};
                    forEach(_this.map, (column, field) => {
                        set(newRow, field, get(row, column));
                    });
                    
                    let extras = difference(map(values(keys(row)), toNumber), values(_this.map))

                    let extras_value = [];
                    map(extras, (column) => extras_value.push({'key': column, 'value': get(row, column)}) );
                    set(newRow, 'custom', extras_value);
                    return newRow;
                });
                
                return mapped;
            },
            validFileMimeType() {
                let file = this.$refs.csv.files[0];
                const mimeType = file.type === "" ? mimeTypes.lookup(file.name) : file.type;
                
                if (file) {
                    this.fileSelected = true;
                    this.isValidFileMimeType = this.validation ? this.validateMimeType(mimeType) : true;
                    this.fileName = file.name;
                    this.load();
                } else {
                    this.isValidFileMimeType = !this.validation;
                    this.fileSelected = false;
                }
            },
            validateMimeType(type) {
                return this.fileMimeTypes.indexOf(type) > -1;
            },
            load() {
                const _this = this;

                this.readFile((output) => {
                    _this.sample = get(Papa.parse(output, { preview: 2, skipEmptyLines: true }), "data");
                    _this.csv = get(Papa.parse(output, { skipEmptyLines: true }), "data");
                });
            },
            readFile(callback) {
                let file = this.$refs.csv.files[0];

                if (file) {
                    let reader = new FileReader();
                    reader.readAsText(file, "UTF-8");
                    reader.onload = function (evt) {
                        callback(evt.target.result);
                    };
                    reader.onerror = function () {
                    };
                }
            }
        },
        watch: {
            map: {
                deep: true,
                handler: function (newVal) {
                    let hasAllKeys = Array.isArray(this.mapFields) ? every(this.mapFields, function (item) {
                        return newVal.hasOwnProperty(item);
                    }) : every(this.mapFields, function (item, key) {
                        return newVal.hasOwnProperty(key);
                    });
                    
                    if (hasAllKeys) {
                        this.form.csv = this.buildMappedCsv(this.csv);
                    }
                    
                }
            }
        },
        computed: {
            firstRow() {
                return get(this, "sample.0");
            },
            showErrorMessage() {
                return this.fileSelected && !this.isValidFileMimeType;
            },
            disabledNextButton() {
                return !this.isValidFileMimeType || !this.form.csv;
            }
        },
    };
</script>