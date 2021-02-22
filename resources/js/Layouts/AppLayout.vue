<template>
  <div>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
      <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 dark:text-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="flex-shrink-0 flex items-center">
                <inertia-link :href="route('dashboard')">
                  <jet-application-mark class="block h-9 w-auto"/>
                </inertia-link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <jet-nav-link
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                >
                  Dashboard
                </jet-nav-link>

                <jet-nav-link
                    v-if="can('users-index')"
                    :href="route('users.index')"
                    :active="route().current('users.*')"
                >
                  Users
                </jet-nav-link>

                <jet-nav-link
                    v-if="can('servers-index')"
                    :active="route().current('servers.*')"
                    :href="route('servers.index')">
                  Servers
                </jet-nav-link>

                <jet-nav-link
                    v-if="can('modpacks-index')"
                    :active="route().current('modpacks.*')"
                    :href="route('modpacks.index')">
                  ModPacks
                </jet-nav-link>

                <jet-nav-link
                    v-if="can('articles-index')"
                    :active="route().current('articles.*')"
                    :href="route('articles.index')">
                  Articles
                </jet-nav-link>

                <jet-nav-link
                    v-if="can('settings-edit')"
                    :href="route('settings.edit')"
                    :active="route().current('settings.*')"
                >
                  Settings
                </jet-nav-link>
              </div>
            </div>

            <!-- Right Section -->
            <div class="flex justify-between items-center">
              <!-- DARK SWITCH -->
              <theme-switch v-model="darkMode" />
              <!-- Settings Dropdown -->
              <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                  <jet-dropdown
                      align="right"
                      width="48"
                  >
                    <template #trigger>
                      <button
                          v-if="$page.props.jetstream.managesProfilePhotos"
                          class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:ring
                          focus:ring-gray-300 dark:focus:ring-indigo-400 transition duration-150 ease-in-out"
                      >
                        <img
                            class="h-10 w-10 rounded-full object-cover"
                            :src="$page.props.user.profile_photo_url"
                            :alt="$page.props.user.name"
                        >
                      </button>

                      <button
                          v-else
                          class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
                      >
                        <div>{{ $page.props.user.name }}</div>

                        <div class="ml-1">
                          <svg
                              class="fill-current h-4 w-4"
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 20 20"
                          >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                          </svg>
                        </div>
                      </button>
                    </template>

                    <template #content>
                      <!-- Account Management -->
                      <div class="text-left block px-4 py-2 text-xs text-gray-400">
                        Manage Account
                      </div>

                      <jet-dropdown-link :href="route('profile.show')">
                        Profile
                      </jet-dropdown-link>

                      <jet-dropdown-link
                          v-if="$page.props.jetstream.hasApiFeatures"
                          :href="route('api-tokens.index')"
                      >
                        API Tokens
                      </jet-dropdown-link>

                      <div class="border-t border-gray-100 dark:border-gray-600"/>

                      <!-- Team Management -->
                      <template v-if="$page.props.jetstream.hasTeamFeatures">
                        <div class="text-left block px-4 py-2 text-xs text-gray-400">
                          Manage Team
                        </div>

                        <!-- Team Settings -->
                        <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
                          Team Settings
                        </jet-dropdown-link>

                        <jet-dropdown-link
                            v-if="$page.props.jetstream.canCreateTeams"
                            :href="route('teams.create')"
                        >
                          Create New Team
                        </jet-dropdown-link>

                        <div class="border-t border-gray-100 dark:border-gray-600"/>

                        <!-- Team Switcher -->
                        <div class="text-left block px-4 py-2 text-xs text-gray-400">
                          Switch Teams
                        </div>

                        <template v-for="team in $page.props.user.all_teams">
                          <form
                              :key="team.id"
                              @submit.prevent="switchToTeam(team)"
                          >
                            <jet-dropdown-link as="button">
                              <div class="flex items-center">
                                <svg
                                    v-if="team.id == $page.props.user.current_team_id"
                                    class="mr-2 h-5 w-5 text-green-400"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                  <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>{{ team.name }}</div>
                              </div>
                            </jet-dropdown-link>
                          </form>
                        </template>

                        <div class="border-t border-gray-100 dark:border-gray-600"/>
                      </template>

                      <!-- Authentication -->
                      <form @submit.prevent="logout">
                        <jet-dropdown-link as="button">
                          Logout
                        </jet-dropdown-link>
                      </form>
                    </template>
                  </jet-dropdown>
                </div>
              </div>

              <!-- Hamburger -->
              <div class="-mr-2 flex items-center sm:hidden">
                <button
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500
                    hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition
                    duration-150 ease-in-out dark:hover:bg-gray-700 dark:focus:bg-gray-900 dark:text-gray-100"
                    @click="showingNavigationDropdown = ! showingNavigationDropdown"
                >
                  <svg
                      class="h-6 w-6"
                      stroke="currentColor"
                      fill="none"
                      viewBox="0 0 24 24"
                  >
                    <path
                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                    <path
                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
            class="sm:hidden"
        >
          <div class="pt-2 pb-3 space-y-1">
            <jet-responsive-nav-link
                :href="route('dashboard')"
                :active="route().current('dashboard')"
            >
              Dashboard
            </jet-responsive-nav-link>
            <jet-responsive-nav-link
                v-if="can('users-index')"
                :href="route('users.index')"
                :active="route().current('users.*')"
            >
              Users
            </jet-responsive-nav-link>
            <jet-responsive-nav-link
                v-if="can('servers-index')"
                :active="route().current('servers.*')"
                :href="route('servers.index')">
              Servers
            </jet-responsive-nav-link>
            <jet-responsive-nav-link
                v-if="can('modpacks-index')"
                :active="route().current('modpacks.*')"
                :href="route('modpacks.index')"
            >
              ModPacks
            </jet-responsive-nav-link>
            <jet-responsive-nav-link
                v-if="can('articles-index')"
                :active="route().current('articles.*')"
                :href="route('articles.index')"
            >
              Articles
            </jet-responsive-nav-link>
            <jet-responsive-nav-link
                v-if="can('settings-edit')"
                :active="route().current('settings.*')"
                :href="route('settings.edit')"
            >
              Settings
            </jet-responsive-nav-link>
          </div>

          <!-- Responsive Settings Options -->
          <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="flex items-center px-4">
              <div class="flex-shrink-0">
                <img
                    class="h-10 w-10 rounded-full object-cover"
                    :src="$page.props.user.profile_photo_url"
                    :alt="$page.props.user.name"
                >
              </div>

              <div class="ml-3">
                <div class="font-medium text-base text-gray-800 dark:text-gray-100">
                  {{ $page.props.user.name }}
                </div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">
                  {{ $page.props.user.email }}
                </div>
              </div>
            </div>

            <div class="mt-3 space-y-1">
              <jet-responsive-nav-link
                  :href="route('profile.show')"
                  :active="route().current('profile.show')"
              >
                Profile
              </jet-responsive-nav-link>

              <jet-responsive-nav-link
                  v-if="$page.props.jetstream.hasApiFeatures"
                  :href="route('api-tokens.index')"
                  :active="route().current('api-tokens.index')"
              >
                API Tokens
              </jet-responsive-nav-link>

              <!-- Authentication -->
              <form
                  method="POST"
                  @submit.prevent="logout"
              >
                <jet-responsive-nav-link as="button">
                  Logout
                </jet-responsive-nav-link>
              </form>

              <!-- Team Management -->
              <template v-if="$page.props.jetstream.hasTeamFeatures">
                <div class="border-t border-gray-200"/>

                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Team
                </div>

                <!-- Team Settings -->
                <jet-responsive-nav-link
                    :href="route('teams.show', $page.props.user.current_team)"
                    :active="route().current('teams.show')"
                >
                  Team Settings
                </jet-responsive-nav-link>

                <jet-responsive-nav-link
                    :href="route('teams.create')"
                    :active="route().current('teams.create')"
                >
                  Create New Team
                </jet-responsive-nav-link>

                <div class="border-t border-gray-200"/>

                <!-- Team Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Switch Teams
                </div>

                <template v-for="team in $page.props.user.all_teams">
                  <form
                      :key="team.id"
                      @submit.prevent="switchToTeam(team)"
                  >
                    <jet-responsive-nav-link as="button">
                      <div class="flex items-center">
                        <svg
                            v-if="team.id == $page.props.user.current_team_id"
                            class="mr-2 h-5 w-5 text-green-400"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>{{ team.name }}</div>
                      </div>
                    </jet-responsive-nav-link>
                  </form>
                </template>
              </template>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header"/>
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot/>
      </main>

      <!-- Modal Portal -->
      <portal-target
          name="modal"
          multiple
      />

      <!-- Notifications -->
      <!-- TODO: Add Support for multiple flashes -->
      <flash-notification v-if="!doesNotExist($page.props.flash.notifications)"
                          :flash="$page.props.flash.notifications[0]"/>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Mixins, Watch } from 'vue-property-decorator'

