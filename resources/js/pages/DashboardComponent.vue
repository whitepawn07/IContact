<template>
    <div class="content">
        <div class="md-layout">
            <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-100">
                 <md-card>
                    <md-card-header data-background-color="orange">
                        <h4 class="title">Contacts</h4>
                    </md-card-header>
                    <md-card-content>
                        <TableComponent></TableComponent>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>
<script>
import TableComponent from '../components/TableComponent.vue'
export default {
    components: {
        TableComponent,
    },
}
</script>