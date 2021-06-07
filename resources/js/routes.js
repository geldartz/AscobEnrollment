export default [
    { path: '/dashboard', component: require('./components/Admin/Dashboard.vue').default },
    { path: '/maintenance', component: require('./components/Admin/Maintenance.vue').default },
    { path: '/subject-maintenance', component: require('./components/Admin/Subject.vue').default },
    { path: '/subject-scheduling', component: require('./components/Admin/Scheduling.vue').default },
    { path: '/student-management', component: require('./components/Admin/StudentManagement.vue').default },
    { path: '/student-requirements', component: require('./components/Admin/StudentRequirement.vue').default },
    { path: '/online-applications', component: require('./components/Admin/OnlineApplication.vue').default },
    { path: '/users', component: require('./components/Admin/Users.vue').default },
    
    { path: '/', component: require('./components/Homepage/Home.vue').default },
    { path: '/admission', component: require('./components/Homepage/Admission.vue').default },

    { path: '*', component: require('./components/NotFound.vue').default }
];
