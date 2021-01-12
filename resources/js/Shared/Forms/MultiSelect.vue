<style scoped>
.top-100 {
    top: 100%
}

.bottom-100 {
    bottom: 100%
}

.max-h-select {
    max-height: 300px;
}
</style>

<template>
  <div v-click-outside="handleClickOutside" class="w-full flex flex-col items-center h-auto z-20">
    <div class="w-full">
      <div class="flex flex-col items-center relative">
        <div class="w-full">
          <div class="form-input my-2 p-1 flex border bg-white rounded-md shadow-sm">
            <div class="flex flex-auto flex-wrap">
              <template v-if="tags">
                <template v-for="option in options">
                  <div v-if="option.selected"
                       :key="option.value"
                       class="flex justify-center items-center m-1 font-medium py-1 px-2 rounded-full text-indigo-700 bg-indigo-100 border border-indigo-300 ">
                    <div class="text-xs font-normal leading-none max-w-full flex-initial">{{ option.name }}</div>
                    <div class="flex flex-auto flex-row-reverse">
                      <div @click="handleOptionSelection(option)" class="hover:text-indigo-500 hover:cursor-pointer">
                        <cross-icon class="cursor-pointer hover:text-indigo-400 rounded-full"/>
                      </div>
                    </div>
                  </div>
                </template>
              </template>
              <div class="flex-1">
                <input :placeholder="placeholder"
                       v-model="searchOption"
                       class="bg-transparent py-1 px-1 appearance-none outline-none h-full w-full text-gray-800">
              </div>
              <div v-show="!_.isNull(searchResults)" @click="searchOption = ''"
                   class="justify-self-end text-indigo-700 pr-2 flex items-center">
                <cross-icon class="cursor-pointer hover:text-indigo-400 rounded-full"/>
              </div>
            </div>
            <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 ">
              <button
                  type="button"
                  @click="handleSowOption()"
                  :disabled="!_.isNull(searchResults)"
                  class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none disabled:cursor-not-allowed disabled:text-gray-300"
              >
                <chevron-down v-if="!isOpened"/>
                <chevron-up v-else/>
              </button>
            </div>
          </div>
        </div>
        <!-- DROPDOWN -->
        <div v-show="isOpened"
             class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto">
          <div class="flex flex-col w-full">
            <template v-for="option in options">
              <div :key="option.value" @click="handleOptionSelection(option)"
                   class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-indigo-100">
                <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative"
                     :class="option.selected ? 'border-indigo-700' : 'hover:border-indigo-100'">
                  <div class="w-full items-center flex">
                    <div v-if="_.isNull(option.component)" class="mx-2 leading-6">{{ option.name }}</div>
                    <component v-else :is="option.component.instance" :name="option.name" v-bind="{...option.component.properties}"/>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
        <!-- TODO: Combine Dropdown and search results into one reusable scaffolding component -->
        <!-- SEARCH RESULTS -->
        <div v-if="!_.isNull(searchResults)"
             class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto">
          <div class="flex flex-col w-full">
            <template v-for="option in searchResults">
              <div :key="option.value" @click="handleOptionSelection(option)"
                   class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-indigo-100">
                <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative"
                     :class="option.selected ? 'border-indigo-700' : 'hover:border-indigo-100'">
                  <div class="w-full items-center flex">
                    <div v-if="_.isNull(option.component)" class="mx-2 leading-6">{{ option.name }}</div>
                    <component v-else :is="option.component.instance" :name="option.name" v-bind="{...option.component.properties}"/>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {
  Vue, Component, Prop, Watch,
} from 'vue-property-decorator'
import _ from 'lodash'
import CrossIcon from '@/Shared/Svgs/CrossIcon.vue'
import ChevronDown from '@/Shared/Svgs/ChevronDown.vue'
import ChevronUp from '@/Shared/Svgs/ChevronUp.vue'
import { MultiSelectOptions, Option } from '@/Shared/Forms/Types/MultiSelectOptions'
// @ts-ignore
import vClickOutside from 'v-click-outside'

@Component({
  components: {
    CrossIcon,
    ChevronDown,
    ChevronUp,
  },
  directives: {
    clickOutside: vClickOutside.directive,
  },
})
/**
 * ⚠️ v-model implementation for this component is readonly ⚠️
 */
export default class MultiSelect extends Vue {
  @Prop({
    type: Array,
    required: true,
  }) readonly optionsList !: MultiSelectOptions

  @Prop({
    type: String,
    required: true,
  }) readonly placeholder !: string

  @Prop({
    type: Boolean,
    default: false,
  }) readonly tags !: boolean

  @Prop({
    type: Object,
    default: null,
  }) readonly comp !: any

  @Prop() value!:any

  isOpened = false

  options = this.initOptions(this.optionsList)

  searchOption = ''

  searchResults: any = null

  @Watch('searchOption')
  onSearchOptionChanged(val: any) {
    if (val !== '') {
      this.isOpened = false
      this.searchResults = this.getSearchResults(val)
    } else {
      this.searchResults = null
    }
  }

  @Watch('options')
  onOptionChanged() {
    this.$emit('input', this.getSelectedOptions())
  }

  shouldWatchValue = true

  shouldAllowWatchValue = true

  @Watch('value')
  onValueChanged(val: any) {
    if (this.shouldWatchValue) {
      this.setSelectedOptions(val)
    } else if (this.shouldAllowWatchValue) {
      this.shouldWatchValue = true
    }
  }

  initOptions(_opts: Array<any>) {
    if (_.isNull(_opts)) {
      return []
    }

    _opts.forEach((val) => {
      if (_.isNull(val.selected)) {
        const mVal = val
        mVal.selected = false
        this.options[this.options.indexOf(val)] = mVal
      }
    })

    return _opts
  }

  handleSowOption() {
    this.isOpened = !this.isOpened
  }

  handleOptionSelection(_opt: any) {
    const mOpt = _opt
    mOpt.selected = !_opt.selected
    this.$set(this.options, this.options.indexOf(_opt), mOpt)
  }

  getSelectedOptions() {
    const rv: any[] = []

    _.filter(this.options, 'selected')
      .forEach((val: Option) => {
        rv.push(val.value)
      })

    return rv
  }

  setSelectedOptions(_toSelect: Array<any>) {
    let itemsProcessed = 0
    this.shouldWatchValue = false
    this.shouldAllowWatchValue = false
    this.options
      .forEach((val: Option) => {
        if (_toSelect.find((e) => e === val.value)) {
          const mOpt = val
          mOpt.selected = true
          this.$set(this.options, this.options.indexOf(val), mOpt)
        } else {
          const mOpt = val
          mOpt.selected = false
          this.$set(this.options, this.options.indexOf(val), mOpt)
        }
        itemsProcessed += 1
        if (itemsProcessed === this.options.length) {
          this.shouldAllowWatchValue = true
        }
      })
  }

  getSearchResults(val: string) {
    return _.filter(this.options, (s) => s.name.toLowerCase()
      .startsWith(val.toLowerCase()))
  }

  handleClickOutside(e: any) {
    this.isOpened = false
    return e
  }
}
</script>
