<template>
    <div>
        <md-button class="md-primary md-raised" @click="importContacts" v-if="contacts">Import Contacts</md-button>
        <md-table v-model="contacts" >
            <md-table-empty-state md-label="No Contacts Imported">
                <md-button class="md-primary md-raised" @click="importContacts">Import Contacts</md-button>
            </md-table-empty-state>
            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="ID">{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Name">{{ item.name }}</md-table-cell>
                <md-table-cell md-label="Email">{{ item.email }}</md-table-cell>
                <md-table-cell md-label="Phone">{{ item.phone }}</md-table-cell>
                <md-table-cell :md-label="attrib.key" v-for="attrib in item.custom_attributes" :key="attrib.id">{{ attrib.value }}</md-table-cell>
            </md-table-row>
        </md-table>
    </div>
</template>
<script>
import Contact from '../commons/services/import.js';
export default {
    data() {
        return {
            contacts: []
        }
    },
    created() {
        this.getContacts();
    },
    methods: {
        importContacts() {
            this.$router.push('create');
        },
        async getContacts() {
            try{
                const response = await Contact.get(this.uploadedFile)
                .then( response => {
                    this.contacts = [...response.data];
                })
                .catch(error => {
                    // this.resetForm()
                    // _.map( error.response.data.message, (val, key) => {
                    //     this.formValidation[key] = val.pop();
                    // });
                });

            }   catch (error) {
                console.log(error);
            }
        }
    }
}
</script>