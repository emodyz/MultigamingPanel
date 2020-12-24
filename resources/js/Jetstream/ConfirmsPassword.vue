<template>
  <span>
    <span @click="startConfirmingPassword">
      <slot />
    </span>

    <jet-dialog-modal
      :show="confirmingPassword"
      @close="confirmingPassword = false"
    >
      <template #title>
        {{ title }}
      </template>

      <template #content>
        {{ content }}

        <div class="mt-4">
          <jet-input
            ref="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-3/4"
            placeholder="Password"
            @keyup.enter.native="confirmPassword"
          />

          <jet-input-error
            :message="form.error"
            class="mt-2"
          />
        </div>
      </template>

      <template #footer>
        <jet-secondary-button @click.native="confirmingPassword = false">
          Nevermind
        </jet-secondary-button>

        <jet-button
          class="ml-2"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          @click.native="confirmPassword"
        >
          {{ button }}
        </jet-button>
      </template>
    </jet-dialog-modal>
  </span>
</template>

<script lang="ts">
import {
  Vue, Component, Prop, Ref,
} from 'vue-property-decorator'

import axios from 'axios'

import JetButton from './Button.vue'
import JetDialogModal from './DialogModal.vue'
import JetInput from './Input.vue'
import JetInputError from './InputError.vue'
import JetSecondaryButton from './SecondaryButton.vue'

@Component({
  components: {
    JetButton,
    JetDialogModal,
    JetInput,
    JetInputError,
    JetSecondaryButton,
  },
})
export default class ConfirmsPassword extends Vue {
    @Ref('password') readonly password!: any

    @Prop() readonly errors!: Object

    @Prop({ default: 'Confirm Password' }) readonly title!: string

    @Prop({ default: 'For your security, please confirm your password to continue.' }) readonly content!: string

    @Prop({ default: 'Confirm' }) readonly button!: string

    confirmingPassword: boolean = false

    form: any = {
      password: '',
      processing: false,
      error: '',
    }

    startConfirmingPassword() {
      this.form.error = ''

      // @ts-ignore
      // eslint-disable-next-line no-undef
      axios.get(route('password.confirmation').url()).then((response) => {
        if (response.data.confirmed) {
          this.$emit('confirmed')
        } else {
          this.confirmingPassword = true
          this.form.password = ''

          setTimeout(() => {
            this.password.focus()
          }, 250)
        }
      })
    }

    confirmPassword() {
      this.form.processing = true

      // @ts-ignore
      // eslint-disable-next-line no-undef
      axios.post(route('password.confirm').url(), {
        password: this.form.password,
        // eslint-disable-next-line no-unused-vars
      }).then((response) => {
        this.confirmingPassword = false
        this.form.password = ''
        this.form.error = ''
        this.form.processing = false

        this.$nextTick(() => this.$emit('confirmed'))
      }).catch((error) => {
        this.form.processing = false
        this.form.error = error.response.data.errors.password[0]
      })
    }
}
/*
    import JetButton from './Button'
    import JetDialogModal from './DialogModal'
    import JetInput from './Input'
    import JetInputError from './InputError'
    import JetSecondaryButton from './SecondaryButton'

    export default {
        props: {
            title: {
                default: 'Confirm Password',
            },
            content: {
                default: 'For your security, please confirm your password to continue.',
            },
            button: {
                default: 'Confirm',
            }
        },

        components: {
            JetButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },

        data() {
            return {
                confirmingPassword: false,

                form: this.$inertia.form({
                    password: '',
                    error: '',
                }, {
                    bag: 'confirmPassword',
                })
            }
        },

        methods: {
            startConfirmingPassword() {
                this.form.error = '';

                axios.get(route('password.confirmation').url()).then(response => {
                    if (response.data.confirmed) {
                        this.$emit('confirmed');
                    } else {
                        this.confirmingPassword = true;
                        this.form.password = '';

                        setTimeout(() => {
                            this.$refs.password.focus()
                        }, 250)
                    }
                })
            },

            confirmPassword() {
                this.form.processing = true;

                axios.post(route('password.confirm').url(), {
                    password: this.form.password,
                }).then(response => {
                    this.confirmingPassword = false;
                    this.form.password = '';
                    this.form.error = '';
                    this.form.processing = false;

                    this.$nextTick(() => this.$emit('confirmed'));
                }).catch(error => {
                    this.form.processing = false;
                    this.form.error = error.response.data.errors.password[0];
                });
            }
        }
    }
 */
</script>
