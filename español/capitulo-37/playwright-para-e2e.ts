// tests/e2e/portfolio-filter.spec.ts

import { test, expect } from '@playwright/test';

test( 'el filtro de categorías actualiza el listado', async ( { page } ) => {
    await page.goto( '/portfolio/' );

    // Verificar que hay proyectos visibles
    const projectCards = page.locator( '.ninja-portfolio-item' );
    await expect( projectCards ).toHaveCount( 6 );

    // Hacer clic en una categoría
    await page.locator( '[data-category="web"]' ).click();

    // Verificar que el filtro se aplicó
    const visibleCards = page.locator( '.ninja-portfolio-item:visible' );
    await expect( visibleCards ).toHaveCountGreaterThan( 0 );

    // Todos los proyectos visibles deben tener la categoría seleccionada
    const categoryLabels = visibleCards.locator( '.portfolio-category' );
    for ( let i = 0; i < await categoryLabels.count(); i++ ) {
        await expect( categoryLabels.nth( i ) ).toContainText( 'Web' );
    }
} );

test( 'la página de proyecto individual carga correctamente', async ( { page } ) => {
    await page.goto( '/portfolio/' );

    const firstProject = page.locator( '.ninja-portfolio-item a' ).first();
    const projectTitle = await firstProject.textContent();

    await firstProject.click();

    await expect( page ).toHaveURL( /\/portfolio\// );
    await expect( page.locator( 'h1' ) ).toContainText( projectTitle ?? '' );
} );
