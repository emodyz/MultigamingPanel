<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

                <update-profile-information-form :errors="errors" :user="$page.props.user" />

                <jet-section-border />

                <update-password-form :errors="errors" class="mt-10 sm:mt-0" />

                <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                    <jet-section-border />

                    <two-factor-authentication-form :errors="errors" class="mt-10 sm:mt-0" />
                </div>

                <jet-section-border />

                <logout-other-browser-sessions-form :sessions="sessions" :errors="errors" class="mt-10 sm:mt-0" />

                <jet-section-border />

                <delete-user-form :errors="errors" class="mt-10 sm:mt-0" />
            </div>
        </div>
    </app-layout>
</template>

<script lang='ts'>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import DeleteUserForm from './DeleteUserForm.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
    import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm.vue'
    import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm.vue'
    import UpdatePasswordForm from './UpdatePasswordForm.vue'
    import UpdateProfileInformationForm from './UpdateProfileInformationForm.vue'

    import Vue from 'vue'
    import Component from 'vue-class-component'

    @Component({
        components: {
            AppLayout,
            DeleteUserForm,
            JetSectionBorder,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm
        },
        props: ['sessions', 'errors']
    })
    export default class Show extends Vue {
        //
    }

    /*

    export default {
        props: ['sessions'],

        components: {
            AppLayout,
            DeleteUserForm,
            /*
            JetSectionBorder,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,*/
       /* },
    }*/
</script>
