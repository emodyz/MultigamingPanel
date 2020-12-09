<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users <span class="text-gray-400">/</span> Edit / {{ userBeingEdited.name }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <edit-user-profile-form :errors="errors" :user="userBeingEdited"></edit-user-profile-form>
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">

import {Vue, Component, Prop} from 'vue-property-decorator'
import AppLayout from "@/Layouts/AppLayout.vue";
import {User} from "@/Shared/DataTable/Types/User";
import EditUserProfileForm from "@/Pages/Users/EditUserProfileForm.vue";


@Component({
    components: {
        AppLayout,
        EditUserProfileForm
    },
})
export default class UsersEdit extends Vue {
    @Prop() readonly userBeingEdited!: User
    @Prop() readonly errors!: any
}
</script>
