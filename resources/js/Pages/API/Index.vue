<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                API Tokens
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <api-token-manager :tokens="tokens"
                                   :available-permissions="availablePermissions"
                                   :default-permissions="defaultPermissions"
                                   :errors="errors" />
            </div>
        </div>
    </app-layout>
</template>

<script lang="ts">
    import ApiTokenManager from './ApiTokenManager.vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'

    import { Vue, Component, Prop } from 'vue-property-decorator'

    @Component({
        components: {
            ApiTokenManager,
            AppLayout,
            JetSectionBorder,
        }
    })
    export default class TokenIndex extends Vue {
        @Prop() tokens!: any
        @Prop() availablePermissions!: any
        @Prop() defaultPermissions!: any
        @Prop() errors!: any
    }

    /*
    export default {
        props: [
            'tokens',
            'availablePermissions',
            'defaultPermissions',
            'errors'
        ],

        components: {
            ApiTokenManager,
            AppLayout,
            JetSectionBorder,
        },
    }*/
</script>
