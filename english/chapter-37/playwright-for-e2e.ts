// tests/e2e/portfolio-filter.spec.ts

import { test, expect } from '@playwright/test';

test( 'the category filter updates the listing', async ( { page } ) => {
    await page.goto( '/portfolio/' );

    // Verify projects are visible
    const projectCards = page.locator( '.ninja-portfolio-item' );
    await expect( projectCards ).toHaveCount( 6 );

    // Click a category
    await page.locator( '[data-category="web"]' ).click();

    // Verify the filter was applied
    const visibleCards = page.locator( '.ninja-portfolio-item:visible' );
    await expect( visibleCards ).toHaveCountGreaterThan( 0 );

    // All visible projects must belong to the selected category
    const categoryLabels = visibleCards.locator( '.portfolio-category' );
    for ( let i = 0; i < await categoryLabels.count(); i++ ) {
        await expect( categoryLabels.nth( i ) ).toContainText( 'Web' );
    }
} );

test( 'the individual project page loads correctly', async ( { page } ) => {
    await page.goto( '/portfolio/' );

    const firstProject = page.locator( '.ninja-portfolio-item a' ).first();
    const projectTitle = await firstProject.textContent();

    await firstProject.click();

    await expect( page ).toHaveURL( /\/portfolio\// );
    await expect( page.locator( 'h1' ) ).toContainText( projectTitle ?? '' );
} );
