import { Vue, Component } from 'vue-property-decorator'
import _ from 'lodash'

@Component
export default class Helpers extends Vue {
  isNullOrUndefined = (_var: any) => (_.isNull(_var) || _.isUndefined(_var))

  doesNotExist = (_var: any) => (_.isNull(_var) || _.isUndefined(_var) || _.isNaN(_var) || _.isEmpty(_var))
}
