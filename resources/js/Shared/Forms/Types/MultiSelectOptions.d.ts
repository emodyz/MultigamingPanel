export interface Option {
  name: string,
  value: string | number | null,
  selected ?: boolean,
  component ?: {
    instance ?: any,
    properties?: any,
  }
}
export type MultiSelectOptions = Array<Option>
