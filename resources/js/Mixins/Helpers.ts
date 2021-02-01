import { Vue, Component } from 'vue-property-decorator'
import _ from 'lodash'
import doesNotExist from '@/Shared/Helpers/doesNotExist'

@Component
export default class Helpers extends Vue {
  isNullOrUndefined = (_var: any) => (_.isNull(_var) || _.isUndefined(_var))

  doesNotExist = doesNotExist

  getWithDataAccessors(item: any, acss: any) {
    return acss.split('.').reduce((acc: any, part: any) => acc && acc[part], item)
  }
}
