<template>
    <div>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            class="mx-3"
            >
            <v-text-field
                v-model="eventName"
                label="Event"
                :rules="nameRules"
                required
                append-icon="book"
            ></v-text-field>
            <v-layout wrap>
                <v-flex xs6 sm6>
                    <v-menu
                        :close-on-content-click="false"
                        v-model="menufrom"
                        transition="scale-transition"
                        full-width
                        max-width="290px"
                        min-width="290px"
                        >
                        <template v-slot:activator="{on}">
                            <v-text-field
                            v-on="on"
                            label="Date From"
                            v-model="datefrom"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                        </template >
                        <v-date-picker v-model="datefrom" no-title @input="menufrom = false"></v-date-picker>
                    </v-menu>
                </v-flex>
                <v-flex xs6 sm6>
                    <v-menu
                        ref="menu1"
                        :close-on-content-click="false"
                        v-model="menuto"
                        transition="scale-transition"
                        offset-y
                        full-width
                        max-width="290px"
                        min-width="290px"
                        >
                        <template v-slot:activator="{on}">
                            <v-text-field
                            v-on="on"
                            label="Date To"
                            v-model="dateto"
                            prepend-icon="event"
                            readonly
                            ></v-text-field>
                        </template >
                        <v-date-picker v-model="dateto" no-title @input="menuto = false"></v-date-picker>
                    </v-menu>
                </v-flex>
                <v-layout wrap justify-space-around>
                    <v-checkbox v-model="selectedDow" class="mx-2" :value="i" :label="dowFormatter(weekday)" v-for="(weekday, i) in dow" :key="i"></v-checkbox>
                </v-layout>
                
            </v-layout>
            <v-card-actions>
                <v-btn
                    :disabled="!valid"
                    color="green"
                    @click="validate"
                    class="white--text success"
                    >
                    Save
                    <v-icon right dark>cloud_upload</v-icon>
                </v-btn>
            </v-card-actions>
        </v-form>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    data () {
      return {
        nameRules: [
            v => !!v || 'Name is required'
        ],
        selectedDow:[],
        dow:moment.weekdays(),
        valid: true,
        eventName:"",
        datefrom: null,
        dateto:null,
        menufrom: false,
        menuto:false,
        modal: false
      }
    },
    computed: {
        
    },
    methods:{
        dowFormatter( val ){
            return val.slice(0,3);
        },
        validate () {
            if (this.$refs.form.validate()) {
                this.snackbar = true
                let payload = {
                    event:this.eventName,
                    dow:this.selectedDow,
                    datefrom:this.datefrom,
                    dateto:this.dateto
                };

                this.$emit('save', payload);

            }
        },
    }
    
}
</script>

<style>

</style>
