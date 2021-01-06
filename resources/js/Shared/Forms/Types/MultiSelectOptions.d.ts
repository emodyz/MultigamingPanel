export interface Option {
  name: string,
  value: string | number | null,
  selected ?: boolean,
}
export type MultiSelectOptions = Array<Option>