import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import FlashNotification from '@/Shared/Notifications/Flash.vue'

import axios from 'axios'
import Route from '@/Mixins/Route'
import Helpers from '@/Mixins/Helpers'
import Cerberus from '@/Mixins/Cerberus'
import ThemeSwitch from '@/Layouts/ThemeSwitch.vue'

@Component({
  components: {
    ThemeSwitch,
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    FlashNotification,
  },
})
export default class AppLayout extends Mixins(Route, Helpers, Cerberus) {
  showingNavigationDropdown: boolean = false

  store = localStorage

  darkMode = JSON.parse(this.store.getItem('darkMode'))

  @Watch('darkMode')
  onDarkModeChanged(isDark: any) {
    this.store.setItem('darkMode', isDark)
    this.switchTheme(isDark)
  }

  switchTheme(isDark: boolean) {
    const body = document.body

    if (isDark) {
      body.classList.add('dark')
    } else {
      body.classList.remove('dark')
    }
  }

  switchToTeam(team: any) {
    this.$inertia.put(this.route('current-team.update'), {
      team_id: team.id,
    }, {
      preserveState: false,
    })
  }

  logout() {
    axios.post(this.route('logout')
      .url())
      // eslint-disable-next-line no-unused-vars
      .then((response) => {
        window.location.href = '/'
      })
  }

  created() {
    this.switchTheme(this.darkMode)
  }
}
</script>
