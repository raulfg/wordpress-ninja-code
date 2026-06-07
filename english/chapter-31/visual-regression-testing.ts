// tests/visual-baseline.spec.ts
import { test, expect } from '@playwright/test';

const pages = [
  { name: 'home',     url: '/' },
  { name: 'product',  url: '/product/example/' },
  { name: 'cart',     url: '/cart/' },
  { name: 'checkout', url: '/checkout/' },
];

for (const page of pages) {
  test(`capture ${page.name}`, async ({ page: p }) => {
    await p.goto(`https://staging.example.com${page.url}`);
    await p.waitForLoadState('networkidle');
    await expect(p).toHaveScreenshot(`${page.name}.png`);
  });
}
