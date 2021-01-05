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
    <div class="w-full md:w-1/2 flex flex-col items-center h-64 mx-auto">
        <button @click="logSelected">Log</button>
        <div class="w-full px-4">
            <div class="flex flex-col items-center relative">
                <div class="w-full">
                    <div class="my-2 p-1 flex border border-gray-200 bg-white rounded">
                        <div class="flex flex-auto flex-wrap">
                            <div v-for="option in options"
                                 v-show="option.selected"
                                 :key="option.value"
                                 class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-indigo-700 bg-indigo-100 border border-indigo-300 ">
                                <div class="text-xs font-normal leading-none max-w-full flex-initial">{{ option.name }}</div>
                                <div class="flex flex-auto flex-row-reverse">
                                    <div @click="unSelectOption(option)" class="hover:text-indigo-500 hover:cursor-pointer">
                                        <cross-icon/>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1">
                                <input placeholder=""
                                       class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800">
                            </div>
                        </div>
                        <div class="text-gray-300 w-8 py-1 pl-2 pr-1 border-l flex items-center border-gray-200 ">
                            <button @click="isOpened = !isOpened"
                                    class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                <chevron-down v-if="!isOpened"/>
                                <chevron-up v-else/>
                            </button>
                        </div>
                    </div>
                </div>
                <div v-show="isOpened"
                     class="absolute shadow top-100 bg-white z-40 w-full lef-0 rounded max-h-select overflow-y-auto">
                    <div class="flex flex-col w-full">
                        <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-indigo-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-indigo-100">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">Python</div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-indigo-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative border-indigo-600">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">Javascript</div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-indigo-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative border-indigo-600">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">Ruby</div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-indigo-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-indigo-100">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">JAVA</div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-indigo-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-indigo-100">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">ASP.Net</div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-indigo-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-indigo-100">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">C++</div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer w-full border-gray-100 border-b hover:bg-indigo-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative hover:border-indigo-100">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">SQL</div>
                                </div>
                            </div>
                        </div>
                        <div class="cursor-pointer w-full border-gray-100 rounded-b hover:bg-indigo-100">
                            <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative border-indigo-600">
                                <div class="w-full items-center flex">
                                    <div class="mx-2 leading-6  ">HTML</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from 'vue-property-decorator'
import _ from 'lodash'
import CrossIcon from '@/Shared/Svgs/CrossIcon.vue'
import ChevronDown from '@/Shared/Svgs/ChevronDown.vue'
import ChevronUp from '@/Shared/Svgs/ChevronUp.vue'

@Component({
  components: {
    CrossIcon,
    ChevronDown,
    ChevronUp,
  },
})
export default class MultiSelect extends Vue {
  @Prop({
    type: Array,
    required: true,
  }) readonly optionsProp !: Array<any>

  isOpened = false

  options = this.initOptions(this.optionsProp)

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

  unSelectOption(_opt: any) {
    const mOpt = _opt
    mOpt.selected = false
    this.$set(this.options, this.options.indexOf(_opt), mOpt)
  }

  getSelectedOptions() {
    return _.filter(this.options, 'selected')
  }

  logSelected() {
    console.log(this.getSelectedOptions())
  }

  created() {
    this.options[0].selected = true
    this.options[2].selected = true
    this.options[5].selected = true
    this.logSelected()
  }
}
</script>
