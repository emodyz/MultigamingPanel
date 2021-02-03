<template>
    <select v-model="selected"
            class="block w-full mt-1 rounded-md shadow-sm form-input"
            @change="$emit('selected', $event)">
        <option :value="null" :disabled="!canBeNull">
            {{ placeholder || 'Select an option' }}
        </option>
        <option v-for="option of options" :key="option.value" :value="option.value">{{ option.display }}</option>
    </select>
</template>

<script lang="ts">
import {
  Component, ModelSync, Prop, Vue,
} from 'vue-property-decorator'

export interface SelectOption {
  value: string | number;
  display: string;
}

@Component
export default class Select extends Vue {
  @ModelSync('select', 'change') readonly selected!: any

  @Prop({
    required: true,
  }) options!: SelectOption[]

  @Prop({
    type: String,
    default: null,
  }) placeholder!: string

  @Prop({
    type: Boolean,
    default: false,
  }) canBeNull!: boolean;
}
</script>
