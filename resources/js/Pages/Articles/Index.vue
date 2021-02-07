<template>
  <app-layout>
    <template #header>
      <h2 class="breadcrumb">
        Articles <span class="breadcrumb-separator">/</span> Index
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
        <data-table
            :query-url="'/articles'"
            :query-param="'articles'"
            :headers="headers"
            :data-object="articles"
            :initial-query="initialSearch"
            :actions="actions"
            :total-item-count="totalItemCount"
            class="w-full p-6">

            <template #action>
                <create-article-button/>
            </template>

        </data-table>
      </div>
    </div>
  </app-layout>
</template>

<script lang="ts">
import Pagination from '@/Shared/Pagination/Pagination.vue'
import JetInput from '@/Jetstream/Input.vue'
import DataTable from '@/Shared/DataTable/DataTable.vue'

import { Vue, Component, Prop } from 'vue-property-decorator'
import AppLayout from '@/Layouts/AppLayout.vue'
import { DataTableActionsOptions } from '@/Shared/DataTable/Types/DataTableActionsOptions'
import { DataTableHeader } from '@/Shared/DataTable/Types/DataTableHeader'
import CreateArticleButton from '@/Pages/Articles/Components/CreateArticleButton.vue'
import DtDate from '@/Shared/DataTable/Components/Date.vue'
import DtUserProfile from '@/Shared/DataTable/Components/UserProfile.vue'
import DtArticleTitle from '@/Shared/DataTable/Components/ArticleTitle.vue'
import DtArticleStatus from '@/Shared/DataTable/Components/ArticleStatus.vue'
import DeleteArticle from '@/Shared/DataTable/Components/Dialogs/DeleteArticle.vue'

@Component({
  components: {
    AppLayout,
    DataTable,
    Pagination,
    JetInput,
    CreateArticleButton,
  },
})
export default class UsersIndex extends Vue {
  @Prop() readonly articles!: null | object

  @Prop() readonly totalItemCount!: null | number

  @Prop() readonly initialSearch!: null | string

  headers: Array<DataTableHeader> = [
    {
      title: 'Title',
      key: 'title',
      component: DtArticleTitle,
    },
    {
      title: 'Written By',
      key: 'author.name',
      component: DtUserProfile,
      dataAccessors: {
        name: 'author.name',
        email: 'author.email',
        profile_photo_url: 'author.profile_photo_url',
      },
    },
    {
      title: 'Status',
      key: 'status',
      component: DtArticleStatus,
    },
    {
      title: 'Written On',
      key: 'created_at',
      component: DtDate,
      options: {
        type: 'Date.Formatted',
      },
    },
  ]

  actions: DataTableActionsOptions = {
    enabled: true,
    baseUrl: '/articles',
    destroyDialog: DeleteArticle,
    actions: [
      {
        displayName: 'Edit',
        enabled: true,
        path: 'edit',
        permission: 'articles-edit',
        type: 'edit',
        class: 'link-brand',
      },
      {
        displayName: 'Delete',
        enabled: true,
        permission: 'articles-destroy',
        type: 'destroy',
        class: 'link-danger',
      },
    ],
  }

  created() {
    // console.log(this.articles)
  }
}
</script>
