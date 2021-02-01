import collect, { Collection } from 'collect.js'
import doesNotExist from '@/Shared/Helpers/doesNotExist'

export default class WildcardAuthorization {
  private readonly WILDCARD_TOKEN = '*'

  private readonly PART_DELIMITER = '-'

  private readonly SUBPART_DELIMITER = ','

  protected authorization: string

  protected parts: Collection<any>

  constructor(authorization: string) {
    this.authorization = authorization
    this.parts = collect()

    this.setParts()
  }

  public implies(_authorization: string | WildcardAuthorization): any {
    let authorization: WildcardAuthorization
    if (typeof _authorization === 'string') {
      authorization = new WildcardAuthorization(_authorization)
    } else {
      authorization = _authorization
    }

    const otherParts = authorization.getParts()

    let i = 0
    // eslint-disable-next-line no-restricted-syntax
    for (const otherPart of otherParts) {
      if (this.getParts().count() - 1 < i) {
        return true
      }

      if (!this.parts.get(i).contains(this.WILDCARD_TOKEN)
        && !this.containsAll(this.parts.get(i), otherPart)) {
        return false
      }
      // eslint-disable-next-line no-plusplus
      i++
    }

    // ⚠️ this loop must use the same "i" variable as the previous one.
    // eslint-disable-next-line no-plusplus
    for (i; i < this.parts.count(); i++) {
      if (!this.parts.get(i).contains(this.WILDCARD_TOKEN)) {
        return false
      }
    }

    return true
  }

  protected containsAll(part: Collection<any>, otherPart: Collection<any>): boolean {
    // eslint-disable-next-line no-restricted-syntax
    for (const item of otherPart.toArray()) {
      // console.log(part.contains(item))
      if (!part.contains(item)) {
        return false
      }
    }

    return true
  }

  public getParts(): Collection<any> {
    return this.parts
  }

  protected setParts(): void {
    if (doesNotExist(this.authorization)) {
      console.error('Bad Authorization Formatting:', this.authorization)
      return
    }

    const parts = collect(this.authorization.split(this.PART_DELIMITER))

    parts.each((item: string) => {
      const subParts = collect(item.split(this.SUBPART_DELIMITER))

      if (subParts.isEmpty() || subParts.contains('')) {
        console.error('Bad Authorization Formatting:', this.authorization)
        return
      }

      this.parts.push(subParts)
    })

    if (this.parts.isEmpty()) {
      console.error('Bad Authorization Formatting:', this.authorization)
    }
  }
}
