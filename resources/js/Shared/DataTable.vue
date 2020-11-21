<template>
    <div>
        <jet-input class="w-1/4" type="search" placeholder="Search..." v-model="search"></jet-input>
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th v-for="item in headers">
                        {{ item.title }}
                    </th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in dataObject.data">
                    <th scope="row">
                        {{ index+1 }}
                    </th>
                    <td class="border px-4 py-2" v-for="{ key, type } in headers.slice(1)">
                        <span v-if="type === 'Date.Formatted'">
                            {{ $moment(item[key]).format('LLL') }}
                        </span>
                        <span v-else-if="type === 'Date.FromNow'">
                            {{ $moment(item[key]).fromNow() }}
                        </span>
                        <span v-else>
                            {{ item[key] }}
                        </span>
                    </td>
                    <td class="border px-4 py-2">None</td>
                </tr>
            </tbody>
        </table>
        <pagination class="justify-self-start" :links="dataObject.links"></pagination>
    </div>
</template>

<script lang="ts">
import Pagination from "@/Shared/Pagination.vue";
import JetInput from "@/Jetstream/Input.vue";

import {Vue, Component, Prop, Watch} from 'vue-property-decorator'

import { Inertia } from "@inertiajs/inertia";
import debounce from 'lodash/debounce';
import { stringify } from 'qs';


@Component({
    components: {
        Pagination,
        JetInput,
    },
})
export default class DataTable extends Vue {
    @Prop() readonly headers!: null | object
    @Prop() readonly dataObject!: null | object
    @Prop() readonly queryUrl: string
    @Prop() readonly queryParam: string
    @Prop() readonly initialSearch!: null | string

    @Watch('search')
    onSearchChanged = debounce((val, old) => {
        const query = stringify({
            search: val || undefined,
        });
        Inertia.visit(query ? `${this.queryUrl}?${query}` : this.queryUrl, {
            preserveScroll: true,
            preserveState: true,
            only: [this.queryParam],
        });
    }, 250)

    created() {
        console.log(this.dataObject)
    }

    search = this.initialSearch
}
</script>
