import { Component, Vue } from 'vue-property-decorator'
import CerberusService from '@/Shared/Services/cerberus.service'
import { User } from '@/Shared/DataTable/Types/User'

@Component
export default class Cerberus extends Vue {
  // @ts-ignore
  Cerberus: CerberusService = new CerberusService(this.$page)

  // @ts-ignore
  can(_ability: string, _user: User = this.$page?.props?.user) {
    // TODO: Move this condition inside the cerberus package to enable better handling of partial wildcards ie. 'users-*'
    return _user.authorizations.includes('*') || _user.authorizations.includes(_ability)
  }
}
