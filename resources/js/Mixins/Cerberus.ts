import { Component, Vue } from 'vue-property-decorator'
import CerberusService from '@/Shared/Services/Cerberus/cerberus.service'
import { User } from '@/Shared/DataTable/Types/User'
import WildcardAuthorization from '@/Shared/Services/Cerberus/WildcardAuthorization'

@Component
export default class Cerberus extends Vue {
  // @ts-ignore
  Cerberus: CerberusService = new CerberusService(this.$page)

  // @ts-ignore
  can(_ability: string, _user: User = this.$page?.props?.user): boolean {
    // eslint-disable-next-line no-restricted-syntax,no-underscore-dangle
    for (const _userPermission of _user.authorizations) {
      const userPermission = new WildcardAuthorization(_userPermission)

      if (userPermission.implies(_ability)) {
        return true
      }
    }

    return false
    // TODO: Move this condition inside the cerberus package to enable better handling of partial wildcards ie. 'users-*'
  }
}
