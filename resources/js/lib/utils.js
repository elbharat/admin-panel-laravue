import { cva } from 'class-variance-authority';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs) {
  return twMerge(inputs.filter(Boolean).join(' '));
}

export function valueUpdater(updaterOrValue, ref) {
  ref.value =
    typeof updaterOrValue === 'function'
      ? updaterOrValue(ref.value)
      : updaterOrValue;
}
