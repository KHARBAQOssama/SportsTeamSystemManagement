import { createRouter,createWebHistory } from 'vue-router';
import ResetPassword from './views/ResetPassword.vue'
import SignPage from './views/SignPage.vue'
import NotFound from './views/404.vue'
import Forbidden from './views/403.vue'
import Home from './views/Home.vue'
import LandingPage from './views/LandingPage.vue'
import Store from './views/Store.vue'
import Dashboard from './views/Dashboard.vue'
import AddTournamentForm from './components/tournament/AddTournamentForm.vue'
import Profile from './components/Profile.vue'
import Tournaments from './components/Tournaments.vue'
import Products from './components/Products.vue'
import DashboardContent from './components/DashboardContent.vue'
import Users from './components/Users.vue'
import Games from './components/Games.vue'
import Branches from './components/Branches.vue'
import Blogs from './components/Blogs.vue'
import BlogDetails from './components/BlogDetails.vue'


import { authorize } from '@/middlewares/authorize'

const routes = [
    {
        path: '/',
        component: LandingPage,
        children :[
            {
                path: '',
                component: Home,
                name: 'home'
            },
            
        ]
    },
    {
        path: '/blogs/:id',
        component: BlogDetails,
        name: 'blogs-details',
        beforeEnter: authorize,
    },
    {
        path: '/404',
        component: NotFound,
    },
    {
        path: '/403',
        component: Forbidden,
    },
    {
        path: '/store',
        component: Store,
    },
    {
        path: '/profile',
        component: Profile,
    },
    {
        path: '/dashboard',
        component: Dashboard,
        meta: {
            roles: ['admin', 'sub-admin'],
        },
        beforeEnter: authorize,
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
            {
                path: 'Games',
                component: Games,
                name: 'games'
            },
            {
                path: 'Branches',
                component: Branches,
                name: 'branches'
            },
            {
                path: 'Blogs',
                component: Blogs,
                name: 'blogs'
            },
            {
                path: 'Blogs/:id',
                component: BlogDetails,
                name: 'blogs-details'
            },
            {
                path: 'tournaments',
                component: Tournaments,
                name: 'tournaments'
            },
            {
                path: 'products',
                component: Products,
                name: 'products'
            },
            {
                path: 'tournaments/add',
                component: AddTournamentForm,
                name: 'tournaments.add'
            },
        ]
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