import { Component, input, output } from '@angular/core';

@Component({
  selector: 'app-search',
  template: `
    <input
      type="search"
      [placeholder]="placeholder()"
      [attr.aria-label]="placeholder()"
      class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
      (input)="onInput($event)"
    />
  `,
})
export class Search {
  placeholder = input('Search...');
  valueChange = output<string>();

  protected onInput(event: Event) {
    this.valueChange.emit((event.target as HTMLInputElement).value);
  }
}
