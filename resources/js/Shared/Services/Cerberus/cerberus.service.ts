import axios, { AxiosInstance } from 'axios'
import { User } from '@/Shared/DataTable/Types/User'

export default class CerberusService {
  private http: AxiosInstance

  private readonly user: User

  constructor(page: any, baseUrl?: string | null) {
    this.user = page?.props?.user
    this.http = axios
  }

  // can = (_ability: string) => this.user.authorizations.includes('*') || this.user.authorizations.includes(_ability)

  public async getAllAuthorizations() {
    try {
      // @ts-ignore
      const res = await this.http.get(route('cerberus.authorizations'))
      return res.data
    } catch (err) {
      return console.error(err)
    }
  }

  private async checkAuthorization(_ability: string) {
    try {
      // @ts-ignore
      const res = await this.http.get(route('cerberus.authorizations.check', { ability: _ability }))
      return res.data
    } catch (err) {
      return console.error(err)
    }
  }

  public async can(_ability: string) {
    return this.checkAuthorization(_ability)
  }
}
