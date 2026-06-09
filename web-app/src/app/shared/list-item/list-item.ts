import { Component, input } from '@angular/core';

@Component({
  selector: 'app-list-item',
  host: {
    class: 'flex items-center gap-3 rounded-xl bg-white p-4 shadow-sm',
    role: 'listitem',
  },
  template: `
    <span class="flex size-9 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
      <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
      </svg>
    </span>
    <span class="text-sm font-medium text-gray-900">{{ name() }}</span>
  `,
})
export class ListItem {
  name = input.required<string>();
}
