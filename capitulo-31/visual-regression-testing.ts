// tests/visual-baseline.spec.ts
import { test, expect } from '@playwright/test';

const pages = [
  { name: 'home',     url: '/' },
  { name: 'producto', url: '/producto/ejemplo/' },
  { name: 'carrito',  url: '/carrito/' },
  { name: 'checkout', url: '/finalizar-compra/' },
];

for (const page of pages) {
  test(`captura ${page.name}`, async ({ page: p }) => {
    await p.goto(`https://staging.ejemplo.com${page.url}`);
    await p.waitForLoadState('networkidle');
    await expect(p).toHaveScreenshot(`${page.name}.png`);
  });
}
