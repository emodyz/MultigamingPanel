import { Vue, Component } from 'vue-property-decorator'
import CerberusService from '@/Shared/Services/cerberus.service'

@Component
export default class Cerberus extends Vue {
  Cerberus: CerberusService = new CerberusService()
}
