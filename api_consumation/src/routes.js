import { createRouter,createWebHistory } from 'vue-router';
import ResetPassword from './views/ResetPassword.vue'
import SignPage from './views/SignPage.vue'
import LandingPage from './views/LandingPage.vue'
import Dashboard from './views/Dashboard.vue'
import AddTournamentForm from './components/AddTournamentForm.vue'
import Footer from './components/Footer.vue'
import Profile from './components/Profile.vue'
import Test from './components/Test.vue'
import DashboardContent from './components/DashboardContent.vue'
import Users from './components/Users.vue'

const routes = [
    {
        path: '/',
        component: LandingPage,
    },
    {
        path: '/profile',
        component: Profile,
    },
    {
        path: '/dashboard',
        component: Dashboard,
        children : [
            {
                path: '',
                component: DashboardContent,
            },
            {
                path: 'profile',
                component: Profile,
                name: 'ownProfile'
            },
            {
                path: 'users',
                component: Users,
                name: 'users'
            },
        ]
    },
    {
        path: '/adding',
        component: AddTournamentForm,
    },
    {
        path: '/users',
        component: Users,
    },
    {
        path: '/test/:id',
        component: Test,
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: ResetPassword,
        props: route => ({
          token: route.query.token,
          email: route.query.email
        })
    },
    {
        path: '/sign',
        name: 'sign',
        component: SignPage,
        props: route => ({
          token: route.query.token,
          email: route.query.email
        })
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router