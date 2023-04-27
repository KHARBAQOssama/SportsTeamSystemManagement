import { defineStore } from 'pinia'
import api from '@/api'
import { toRaw } from 'vue';

export const useBranchStore = defineStore('branch', {
    state: () => ({
        branches: [],
    }),
    actions: {
        fetchBranches() {
            api.get('/branch')
            .then((response) => {
                console.log(response.data)
                this.branches = response.data
            }).catch((err) => {
                console.log(err);
            });
        },
        async createBranch(data) {
            await api.post('/branch',data)
            .then((response) => {
                console.log(response.data)
                this.message = response.data.message
            }).catch((err) => {
                console.log(err);
            });
        },

    }
})