import { Vue, Component } from 'vue-property-decorator'
import {
  Config, RouteParamsWithQueryOverload, RouteParam, Router,
} from 'ziggy-js'

declare function routeFnc(name?: string, params?: RouteParamsWithQueryOverload | RouteParam, absolute?: boolean, config?: Config): Router | any;

@Component
export default class Route extends Vue {
  // @ts-ignore
  route: typeof routeFnc = window.route;
}
