import { Vue, Component } from 'vue-property-decorator'
import { Config, InputParams, Router } from 'ziggy-js'

declare function routeFnc(name: string, params?: InputParams | any, absolute?: boolean, customZiggy?: Config): Router | any;

@Component
export default class Route extends Vue {
  // @ts-ignore
  route: typeof routeFnc = window.route;
}
