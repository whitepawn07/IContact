<template>
    <div class="sidebar">
        <div class="sidebar-wrapper">
            <slot name="content"></slot>
            <md-list class="nav">
                <slot>
                     <li class="md-list-item">
                        <router-link to="contacts" class="md-list-item-router md-list-item-container md-button-clean">
                        <div class="md-list-item-content md-ripple">
                            <slot>
                                <md-icon>import_contacts</md-icon>
                                <p>Import Contacts</p>
                            </slot>
                        </div>
                        </router-link>
                    </li>
                </slot>
            </md-list>
        </div>
    </div>
</template>