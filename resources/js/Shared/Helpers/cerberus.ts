/*
    ⚠️ UNABLE TO INJECT Inertia props
    TODO: Convert from helper to vue mixin
 */

import _ from 'lodash'
import axios from 'axios'

function getCurrentUserPermissions(): Array<string> | null {
  // @ts-ignore
  // eslint-disable-next-line no-undef
  axios.get(route('cerberus.authorizations.check', { ability: 'users-edit-account' })).then((r) => console.log(r))
  return null
}

// eslint-disable-next-line import/prefer-default-export
export function hasAuthorizationTo(_action: string) {
  return _.includes(getCurrentUserPermissions(), _action) // || _.includes(getCurrentUserPermissions(), '*')
}
