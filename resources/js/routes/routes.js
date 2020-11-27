export default [
    {
        path: '/login',
        name: 'Root',
        component: () => import (
            `../pages/LoginComponent.vue`
        ),
    },
    {
        path: '/',
        name: 'App',
        menu: true,
        component: () => import (
            `../components/MainComponent.vue`
        ),
        children: [
            {
                path: 'contacts',
                name: 'Import Contacts',
                component: () => import (`../pages/DashboardComponent.vue`)
            },
            {
                path: 'create',
                name: 'Add Contacts',
                component: () => import (`../pages/ImportContactsComponent.vue`)
            }
        ]
    }
];