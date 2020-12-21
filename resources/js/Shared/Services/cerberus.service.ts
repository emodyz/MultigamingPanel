import axios, { AxiosInstance } from 'axios'

class CerberusService {
  private http: AxiosInstance

  // eslint-disable-next-line no-useless-constructor
  constructor(baseUrl?: string | null) {
    // do something construct...
    this.http = axios
  }

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

export default CerberusService
