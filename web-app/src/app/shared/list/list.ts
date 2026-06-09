import { Component, input } from '@angular/core';

@Component({
  selector: 'app-list',
  template: `
    <ul class="flex flex-col gap-2" [attr.aria-label]="label()">
      <ng-content />
    </ul>
  `,
})
export class List {
  label = input<string>();
}
