import { Component, input } from '@angular/core';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-list-item',
  imports: [RouterLink],
  host: {
    class: 'block',
    role: 'listitem',
  },
  template: `
    @if (routerLink(); as routerLink) {
      <a
        [routerLink]="routerLink"
        class="flex items-center gap-3 rounded-xl bg-white p-4 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
      >
        <span class="flex size-9 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
          </svg>
        </span>
        <span class="text-sm font-medium text-gray-900">{{ name() }}</span>
      </a>
    } @else {
      <div class="flex items-center gap-3 rounded-xl bg-white p-4 shadow-sm">
        <span class="flex size-9 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
          </svg>
        </span>
        <span class="text-sm font-medium text-gray-900">{{ name() }}</span>
      </div>
    }
  `,
})
export class ListItem {
  name = input.required<string>();
  routerLink = input<string | unknown[]>();
}
