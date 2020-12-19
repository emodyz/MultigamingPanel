import axios, { AxiosInstance } from 'axios'

class CerberusService {
  private static instance: CerberusService

  private http: AxiosInstance

  // eslint-disable-next-line no-useless-constructor
  private constructor(baseUrl: string | null) {
    // do something construct...
    this.http = axios.create( )
  }

  static getInstance(baseUrl: string | null = null) {
    if (!CerberusService.instance) {
      CerberusService.instance = new CerberusService(baseUrl)
      // ... any one time initialization goes here ...
    }
    return CerberusService.instance
  }

  someMethod() { }
}

export default CerberusService.getInstance()
