export interface Option {
  name: string,
  value: string,
  selected ?: boolean,
}
export type MultiSelectOptions = Array<Option>
