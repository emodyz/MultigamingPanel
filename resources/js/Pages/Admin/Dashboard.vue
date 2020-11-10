<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin <span class="text-gray-400">/</span> Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'

import { Vue, Component, Prop, PropSync, Ref } from 'vue-property-decorator'

@Component({
    components: {
        AdminLayout,
        Welcome,
    },
})
export default class AdminDashboard extends Vue {
    //
}
</script>
