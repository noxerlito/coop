import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
  connect() {
    console.log('cc');
  }

  static targets = [ "name" ]

  greet() {
    const element = this.nameTarget;
    const name = element.value;
    console.log(`Hello, ${name}!`);
  }
}
