import _ from 'lodash'

export default function doesNotExist(_var: any) {
  return (_.isNull(_var) || _.isUndefined(_var) || _.isNaN(_var) || _.isEmpty(_var))
}
